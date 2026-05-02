<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use App\Models\Pemesanan;
use App\Models\Tiket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard', [
            'totalTransaksi' => Pemesanan::count(),
            'transaksiPending' => Pemesanan::where('status', 'pending')->count(),
            'transaksiLunas' => Pemesanan::where('status', 'lunas')->count(),
            'totalMember' => User::where('role', 'user')->count(),
            'totalAdmin' => User::where('role', 'admin')->count(),
            'totalTiket' => Tiket::count(),
            'pendapatanLunas' => Pemesanan::where('status', 'lunas')->sum('total_harga'),
        ]);
    }

    public function transaksi()
    {
        $pemesanans = Pemesanan::with(['tiket', 'user'])->latest()->get();

        return view('admin.transaksi', compact('pemesanans'));
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

            $oldTiket->increment('stok', $pemesanan->jumlah_tiket);

            if ($validated['jumlah_tiket'] > $newTiket->stok) {
                back()
                    ->withErrors(['jumlah_tiket' => 'Stok tiket tidak mencukupi untuk perubahan ini.'])
                    ->withInput()
                    ->throwResponse();
            }

            $newTiket->decrement('stok', $validated['jumlah_tiket']);

            $pemesanan->update([
                'tiket_id' => $newTiket->id,
                'jumlah_tiket' => $validated['jumlah_tiket'],
                'tanggal' => $validated['tanggal'],
                'total_harga' => $newTiket->harga * $validated['jumlah_tiket'],
                'status' => $validated['status'],
            ]);
        });

        return redirect()->route('admin.transaksi')->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroyTransaksi(Pemesanan $pemesanan)
    {
        DB::transaction(function () use ($pemesanan) {
            Tiket::whereKey($pemesanan->tiket_id)
                ->lockForUpdate()
                ->firstOrFail()
                ->increment('stok', $pemesanan->jumlah_tiket);

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
        $pemesanan->status = 'lunas';
        $pemesanan->save();

        return back()->with('success', 'Berhasil diverifikasi');
    }
}
