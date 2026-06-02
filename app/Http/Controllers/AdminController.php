<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use App\Models\Pemesanan;
use App\Models\Tiket;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    private function filteredTransaksiQuery(Request $request)
    {
        return Pemesanan::with(['tiket', 'user'])
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->status))
            ->when($request->filled('availability_status'), fn ($query) => $query->where('availability_status', $request->availability_status))
            ->when($request->filled('from'), fn ($query) => $query->whereDate('created_at', '>=', $request->from))
            ->when($request->filled('to'), fn ($query) => $query->whereDate('created_at', '<=', $request->to));
    }

    public function dashboard()
    {
        $months = collect(range(5, 0))->map(fn ($index) => now()->subMonths($index)->startOfMonth());
        $monthlyStats = $months->map(function (Carbon $month) {
            $query = Pemesanan::whereBetween('created_at', [
                $month->copy()->startOfMonth(),
                $month->copy()->endOfMonth(),
            ]);

            return [
                'label' => $month->format('M Y'),
                'pengunjung' => (clone $query)->sum('jumlah_tiket'),
                'pemesanan' => (clone $query)->count(),
                'pendapatan' => (clone $query)->where('status', 'lunas')->sum('total_harga'),
            ];
        });

        return view('admin.dashboard', [
            'totalTransaksi' => Pemesanan::count(),
            'transaksiPending' => Pemesanan::where('status', 'pending')->count(),
            'transaksiLunas' => Pemesanan::where('status', 'lunas')->count(),
            'totalMember' => User::where('role', 'user')->count(),
            'totalAdmin' => User::where('role', 'admin')->count(),
            'totalTiket' => Tiket::count(),
            'pendapatanLunas' => Pemesanan::where('status', 'lunas')->sum('total_harga'),
            'monthlyStats' => $monthlyStats,
        ]);
    }

    public function transaksi(Request $request)
    {
        $pemesanans = $this->filteredTransaksiQuery($request)->latest()->get();

        return view('admin.transaksi', compact('pemesanans'));
    }

    public function exportTransaksi(Request $request)
    {
        $pemesanans = $this->filteredTransaksiQuery($request)->oldest()->get();
        $fileName = 'rekap-transaksi-' . now()->format('Ymd-His') . '.csv';

        return response()->streamDownload(function () use ($pemesanans) {
            $handle = fopen('php://output', 'w');
            fputs($handle, "\xEF\xBB\xBF");
            fputcsv($handle, [
                'Tanggal',
                'ID Pengunjung',
                'Nama',
                'Email',
                'Tiket',
                'Paket',
                'Rental Tersedia',
                'Rental Kosong',
                'Jumlah Tiket',
                'Durasi Hari',
                'Total',
                'Status Bayar',
                'Status Ketersediaan',
                'Alasan Tolak',
            ]);

            foreach ($pemesanans as $pemesanan) {
                $rentals = collect($pemesanan->rental_items ?? [])
                    ->map(fn ($item) => $item['nama'] . ' x' . $item['jumlah'])
                    ->implode(', ');
                $unavailableRentals = collect($pemesanan->unavailable_rental_items ?? [])
                    ->map(fn ($item) => $item['nama'] . ' x' . $item['jumlah'])
                    ->implode(', ');

                fputcsv($handle, [
                    optional($pemesanan->created_at)->format('Y-m-d H:i'),
                    $pemesanan->user->id,
                    $pemesanan->user->name,
                    $pemesanan->user->email,
                    $pemesanan->tiket->nama_tiket,
                    $pemesanan->paket_camping,
                    $rentals,
                    $unavailableRentals,
                    $pemesanan->jumlah_tiket,
                    $pemesanan->durasi,
                    $pemesanan->total_harga,
                    $pemesanan->status,
                    $pemesanan->availability_status,
                    $pemesanan->catatan_admin,
                ]);
            }

            fclose($handle);
        }, $fileName, ['Content-Type' => 'text/csv']);
    }

    public function exportDashboard()
    {
        $months = collect(range(11, 0))->map(fn ($index) => now()->subMonths($index)->startOfMonth());
        $fileName = 'rekap-dashboard-' . now()->format('Ymd-His') . '.csv';

        return response()->streamDownload(function () use ($months) {
            $handle = fopen('php://output', 'w');
            fputs($handle, "\xEF\xBB\xBF");
            fputcsv($handle, ['Bulan', 'Total Pengunjung', 'Total Pemesanan', 'Total Pendapatan']);

            foreach ($months as $month) {
                $query = Pemesanan::whereBetween('created_at', [
                    $month->copy()->startOfMonth(),
                    $month->copy()->endOfMonth(),
                ]);

                fputcsv($handle, [
                    $month->format('Y-m'),
                    (clone $query)->sum('jumlah_tiket'),
                    (clone $query)->count(),
                    (clone $query)->where('status', 'lunas')->sum('total_harga'),
                ]);
            }

            fclose($handle);
        }, $fileName, ['Content-Type' => 'text/csv']);
    }

    public function editTransaksi(Pemesanan $pemesanan)
    {
        return view('admin.transaksi-edit', [
            'pemesanan' => $pemesanan->load(['tiket', 'user']),
            'tikets' => Tiket::orderBy('nama_tiket')->get(),
        ]);
    }

    public function updateTransaksi(Request $request, Pemesanan $pemesanan)
    {
        $validated = $request->validate([
            'tiket_id' => ['required', 'exists:tikets,id'],
            'jumlah_tiket' => ['required', 'integer', 'min:1'],
            'tanggal' => ['required', 'date'],
            'status' => ['required', 'in:pending,lunas'],
        ]);

        DB::transaction(function () use ($pemesanan, $validated) {
            $oldTiket = Tiket::whereKey($pemesanan->tiket_id)->lockForUpdate()->firstOrFail();
            $newTiket = Tiket::whereKey($validated['tiket_id'])->lockForUpdate()->firstOrFail();
            $hasReservedStock = $pemesanan->availability_status === 'approved';

            if ($hasReservedStock) {
                $oldTiket->increment('stok', $pemesanan->jumlah_tiket);

                if ($validated['jumlah_tiket'] > $newTiket->stok) {
                    back()
                        ->withErrors(['jumlah_tiket' => 'Stok tiket tidak mencukupi untuk perubahan ini.'])
                        ->withInput()
                        ->throwResponse();
                }

                $newTiket->decrement('stok', $validated['jumlah_tiket']);
            }

            $totalPerHari = ($newTiket->harga * $validated['jumlah_tiket']) + $pemesanan->harga_paket + $pemesanan->rental_total;

            $pemesanan->update([
                'tiket_id' => $newTiket->id,
                'jumlah_tiket' => $validated['jumlah_tiket'],
                'tanggal' => $validated['tanggal'],
                'total_harga' => $totalPerHari * $pemesanan->durasi,
                'status' => $validated['status'],
            ]);
        });

        return redirect()->route('admin.transaksi')->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroyTransaksi(Pemesanan $pemesanan)
    {
        DB::transaction(function () use ($pemesanan) {
            if ($pemesanan->availability_status === 'approved') {
                Tiket::whereKey($pemesanan->tiket_id)
                    ->lockForUpdate()
                    ->firstOrFail()
                    ->increment('stok', $pemesanan->jumlah_tiket);
            }

            $pemesanan->delete();
        });

        return redirect()->route('admin.transaksi')->with('success', 'Transaksi berhasil dihapus.');
    }

    // Ubah fungsi galeri() yang lama menjadi ini:
    public function galeri()
    {
        return view('admin.galeri', [
            'galeris' => Galeri::latest()->get(), // Mengambil data foto terbaru
        ]);
    }

    // Tambahkan fungsi untuk SIMPAN FOTO
    public function storeGaleri(Request $request)
    {
        $request->validate([
            'gambar' => 'required|image|mimes:jpeg,png,jpg,webp|max:3072', // Maksimal 3MB
            'judul' => 'nullable|string|max:255',
        ]);

        // Simpan file fisik ke folder 'storage/app/public/galeri'
        $path = $request->file('gambar')->store('galeri', 'public');

        Galeri::create([
            'gambar' => $path,
            'judul' => $request->judul,
        ]);

        return back()->with('success', 'Foto berhasil diunggah ke Galeri.');
    }

    // Tambahkan fungsi untuk HAPUS FOTO
    public function destroyGaleri($id)
    {
        $galeri = Galeri::findOrFail($id);

        // Hapus file fisiknya dari folder storage
        if (Storage::disk('public')->exists($galeri->gambar)) {
            Storage::disk('public')->delete($galeri->gambar);
        }

        // Hapus data dari database
        $galeri->delete();

        return back()->with('success', 'Foto berhasil dihapus.');
    }

    public function tiket()
    {
        return view('admin.tiket', [
            'tikets' => Tiket::orderBy('nama_tiket')->get(),
        ]);
    }

    public function storeTiket(Request $request)
    {
        // 1. Validasi input dari form modal
        $validated = $request->validate([
            'nama_tiket' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
        ]);

        // 2. Simpan data ke database
        Tiket::create($validated);

        // 3. Kembali ke halaman sebelumnya dengan pesan sukses
        return back()->with('success', 'Tiket wisata berhasil ditambahkan.');
    }

    public function updateTiket(Request $request, $id)
    {
        // 1. Validasi input
        $validated = $request->validate([
            'nama_tiket' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
        ]);

        // 2. Cari tiket dan update
        $tiket = Tiket::findOrFail($id);
        $tiket->update($validated);

        // 3. Kembali dengan pesan sukses
        return back()->with('success', 'Data tiket berhasil diperbarui.');
    }

    public function destroyTiket($id)
    {
        // 1. Cari tiket dan hapus
        $tiket = Tiket::findOrFail($id);
        $tiket->delete();

        // 2. Kembali dengan pesan sukses
        return back()->with('success', 'Tiket wisata berhasil dihapus.');
    }

    public function admins()
    {
        return view('admin.users', [
            'title' => 'Data Admin',
            'users' => User::where('role', 'admin')->latest()->get(),
        ]);
    }

    public function members()
    {
        return view('admin.users', [
            'title' => 'Data Member',
            'users' => User::where('role', 'user')->latest()->get(),
        ]);
    }

    public function verifikasi($id)
    {
        $pemesanan = Pemesanan::findOrFail($id);

        if ($pemesanan->availability_status !== 'approved') {
            return back()->withErrors(['pemesanan' => 'Pesanan belum dikonfirmasi tersedia.']);
        }

        $pemesanan->status = 'lunas';
        $pemesanan->save();

        return back()->with('success', 'Berhasil diverifikasi');
    }

    public function approveAvailability(Pemesanan $pemesanan)
    {
        if ($pemesanan->availability_status !== 'waiting') {
            return back()->withErrors(['pemesanan' => 'Pesanan ini sudah diproses.']);
        }

        DB::transaction(function () use ($pemesanan) {
            $tiket = Tiket::whereKey($pemesanan->tiket_id)->lockForUpdate()->firstOrFail();

            if ($pemesanan->jumlah_tiket > $tiket->stok) {
                back()
                    ->withErrors(['jumlah_tiket' => 'Stok tiket tidak mencukupi untuk menyetujui pesanan ini.'])
                    ->throwResponse();
            }

            $tiket->decrement('stok', $pemesanan->jumlah_tiket);

            $pemesanan->update([
                'availability_status' => 'approved',
                'catatan_admin' => null,
                'unavailable_rental_items' => null,
            ]);
        });

        return back()->with('success', 'Pesanan tersedia. Pengunjung sudah bisa lanjut pembayaran.');
    }

    public function partialAvailability(Request $request, Pemesanan $pemesanan)
    {
        if ($pemesanan->availability_status !== 'waiting') {
            return back()->withErrors(['pemesanan' => 'Pesanan ini sudah diproses.']);
        }

        $validated = $request->validate([
            'unavailable_items' => ['required', 'array', 'min:1'],
            'unavailable_items.*' => ['required', 'string'],
            'catatan_admin' => ['nullable', 'string', 'max:1000'],
        ]);

        $unavailableItems = collect($pemesanan->rental_items ?? [])
            ->whereIn('nama', $validated['unavailable_items'])
            ->values()
            ->all();

        if (empty($unavailableItems)) {
            return back()->withErrors(['unavailable_items' => 'Pilih minimal satu item rental yang kosong.']);
        }

        $itemNames = collect($unavailableItems)->pluck('nama')->implode(', ');

        $pemesanan->update([
            'availability_status' => 'partial',
            'unavailable_rental_items' => $unavailableItems,
            'catatan_admin' => ($validated['catatan_admin'] ?? null) ?: 'Item kosong: ' . $itemNames,
        ]);

        return back()->with('success', 'Item kosong dikirim ke riwayat pengunjung untuk dikonfirmasi.');
    }

    public function rejectAvailability(Request $request, Pemesanan $pemesanan)
    {
        if ($pemesanan->availability_status !== 'waiting') {
            return back()->withErrors(['pemesanan' => 'Pesanan ini sudah diproses.']);
        }

        $validated = $request->validate([
            'catatan_admin' => ['nullable', 'string', 'max:1000'],
        ]);

        $pemesanan->update([
            'availability_status' => 'rejected',
            'catatan_admin' => ($validated['catatan_admin'] ?? null) ?: 'Paket tidak tersedia.',
        ]);

        return back()->with('success', 'Pesanan ditandai tidak tersedia.');
    }
}
