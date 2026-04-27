<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemesanan;

class AdminController extends Controller
{
    public function index()
    {
        $pemesanans = Pemesanan::with('tiket')->get();
        return view('admin.index', compact('pemesanans'));
    }

    public function verifikasi($id)
    {
        $pemesanan = Pemesanan::findOrFail($id);
        $pemesanan->status = 'lunas';
        $pemesanan->save();

        return back()->with('success', 'Berhasil diverifikasi');
    }
}