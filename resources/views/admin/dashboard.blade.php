@extends('layouts.admin')

@section('title', 'Dashboard Admin - Bumi Perkemahan Pleseran')
@section('page_title', 'Dashboard Admin')

@section('content')
    <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold text-slate-500">Total Transaksi</p>
            <p class="mt-3 text-3xl font-extrabold text-slate-950">{{ $totalTransaksi }}</p>
        </div>
        <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold text-slate-500">Pending</p>
            <p class="mt-3 text-3xl font-extrabold text-amber-600">{{ $transaksiPending }}</p>
        </div>
        <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold text-slate-500">Lunas</p>
            <p class="mt-3 text-3xl font-extrabold text-emerald-700">{{ $transaksiLunas }}</p>
        </div>
        <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold text-slate-500">Pendapatan Lunas</p>
            <p class="mt-3 text-2xl font-extrabold text-slate-950">Rp {{ number_format($pendapatanLunas,0,',','.') }}</p>
        </div>
    </div>

    <div class="mt-6 grid gap-5 lg:grid-cols-[1.1fr_0.9fr]">
        <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-wide text-emerald-700">Menu Pengelolaan</p>
            <h3 class="mt-2 text-xl font-bold text-slate-950">Fitur admin</h3>
            <div class="mt-5 grid gap-3 sm:grid-cols-2">
                <a href="{{ route('admin.transaksi') }}" class="rounded-lg border border-slate-200 p-4 hover:border-emerald-300 hover:bg-emerald-50">
                    <p class="font-bold text-slate-950">Cek Transaksi</p>
                    <p class="mt-1 text-sm text-slate-500">Verifikasi pembayaran member.</p>
                </a>
                <a href="{{ route('admin.galeri') }}" class="rounded-lg border border-slate-200 p-4 hover:border-emerald-300 hover:bg-emerald-50">
                    <p class="font-bold text-slate-950">Galeri</p>
                    <p class="mt-1 text-sm text-slate-500">Kelola foto landing page.</p>
                </a>
                <a href="{{ route('admin.tiket') }}" class="rounded-lg border border-slate-200 p-4 hover:border-emerald-300 hover:bg-emerald-50">
                    <p class="font-bold text-slate-950">Tiket Wisata</p>
                    <p class="mt-1 text-sm text-slate-500">Lihat stok dan harga tiket.</p>
                </a>
                <a href="{{ route('admin.members') }}" class="rounded-lg border border-slate-200 p-4 hover:border-emerald-300 hover:bg-emerald-50">
                    <p class="font-bold text-slate-950">Data Member</p>
                    <p class="mt-1 text-sm text-slate-500">Pantau akun pengunjung.</p>
                </a>
            </div>
        </div>

        <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-wide text-emerald-700">Ringkasan Data</p>
            <div class="mt-5 space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <span class="text-sm text-slate-500">Jenis Tiket</span>
                    <span class="font-bold text-slate-950">{{ $totalTiket }}</span>
                </div>
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <span class="text-sm text-slate-500">Admin</span>
                    <span class="font-bold text-slate-950">{{ $totalAdmin }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-slate-500">Member</span>
                    <span class="font-bold text-slate-950">{{ $totalMember }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection
