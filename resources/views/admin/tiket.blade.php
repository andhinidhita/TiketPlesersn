@extends('layouts.admin')

@section('title', 'Tiket Wisata - Admin')
@section('page_title', 'Tiket Wisata')
@section('subtitle', 'Pantau harga dan stok tiket yang tersedia untuk pengunjung.')

@section('content')
    <div class="overflow-hidden rounded-[28px] border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 px-6 py-5">
            <p class="text-xs font-extrabold uppercase tracking-[0.28em] text-slate-400">Inventori</p>
            <h3 class="mt-2 text-xl font-extrabold text-slate-950">Daftar Tiket</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-extrabold uppercase tracking-widest text-slate-500">Nama Tiket</th>
                        <th class="px-6 py-4 text-left text-xs font-extrabold uppercase tracking-widest text-slate-500">Harga</th>
                        <th class="px-6 py-4 text-left text-xs font-extrabold uppercase tracking-widest text-slate-500">Stok</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse ($tikets as $tiket)
                        <tr>
                            <td class="px-6 py-5 text-sm font-extrabold text-slate-950">{{ $tiket->nama_tiket }}</td>
                            <td class="px-6 py-5 text-sm font-semibold text-slate-600">Rp {{ number_format($tiket->harga,0,',','.') }}</td>
                            <td class="px-6 py-5 text-sm font-semibold text-slate-600">{{ $tiket->stok }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-14 text-center text-sm text-slate-500">Belum ada data tiket.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
