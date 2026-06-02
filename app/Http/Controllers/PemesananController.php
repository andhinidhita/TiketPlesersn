<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Models\Tiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;

class PemesananController extends Controller
{
    private function campingPackages(): array
    {
        return [
            'Paket A' => [
                'harga' => 275000,
                'fasilitas' => 'Tenda kaps 4, kasur 2, sleeping bag 2, matras 1, kursi set 1, listrik 1, kayu bakar 1',
            ],
            'Paket B' => [
                'harga' => 250000,
                'fasilitas' => 'Tenda kaps 4, kasur 3, sleeping bag 3, kursi set 1, listrik 1',
            ],
            'Paket C' => [
                'harga' => 185000,
                'fasilitas' => 'Tenda kaps 4, kasur 2, sleeping bag 2, kursi set 1',
            ],
            'Paket D' => [
                'harga' => 150000,
                'fasilitas' => 'Tenda kaps 4, kasur 3, sleeping bag 3',
            ],
            'Paket A+' => [
                'harga' => 450000,
                'fasilitas' => 'Tenda kaps 6-8, kasur oscar 4, sleeping bag 4, kursi PTL 1, kompor set',
            ],
            'Paket B+' => [
                'harga' => 500000,
                'fasilitas' => 'Tenda kaps 6-8, kasur busa 1, bantal guling 1, bed cover 1, kursi PTL 1, kompor set 1, tikar 1, kayu bakar 1, listrik 1',
            ],
            'Paket Camping Deck Weekday' => [
                'harga' => 500000,
                'fasilitas' => 'Tenda kaps 6-8, kasur busa, bantal guling, bed cover, alas spons, kursi set, kompor dan cooking set, listrik + lampu, free HTM 4 orang, free parkir, free MCK',
            ],
            'Paket Camping Deck Weekend' => [
                'harga' => 700000,
                'fasilitas' => 'Tenda kaps 6-8, kasur busa, bantal guling, bed cover, alas spons, kursi set, kompor dan cooking set, listrik + lampu, free HTM 4 orang, free parkir, free MCK',
            ],
        ];
    }

    private function rentalItems(): array
    {
        return [
            'Tenda kaps 4' => 50000,
            'Tenda kaps 6' => 100000,
            'Tenda kaps 8' => 150000,
            'Sleeping bag' => 20000,
            'Matras' => 10000,
            'Tikar' => 20000,
            'Kasur 60x180' => 20000,
            'Kompor portable' => 25000,
            'Kompor 2 tungku + gas' => 70000,
            'Grill pan' => 20000,
            'Flysheet + tiang' => 35000,
            'Flysheet' => 20000,
            'Gas refil' => 10000,
            'Hammock' => 15000,
            'Kayu bakar' => 15000,
            'Lampu + olor kabel' => 50000,
            'Kursi portable' => 20000,
            'Meja portable' => 20000,
            'Kursi set' => 50000,
        ];
    }

    public function index()
    {
        $tikets = Tiket::orderBy('nama_tiket')->get();
        $campingPackages = $this->campingPackages();
        $rentalItems = $this->rentalItems();

        return view('pemesanan.index', compact('tikets', 'campingPackages', 'rentalItems'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tiket_id' => 'required|exists:tikets,id',
            'jumlah_tiket' => 'required|integer|min:1',
            'tanggal' => 'required|date',
            'durasi' => 'required|integer|min:1',
            'paket_camping' => 'nullable|string',
            'rental_items' => 'nullable|array',
            'rental_items.*' => 'nullable|integer|min:0',
            'bukti_pembayaran' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $fileName = null;

        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            $fileName = Str::uuid() . '.' . $file->extension();
            $file->move(public_path('bukti'), $fileName);
        }

        $pemesanan = DB::transaction(function () use ($validated, $fileName) {
            $tiket = Tiket::whereKey($validated['tiket_id'])->lockForUpdate()->firstOrFail();
            $isCamping = str_contains(strtolower($tiket->nama_tiket), 'camping');
            $campingPackages = $this->campingPackages();
            $rentalPricelist = $this->rentalItems();
            $selectedPackage = null;
            $selectedRentals = [];
            $rentalTotal = 0;

            if ($isCamping) {
                if (empty($validated['paket_camping']) || ! array_key_exists($validated['paket_camping'], $campingPackages)) {
                    back()
                        ->withErrors(['paket_camping' => 'Pilih paket camping terlebih dahulu.'])
                        ->withInput()
                        ->throwResponse();
                }

                $selectedPackage = $campingPackages[$validated['paket_camping']];

                foreach ($validated['rental_items'] ?? [] as $itemName => $quantity) {
                    $quantity = (int) $quantity;

                    if ($quantity < 1 || ! array_key_exists($itemName, $rentalPricelist)) {
                        continue;
                    }

                    $subtotal = $rentalPricelist[$itemName] * $quantity;
                    $selectedRentals[] = [
                        'nama' => $itemName,
                        'harga' => $rentalPricelist[$itemName],
                        'jumlah' => $quantity,
                        'subtotal' => $subtotal,
                    ];
                    $rentalTotal += $subtotal;
                }
            }

            $hargaPaket = $selectedPackage['harga'] ?? 0;
            $totalPerHari = ($tiket->harga * $validated['jumlah_tiket']) + $hargaPaket + $rentalTotal;

            if (! $isCamping) {
                if ($validated['jumlah_tiket'] > $tiket->stok) {
                    back()
                        ->withErrors(['jumlah_tiket' => 'Stok tiket tidak mencukupi.'])
                        ->withInput()
                        ->throwResponse();
                }

                $tiket->decrement('stok', $validated['jumlah_tiket']);
            }

            return Pemesanan::create([
                'user_id' => Auth::id(),
                'tiket_id' => $tiket->id,
                'jumlah_tiket' => $validated['jumlah_tiket'],
                'tanggal' => $validated['tanggal'],
                'paket_camping' => $isCamping ? $validated['paket_camping'] : null,
                'harga_paket' => $hargaPaket,
                'rental_items' => $isCamping ? $selectedRentals : null,
                'rental_total' => $isCamping ? $rentalTotal : 0,
                'durasi' => $validated['durasi'],
                'total_harga' => $totalPerHari * $validated['durasi'],
                'bukti_pembayaran' => $fileName,
                'status' => 'pending',
                'availability_status' => $isCamping ? 'waiting' : 'approved',
            ]);
        });

        if ($pemesanan->availability_status === 'waiting') {
            return redirect()
                ->route('riwayat')
                ->with('success', 'Pesanan camping dikirim. Tunggu admin mengonfirmasi ketersediaan sebelum lanjut pembayaran.');
        }

        return redirect()->route('invoice', $pemesanan);
    }

    public function riwayat()
    {
        $pemesanans = Pemesanan::with('tiket')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('pemesanan.riwayat', compact('pemesanans'));
    }

    // public function invoice($id)
    // {
    //     $query = Pemesanan::with('tiket', 'user')->whereKey($id);

    //     if (auth()->user()->role !== 'admin') {
    //         $query->where('user_id', auth()->id());
    //     }

    //     $pemesanan = $query->firstOrFail();

    //     return view('pemesanan.invoice', compact('pemesanan'));
    // }

    public function invoice($id)
    {
        $query = Pemesanan::with('tiket', 'user')->whereKey($id);

        if (auth()->user()->role !== 'admin') {
            $query->where('user_id', auth()->id());
        }

        $pemesanan = $query->firstOrFail();

        $snapToken = null;
        
        // Buat token Midtrans hanya untuk user pemesan, bukan saat admin melihat bukti invoice.
        if ($pemesanan->status === 'pending' && $pemesanan->availability_status === 'approved' && auth()->user()->role !== 'admin') {
            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production');
            Config::$isSanitized = config('midtrans.is_sanitized');
            Config::$is3ds = config('midtrans.is_3ds');

           $params = [
                'transaction_details' => [
                    // Tambahkan time() agar order_id selalu unik setiap kali direfresh
                    'order_id' => 'CAMP-' . $pemesanan->id . '-' . time(),
                    'gross_amount' => $pemesanan->total_harga,
                ],
                'customer_details' => [
                    'first_name' => $pemesanan->user->name,
                    'email' => $pemesanan->user->email,
                ],
            ];

            $snapToken = Snap::getSnapToken($params);
        }

        return view('pemesanan.invoice', compact('pemesanan', 'snapToken'));
    }

    public function cancel(Pemesanan $pemesanan)
    {
        abort_if($pemesanan->user_id !== auth()->id(), 403);

        if ($pemesanan->status === 'lunas') {
            return back()->withErrors(['pemesanan' => 'Pesanan yang sudah lunas tidak bisa dibatalkan.']);
        }

        DB::transaction(function () use ($pemesanan) {
            if ($pemesanan->availability_status === 'approved') {
                Tiket::whereKey($pemesanan->tiket_id)
                    ->lockForUpdate()
                    ->firstOrFail()
                    ->increment('stok', $pemesanan->jumlah_tiket);
            }

            $pemesanan->update([
                'availability_status' => 'canceled',
                'catatan_admin' => 'Dibatalkan oleh pengunjung.',
            ]);
        });

        return back()->with('success', 'Pesanan berhasil dibatalkan.');
    }

    public function acceptPartial(Pemesanan $pemesanan)
    {
        abort_if($pemesanan->user_id !== auth()->id(), 403);

        if ($pemesanan->availability_status !== 'partial') {
            return back()->withErrors(['pemesanan' => 'Pesanan ini tidak menunggu persetujuan item kosong.']);
        }

        DB::transaction(function () use ($pemesanan) {
            $tiket = Tiket::whereKey($pemesanan->tiket_id)->lockForUpdate()->firstOrFail();

            if ($pemesanan->jumlah_tiket > $tiket->stok) {
                back()
                    ->withErrors(['jumlah_tiket' => 'Stok tiket tidak mencukupi untuk melanjutkan pesanan ini.'])
                    ->throwResponse();
            }

            $unavailableNames = collect($pemesanan->unavailable_rental_items ?? [])
                ->pluck('nama')
                ->all();

            $availableRentals = collect($pemesanan->rental_items ?? [])
                ->reject(fn ($item) => in_array($item['nama'], $unavailableNames, true))
                ->values()
                ->all();

            $rentalTotal = collect($availableRentals)->sum('subtotal');
            $totalPerHari = ($tiket->harga * $pemesanan->jumlah_tiket) + $pemesanan->harga_paket + $rentalTotal;

            $tiket->decrement('stok', $pemesanan->jumlah_tiket);

            $pemesanan->update([
                'rental_items' => $availableRentals,
                'rental_total' => $rentalTotal,
                'total_harga' => $totalPerHari * $pemesanan->durasi,
                'availability_status' => 'approved',
                'catatan_admin' => null,
            ]);
        });

        return redirect()
            ->route('invoice', $pemesanan)
            ->with('success', 'Pesanan dilanjutkan tanpa item rental yang kosong. Silakan lanjut pembayaran.');
    }

    public function callback(Request $request)
    {
        // 1. Ambil Server Key dari config
        $serverKey = config('midtrans.server_key');
        
        // 2. Buat hash untuk memverifikasi bahwa yang mengirim data ini benar-benar Midtrans
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        // 3. Cek apakah signature key cocok
        if ($hashed == $request->signature_key) {
            $parts = explode('-', $request->order_id);
            $pemesananId = $parts[1] ?? null;
            $pemesanan = $pemesananId ? Pemesanan::find($pemesananId) : null;

            if ($pemesanan) {
                $isPaid = in_array($request->transaction_status, ['settlement', 'capture'], true);

                $pemesanan->update([
                    'midtrans_order_id' => $request->order_id,
                    'midtrans_status' => $request->transaction_status,
                    'paid_at' => $isPaid ? now() : $pemesanan->paid_at,
                ]);
            }
        }
        
        // Midtrans mewajibkan kita membalas dengan status HTTP 200 (OK)
        return response()->json(['message' => 'Success']);
    }
}
