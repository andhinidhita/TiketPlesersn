@extends('layouts.admin')

@section('title', 'Cek Transaksi - Admin')
@section('page_title', 'Cek Transaksi')

@section('content')
    @if(session('success'))
        <div class="mb-5 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 px-5 py-4">
            <h3 class="text-base font-bold text-slate-950">Daftar Pemesanan</h3>
            <p class="mt-1 text-sm text-slate-500">Cek bukti pembayaran sebelum mengubah status menjadi lunas.</p>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Pemesan</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Tiket</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Jumlah</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Total</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Status</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Bukti</th>
                        <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse ($pemesanans as $p)
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-4">
                                <p class="text-sm font-semibold text-slate-950">{{ $p->user->name }}</p>
                                <p class="mt-1 text-xs text-slate-500">{{ $p->user->email }}</p>
                            </td>
                            <td class="px-5 py-4 text-sm text-slate-700">{{ $p->tiket->nama_tiket }}</td>
                            <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-700">{{ $p->jumlah_tiket }}</td>
                            <td class="whitespace-nowrap px-5 py-4 text-sm font-semibold text-slate-950">Rp {{ number_format($p->total_harga,0,',','.') }}</td>
                            <td class="whitespace-nowrap px-5 py-4 text-sm">
                                <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $p->status == 'lunas' ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">
                                    {{ ucfirst($p->status) }}
                                </span>
                            </td>
                            <td class="whitespace-nowrap px-5 py-4 text-sm">
                                @if($p->bukti_pembayaran)
                                    <a href="{{ asset('bukti/'.$p->bukti_pembayaran) }}" target="_blank" class="font-semibold text-emerald-700 hover:text-emerald-800">
                                        Lihat bukti
                                    </a>
                                @else
                                    <span class="text-slate-400">Belum ada</span>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-5 py-4 text-right text-sm">
                                <div class="flex justify-end gap-2">
                                    @if($p->status !== 'lunas')
                                        <form action="{{ route('admin.verifikasi', $p) }}" method="POST">
                                            @csrf
                                            <button class="rounded-md bg-emerald-700 px-3 py-2 text-xs font-semibold text-white hover:bg-emerald-800">
                                                Verifikasi
                                            </button>
                                        </form>
                                    @endif

                                    <a href="{{ route('admin.transaksi.edit', $p) }}" class="rounded-md bg-sky-600 px-3 py-2 text-xs font-semibold text-white hover:bg-sky-700">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.transaksi.destroy', $p) }}" method="POST" onsubmit="return confirm('Hapus transaksi ini? Stok tiket akan dikembalikan.');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="rounded-md bg-red-600 px-3 py-2 text-xs font-semibold text-white hover:bg-red-700">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-12 text-center">
                                <p class="text-sm font-semibold text-slate-950">Belum ada pemesanan</p>
                                <p class="mt-1 text-sm text-slate-500">Data pemesanan pengguna akan muncul di sini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
