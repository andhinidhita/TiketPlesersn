@extends('layouts.admin')

@section('title', 'Dashboard Admin - Bumi Perkemahan Pleseran')
@section('page_title', 'Dashboard Admin')

@section('header_action')
    <a href="{{ route('admin.dashboard.export') }}" class="rounded-md bg-emerald-700 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-800">
        Export Excel
    </a>
@endsection

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

    @php
        $maxPengunjung = max(1, $monthlyStats->max('pengunjung'));
        $maxPemesanan = max(1, $monthlyStats->max('pemesanan'));
        $maxPendapatan = max(1, $monthlyStats->max('pendapatan'));
        $chartWidth = 1000;
        $chartHeight = 280;
        $chartPadding = 48;
        $chartCount = max(1, $monthlyStats->count() - 1);
        $chartPoints = $monthlyStats->values()->map(function ($stat, $index) use ($chartWidth, $chartHeight, $chartPadding, $chartCount, $maxPendapatan) {
            $x = $chartPadding + ($index * (($chartWidth - ($chartPadding * 2)) / $chartCount));
            $y = ($chartHeight - $chartPadding) - (($stat['pendapatan'] / $maxPendapatan) * ($chartHeight - ($chartPadding * 2)));

            return round($x, 2) . ',' . round($y, 2);
        })->implode(' ');
    @endphp

    <div class="mt-6 rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <p class="text-sm font-semibold text-slate-500">Grafik Pendapatan Bulanan</p>
                <h3 class="mt-1 text-lg font-bold text-slate-950">Pendapatan dari transaksi lunas</h3>
            </div>
            <p class="text-sm font-bold text-emerald-700">Rp {{ number_format($pendapatanLunas,0,',','.') }}</p>
        </div>

        <div class="mt-5 overflow-x-auto">
            <svg viewBox="0 0 {{ $chartWidth }} {{ $chartHeight }}" class="min-w-[720px]">
                <line x1="{{ $chartPadding }}" y1="{{ $chartHeight - $chartPadding }}" x2="{{ $chartWidth - $chartPadding }}" y2="{{ $chartHeight - $chartPadding }}" stroke="#cbd5e1" stroke-width="2" />
                <line x1="{{ $chartPadding }}" y1="{{ $chartPadding }}" x2="{{ $chartPadding }}" y2="{{ $chartHeight - $chartPadding }}" stroke="#cbd5e1" stroke-width="2" />
                <polyline points="{{ $chartPoints }}" fill="none" stroke="#059669" stroke-width="5" stroke-linecap="round" stroke-linejoin="round" />

                @foreach($monthlyStats->values() as $index => $stat)
                    @php
                        $x = $chartPadding + ($index * (($chartWidth - ($chartPadding * 2)) / $chartCount));
                        $y = ($chartHeight - $chartPadding) - (($stat['pendapatan'] / $maxPendapatan) * ($chartHeight - ($chartPadding * 2)));
                    @endphp
                    <circle cx="{{ $x }}" cy="{{ $y }}" r="7" fill="#059669" />
                    <text x="{{ $x }}" y="{{ $chartHeight - 14 }}" text-anchor="middle" font-size="24" fill="#64748b">{{ $stat['label'] }}</text>
                    <text x="{{ $x }}" y="{{ max(24, $y - 14) }}" text-anchor="middle" font-size="22" font-weight="700" fill="#0f172a">
                        {{ $stat['pendapatan'] > 0 ? 'Rp '.number_format($stat['pendapatan'],0,',','.') : 'Rp 0' }}
                    </text>
                @endforeach
            </svg>
        </div>
    </div>

    <div class="mt-6 grid gap-5 xl:grid-cols-3">
        <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold text-slate-500">Total Pengunjung Per Bulan</p>
            <div class="mt-5 space-y-4">
                @foreach($monthlyStats as $stat)
                    <div>
                        <div class="mb-1 flex justify-between text-xs font-semibold text-slate-500">
                            <span>{{ $stat['label'] }}</span>
                            <span>{{ $stat['pengunjung'] }}</span>
                        </div>
                        <div class="h-2 rounded-full bg-slate-100">
                            <div class="h-2 rounded-full bg-sky-500" style="width: {{ ($stat['pengunjung'] / $maxPengunjung) * 100 }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold text-slate-500">Total Pemesanan Per Bulan</p>
            <div class="mt-5 space-y-4">
                @foreach($monthlyStats as $stat)
                    <div>
                        <div class="mb-1 flex justify-between text-xs font-semibold text-slate-500">
                            <span>{{ $stat['label'] }}</span>
                            <span>{{ $stat['pemesanan'] }}</span>
                        </div>
                        <div class="h-2 rounded-full bg-slate-100">
                            <div class="h-2 rounded-full bg-amber-500" style="width: {{ ($stat['pemesanan'] / $maxPemesanan) * 100 }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold text-slate-500">Pendapatan Per Bulan</p>
            <div class="mt-5 space-y-4">
                @foreach($monthlyStats as $stat)
                    <div>
                        <div class="mb-1 flex justify-between text-xs font-semibold text-slate-500">
                            <span>{{ $stat['label'] }}</span>
                            <span>Rp {{ number_format($stat['pendapatan'],0,',','.') }}</span>
                        </div>
                        <div class="h-2 rounded-full bg-slate-100">
                            <div class="h-2 rounded-full bg-emerald-600" style="width: {{ ($stat['pendapatan'] / $maxPendapatan) * 100 }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
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
