@extends('layouts.user')

@section('title', 'Riwayat Pesanan - Bumi Perkemahan Pleseran')
@section('page_title', 'Riwayat Pesanan')

@section('header_action')
    <a href="{{ route('pemesanan') }}" class="rounded-md bg-emerald-700 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-800">
        Pesan Lagi
    </a>
@endsection

@section('content')
    <div class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Tanggal</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Tiket</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Harga</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Jumlah</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Total</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Status</th>
                        <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Invoice</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse($pemesanans as $pemesanan)
                        <tr class="hover:bg-slate-50">
                            <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-600">
                                {{ optional($pemesanan->tanggal)->format('d M Y') ?? '-' }}
                            </td>
                            <td class="px-5 py-4 text-sm font-semibold text-slate-950">
                                {{ $pemesanan->tiket->nama_tiket }}
                            </td>
                            <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-600">
                                Rp {{ number_format($pemesanan->tiket->harga,0,',','.') }}
                            </td>
                            <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-600">
                                {{ $pemesanan->jumlah_tiket }}
                            </td>
                            <td class="whitespace-nowrap px-5 py-4 text-sm font-semibold text-slate-950">
                                Rp {{ number_format($pemesanan->total_harga,0,',','.') }}
                            </td>
                            <td class="whitespace-nowrap px-5 py-4 text-sm">
                                <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $pemesanan->status == 'lunas' ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">
                                    {{ ucfirst($pemesanan->status) }}
                                </span>
                            </td>
                            <td class="whitespace-nowrap px-5 py-4 text-right text-sm">
                                <a href="{{ route('invoice', $pemesanan) }}" class="font-semibold text-emerald-700 hover:text-emerald-800">Lihat</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-12 text-center">
                                <p class="text-sm font-semibold text-slate-950">Belum ada pesanan</p>
                                <p class="mt-1 text-sm text-slate-500">Pesanan yang kamu buat akan muncul di sini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
