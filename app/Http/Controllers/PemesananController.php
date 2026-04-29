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
    public function index()
    {
        $tikets = Tiket::orderBy('nama_tiket')->get();

        return view('pemesanan.index', compact('tikets'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tiket_id' => 'required|exists:tikets,id',
            'jumlah_tiket' => 'required|integer|min:1',
            'tanggal' => 'required|date',
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

            if ($validated['jumlah_tiket'] > $tiket->stok) {
                back()
                    ->withErrors(['jumlah_tiket' => 'Stok tiket tidak mencukupi.'])
                    ->withInput()
                    ->throwResponse();
            }

            $tiket->decrement('stok', $validated['jumlah_tiket']);

            return Pemesanan::create([
                'user_id' => Auth::id(),
                'tiket_id' => $tiket->id,
                'jumlah_tiket' => $validated['jumlah_tiket'],
                'tanggal' => $validated['tanggal'],
                'total_harga' => $tiket->harga * $validated['jumlah_tiket'],
                'bukti_pembayaran' => $fileName,
                'status' => 'pending',
            ]);
        });

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
        
        // Buat token Midtrans HANYA jika status pesanan masih 'pending'
        if ($pemesanan->status === 'pending') {
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

    public function callback(Request $request)
    {
        // 1. Ambil Server Key dari config
        $serverKey = config('midtrans.server_key');
        
        // 2. Buat hash untuk memverifikasi bahwa yang mengirim data ini benar-benar Midtrans
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        // 3. Cek apakah signature key cocok
        if ($hashed == $request->signature_key) {
            
            // Ambil status transaksi dari Midtrans
            $status = $request->transaction_status;
            
            // Ambil status transaksi dari Midtrans
            $status = $request->transaction_status;
            
            // PECAH ORDER ID BARU (Contoh: 'CAMP-5-1718000000')
            // Kita pisahkan berdasarkan tanda strip '-'
            $parts = explode('-', $request->order_id);
            
            // Ambil bagian kedua (index ke-1) yaitu angka ID pemesanannya
            $pemesanan_id = $parts[1]; 
            
            // Cari data pemesanan di database
            $pemesanan = Pemesanan::find($pemesanan_id);

            if ($pemesanan) {
                // Jika status dari Midtrans adalah berhasil (settlement atau capture)
                if ($status == 'settlement' || $status == 'capture') {
                    $pemesanan->update([
                        'status' => 'lunas'
                    ]);
                } 
                // Jika ingin menambahkan aksi ketika status gagal/cancel/expire bisa di sini
                // elseif ($status == 'cancel' || $status == 'deny' || $status == 'expire') { ... }
            }
        }
        
        // Midtrans mewajibkan kita membalas dengan status HTTP 200 (OK)
        return response()->json(['message' => 'Success']);
    }
}
