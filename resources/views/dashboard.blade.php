@extends('layouts.user')

@section('title', 'Dashboard - Bumi Perkemahan Pleseran')

@section('content')
    <section class="overflow-hidden rounded-lg bg-slate-950 shadow-sm">
        <div class="grid lg:grid-cols-[1.05fr_0.95fr]">
            <div class="p-6 text-white sm:p-10">
                <p class="text-sm font-semibold uppercase tracking-wide text-emerald-200">Halo, {{ auth()->user()->name }}</p>
                <h1 class="mt-4 max-w-2xl text-3xl font-extrabold tracking-tight sm:text-5xl">
                    Mau camping kapan?
                </h1>
                <p class="mt-5 max-w-2xl leading-7 text-white/75">
                    Dari sini kamu bisa pesan tiket, cek status pembayaran Bumi Perkemahan Pleseran.
                </p>
                <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                    <a href="{{ route('pemesanan') }}" class="inline-flex items-center justify-center rounded-md bg-emerald-600 px-5 py-3 text-sm font-semibold text-white hover:bg-emerald-700">
                        Pesan Tiket
                    </a>
                    <a href="{{ route('riwayat') }}" class="inline-flex items-center justify-center rounded-md border border-white/30 px-5 py-3 text-sm font-semibold text-white hover:bg-white/10">
                        Lihat Riwayat
                    </a>
                </div>
            </div>
            <img src="{{ asset('images/g3.png') }}" alt="Area camping Pleseran" class="h-72 w-full object-cover lg:h-full">
        </div>
    </section>

    <section class="mt-6 grid gap-5 md:grid-cols-3">
        <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold text-slate-500">Pesanan Kamu</p>
            <div class="mt-4 flex items-end justify-between">
                <p class="text-4xl font-extrabold text-slate-950">{{ $jumlahPesanan }}</p>
                <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">Order</span>
            </div>
        </div>

        <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold text-slate-500">Total Tiket</p>
            <div class="mt-4 flex items-end justify-between">
                <p class="text-4xl font-extrabold text-slate-950">{{ $jumlahTiket }}</p>
                <span class="rounded-full bg-sky-50 px-3 py-1 text-xs font-semibold text-sky-700">Tiket</span>
            </div>
        </div>

        <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold text-slate-500">Pesanan Terakhir</p>
            <div class="mt-4 flex items-end justify-between">
                <p class="text-2xl font-extrabold {{ $statusTerakhir === 'lunas' ? 'text-emerald-700' : 'text-amber-600' }}">
                    {{ ucfirst($statusTerakhir) }}
                </p>
                <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">Status</span>
            </div>
        </div>
    </section>

    <section class="mt-6 grid gap-5 lg:grid-cols-[0.9fr_1.1fr]">
        <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-wide text-emerald-700">Panduan Singkat</p>
            <h2 class="mt-2 text-xl font-bold text-slate-950">Cara pesan tiket</h2>
            <div class="mt-5 space-y-4">
                <div class="flex gap-3">
                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-emerald-50 text-sm font-bold text-emerald-700">1</span>
                    <div>
                        <p class="font-semibold text-slate-950">Isi data pesanan</p>
                        <p class="mt-1 text-sm text-slate-500">Pilih tiket, tanggal kunjungan, dan jumlah tiket.</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-emerald-50 text-sm font-bold text-emerald-700">2</span>
                    <div>
                        <p class="font-semibold text-slate-950">Upload bukti pembayaran</p>
                        <p class="mt-1 text-sm text-slate-500">Transfer ke rekening yang tersedia, lalu unggah bukti.</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-emerald-50 text-sm font-bold text-emerald-700">3</span>
                    <div>
                        <p class="font-semibold text-slate-950">Tunggu verifikasi</p>
                        <p class="mt-1 text-sm text-slate-500">Admin akan mengecek pembayaran sebelum status menjadi lunas.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-wide text-emerald-700">Rekening Pembayaran</p>
                    <h2 class="mt-2 text-xl font-bold text-slate-950">BRI 6718-0105-2339-535</h2>
                    <p class="mt-2 text-sm text-slate-500">Gunakan nominal sesuai invoice agar mudah diverifikasi.</p>
                </div>
                <a href="{{ route('pemesanan') }}" class="inline-flex items-center justify-center rounded-md bg-emerald-700 px-5 py-3 text-sm font-semibold text-white hover:bg-emerald-800">
                    Buat Pesanan
                </a>
            </div>
        </div>
    </section>
@endsection
