<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tiket;
use App\Models\Pemesanan;
use Illuminate\Support\Facades\Auth;

class PemesananController extends Controller
{
    public function index()
    {
        $tikets = Tiket::all();
        return view('pemesanan.index', compact('tikets'));
    }

    public function store(Request $request)
    {
        // ✅ VALIDASI
        $request->validate([
            'tiket_id' => 'required|exists:tikets,id',
            'jumlah_tiket' => 'required|integer|min:1',
            'tanggal' => 'required|date',
            'bukti_pembayaran' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // ✅ AMBIL DATA TIKET
        $tiket = Tiket::findOrFail($request->tiket_id);

        // ✅ HITUNG TOTAL
        $total = $tiket->harga * $request->jumlah_tiket;

        // ✅ UPLOAD FILE
        $fileName = null;

        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            $fileName = time() . '.' . $file->extension();
            $file->move(public_path('bukti'), $fileName);
        }

        // ✅ SIMPAN DATA
        $pemesanan = Pemesanan::create([
            'user_id' => Auth::id(),
            'tiket_id' => $request->tiket_id,
            'jumlah_tiket' => $request->jumlah_tiket,
            'total_harga' => $total,
            'bukti_pembayaran' => $fileName,
            'status' => $fileName ? 'lunas' : 'pending'
        ]);

        // 🔥 LANGSUNG KE INVOICE
        return redirect('/invoice/' . $pemesanan->id);
    }

    public function riwayat()
    {
        $pemesanans = Pemesanan::where('user_id', auth()->id())->get();
        return view('pemesanan.riwayat', compact('pemesanans'));
    }

    public function invoice($id)
    {
        $pemesanan = Pemesanan::with('tiket', 'user')->findOrFail($id);
        return view('pemesanan.invoice', compact('pemesanan'));
    }
}