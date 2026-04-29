<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Models\Tiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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

    public function invoice($id)
    {
        $query = Pemesanan::with('tiket', 'user')->whereKey($id);

        if (auth()->user()->role !== 'admin') {
            $query->where('user_id', auth()->id());
        }

        $pemesanan = $query->firstOrFail();

        return view('pemesanan.invoice', compact('pemesanan'));
    }
}
