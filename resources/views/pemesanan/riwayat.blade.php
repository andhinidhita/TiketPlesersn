@extends('layouts.user')

@section('title', 'Riwayat Pesanan - Bumi Perkemahan Pleseran')
@section('page_title', 'Riwayat Pesanan')

@section('header_action')
    <a href="{{ route('pemesanan') }}" class="rounded-md bg-emerald-700 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-800">
        Pesan Lagi
    </a>
@endsection

@section('content')
    @if(session('success'))
        <div class="mb-5 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-5 rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Tanggal</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Tiket</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Jumlah</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Total</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Ketersediaan</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Status</th>
                        <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse($pemesanans as $pemesanan)
                        @php
                            $availabilityClass = [
                                'waiting' => 'bg-amber-50 text-amber-700',
                                'partial' => 'bg-sky-50 text-sky-700',
                                'approved' => 'bg-emerald-50 text-emerald-700',
                                'rejected' => 'bg-red-50 text-red-700',
                                'canceled' => 'bg-slate-100 text-slate-600',
                            ][$pemesanan->availability_status] ?? 'bg-slate-100 text-slate-600';

                            $availabilityLabel = [
                                'waiting' => 'Menunggu admin',
                                'partial' => 'Sebagian item kosong',
                                'approved' => 'Tersedia',
                                'rejected' => 'Tidak tersedia',
                                'canceled' => 'Dibatalkan',
                            ][$pemesanan->availability_status] ?? ucfirst($pemesanan->availability_status);
                        @endphp
                        <tr class="hover:bg-slate-50">
                            <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-600">
                                {{ optional($pemesanan->tanggal)->format('d M Y') ?? '-' }}
                            </td>
                            <td class="px-5 py-4 text-sm font-semibold text-slate-950">
                                {{ $pemesanan->tiket->nama_tiket }}
                            </td>
                            <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-600">
                                {{ $pemesanan->jumlah_tiket }}
                            </td>
                            <td class="whitespace-nowrap px-5 py-4 text-sm font-semibold text-slate-950">
                                Rp {{ number_format($pemesanan->total_harga,0,',','.') }}
                            </td>
                            <td class="whitespace-nowrap px-5 py-4 text-sm">
                                <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $availabilityClass }}">
                                    {{ $availabilityLabel }}
                                </span>
                            </td>
                            <td class="whitespace-nowrap px-5 py-4 text-sm">
                                <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $pemesanan->status == 'lunas' ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">
                                    {{ ucfirst($pemesanan->status) }}
                                </span>
                            </td>
                            <td class="whitespace-nowrap px-5 py-4 text-right text-sm">
                                <button type="button" onclick="document.getElementById('detail-riwayat-{{ $pemesanan->id }}').showModal()" class="rounded-md bg-slate-950 px-3 py-2 text-xs font-semibold text-white hover:bg-slate-800">
                                    Detail
                                </button>

                                <dialog id="detail-riwayat-{{ $pemesanan->id }}" class="w-[min(860px,94vw)] rounded-lg border border-slate-200 p-0 text-left shadow-2xl backdrop:bg-slate-950/50">
                                    <div class="border-b border-slate-200 px-6 py-4">
                                        <div class="flex items-start justify-between gap-4">
                                            <div>
                                                <p class="text-xs font-semibold uppercase tracking-wide text-emerald-700">Detail Pesanan</p>
                                                <h4 class="mt-1 text-lg font-bold text-slate-950">#INV-{{ $pemesanan->id }}</h4>
                                                <p class="mt-1 text-sm text-slate-500">{{ optional($pemesanan->tanggal)->format('d M Y') ?? '-' }}</p>
                                            </div>
                                            <form method="dialog">
                                                <button class="rounded-md border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-100">Tutup</button>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="max-h-[75vh] overflow-y-auto px-6 py-5">
                                        <div class="grid gap-4 md:grid-cols-3">
                                            <div class="rounded-md bg-slate-50 p-4">
                                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Tiket</p>
                                                <p class="mt-2 font-bold text-slate-950">{{ $pemesanan->tiket->nama_tiket }}</p>
                                                <p class="mt-1 text-sm text-slate-500">{{ $pemesanan->jumlah_tiket }} tiket x Rp {{ number_format($pemesanan->tiket->harga,0,',','.') }}</p>
                                            </div>
                                            <div class="rounded-md bg-slate-50 p-4">
                                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Durasi Hari</p>
                                                <p class="mt-2 font-bold text-slate-950">{{ $pemesanan->durasi }} hari</p>
                                            </div>
                                            <div class="rounded-md bg-slate-50 p-4">
                                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Total</p>
                                                <p class="mt-2 font-bold text-slate-950">Rp {{ number_format($pemesanan->total_harga,0,',','.') }}</p>
                                                <p class="mt-1 text-sm text-slate-500">{{ ucfirst($pemesanan->status) }}</p>
                                            </div>
                                        </div>

                                        <div class="mt-5 grid gap-5 lg:grid-cols-2">
                                            <div class="rounded-md border border-slate-200 p-4">
                                                <p class="text-sm font-bold text-slate-950">Paket Camping</p>
                                                @if($pemesanan->paket_camping)
                                                    <p class="mt-3 font-semibold text-slate-950">{{ $pemesanan->paket_camping }}</p>
                                                    <p class="mt-1 text-sm text-slate-500">Rp {{ number_format($pemesanan->harga_paket,0,',','.') }}/hari</p>
                                                @else
                                                    <p class="mt-3 text-sm text-slate-500">Tidak ada paket camping.</p>
                                                @endif
                                            </div>

                                            <div class="rounded-md border border-slate-200 p-4">
                                                <p class="text-sm font-bold text-slate-950">Ketersediaan</p>
                                                <span class="mt-3 inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $availabilityClass }}">
                                                    {{ $availabilityLabel }}
                                                </span>
                                                @if($pemesanan->catatan_admin)
                                                    <p class="mt-2 text-sm text-slate-500">{{ $pemesanan->catatan_admin }}</p>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="mt-5 rounded-md border border-slate-200 p-4">
                                            <p class="text-sm font-bold text-slate-950">Item Rental Tambahan</p>
                                            @if(! empty($pemesanan->rental_items))
                                                <div class="mt-3 grid gap-3 md:grid-cols-2">
                                                    @foreach($pemesanan->rental_items as $item)
                                                        <div class="rounded-md bg-slate-50 p-3 text-sm">
                                                            <p class="font-semibold text-slate-950">{{ $item['nama'] }}</p>
                                                            <p class="mt-1 text-slate-500">{{ $item['jumlah'] }} x Rp {{ number_format($item['harga'],0,',','.') }}/hari</p>
                                                            <p class="mt-1 font-semibold text-slate-950">Rp {{ number_format($item['subtotal'],0,',','.') }}/hari</p>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div class="mt-3 flex justify-between border-t border-slate-200 pt-3 text-sm font-bold text-slate-950">
                                                    <span>Total rental / hari</span>
                                                    <span>Rp {{ number_format($pemesanan->rental_total,0,',','.') }}</span>
                                                </div>
                                            @else
                                                <p class="mt-3 text-sm text-slate-500">Tidak ada item rental tambahan.</p>
                                            @endif
                                        </div>

                                        @if(! empty($pemesanan->unavailable_rental_items))
                                            <div class="mt-5 rounded-md border border-sky-200 bg-sky-50 p-4">
                                                <p class="text-sm font-bold text-sky-900">Item Rental Kosong</p>
                                                <div class="mt-3 grid gap-2 md:grid-cols-2">
                                                    @foreach($pemesanan->unavailable_rental_items as $item)
                                                        <p class="rounded-md bg-white px-3 py-2 text-sm font-semibold text-sky-800">{{ $item['nama'] }} x{{ $item['jumlah'] }}</p>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif

                                        <div class="mt-5 rounded-md border border-slate-200 p-4">
                                            <p class="text-sm font-bold text-slate-950">Aksi Pesanan</p>
                                            <div class="mt-4 flex flex-wrap gap-3">
                                                @if($pemesanan->availability_status === 'approved')
                                                    <a href="{{ route('invoice', $pemesanan) }}" class="rounded-md bg-emerald-700 px-3 py-2 text-xs font-semibold text-white hover:bg-emerald-800">Invoice</a>
                                                @endif

                                                @if($pemesanan->availability_status === 'partial')
                                                    <form action="{{ route('pemesanan.accept-partial', $pemesanan) }}" method="POST" onsubmit="return confirm('Lanjut booking tanpa item rental yang kosong?');">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button class="rounded-md bg-emerald-700 px-3 py-2 text-xs font-semibold text-white hover:bg-emerald-800">Lanjut tanpa item kosong</button>
                                                    </form>
                                                @endif

                                                @if($pemesanan->status !== 'lunas' && in_array($pemesanan->availability_status, ['waiting', 'partial', 'approved', 'rejected'], true))
                                                    <form action="{{ route('pemesanan.cancel', $pemesanan) }}" method="POST" onsubmit="return confirm('Batalkan pesanan ini?');">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button class="rounded-md bg-red-600 px-3 py-2 text-xs font-semibold text-white hover:bg-red-700">Batal</button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </dialog>
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
