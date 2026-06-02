@extends('layouts.admin')

@section('title', 'Cek Transaksi - Admin')
@section('page_title', 'Cek Transaksi')

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

    <form method="GET" action="{{ route('admin.transaksi') }}" class="mb-5 rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
        <div class="grid gap-4 md:grid-cols-5">
            <div>
                <label for="status" class="block text-xs font-semibold uppercase tracking-wide text-slate-500">Status Bayar</label>
                <select id="status" name="status" class="mt-2 w-full rounded-md border-slate-300 text-sm shadow-sm">
                    <option value="">Semua</option>
                    <option value="pending" @selected(request('status') === 'pending')>Pending</option>
                    <option value="lunas" @selected(request('status') === 'lunas')>Lunas</option>
                </select>
            </div>
            <div>
                <label for="availability_status" class="block text-xs font-semibold uppercase tracking-wide text-slate-500">Ketersediaan</label>
                <select id="availability_status" name="availability_status" class="mt-2 w-full rounded-md border-slate-300 text-sm shadow-sm">
                    <option value="">Semua</option>
                    <option value="waiting" @selected(request('availability_status') === 'waiting')>Menunggu</option>
                    <option value="partial" @selected(request('availability_status') === 'partial')>Sebagian Kosong</option>
                    <option value="approved" @selected(request('availability_status') === 'approved')>Tersedia</option>
                    <option value="rejected" @selected(request('availability_status') === 'rejected')>Tolak</option>
                    <option value="canceled" @selected(request('availability_status') === 'canceled')>Dibatalkan</option>
                </select>
            </div>
            <div>
                <label for="from" class="block text-xs font-semibold uppercase tracking-wide text-slate-500">Dari</label>
                <input id="from" type="date" name="from" value="{{ request('from') }}" class="mt-2 w-full rounded-md border-slate-300 text-sm shadow-sm">
            </div>
            <div>
                <label for="to" class="block text-xs font-semibold uppercase tracking-wide text-slate-500">Sampai</label>
                <input id="to" type="date" name="to" value="{{ request('to') }}" class="mt-2 w-full rounded-md border-slate-300 text-sm shadow-sm">
            </div>
            <div class="flex items-end gap-2">
                <button class="rounded-md bg-slate-950 px-4 py-2.5 text-sm font-semibold text-white hover:bg-slate-800">Filter</button>
                <a href="{{ route('admin.transaksi.export', request()->query()) }}" class="rounded-md bg-emerald-700 px-4 py-2.5 text-sm font-semibold text-white hover:bg-emerald-800">Export Excel</a>
            </div>
        </div>
    </form>

    <div class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 px-5 py-4">
            <h3 class="text-base font-bold text-slate-950">Daftar Pemesanan</h3>
            <p class="mt-1 text-sm text-slate-500">Konfirmasi ketersediaan paket camping sebelum pengunjung lanjut pembayaran.</p>
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
                        <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Detail</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse ($pemesanans as $p)
                        @php
                            $availabilityClass = [
                                'waiting' => 'bg-amber-50 text-amber-700',
                                'partial' => 'bg-sky-50 text-sky-700',
                                'approved' => 'bg-emerald-50 text-emerald-700',
                                'rejected' => 'bg-red-50 text-red-700',
                                'canceled' => 'bg-slate-100 text-slate-600',
                            ][$p->availability_status] ?? 'bg-slate-100 text-slate-600';

                            $availabilityLabel = [
                                'waiting' => 'Menunggu',
                                'partial' => 'Sebagian kosong',
                                'approved' => 'Tersedia',
                                'rejected' => 'Tidak tersedia',
                                'canceled' => 'Dibatalkan',
                            ][$p->availability_status] ?? ucfirst($p->availability_status);
                        @endphp
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-4">
                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">ID Pengunjung: {{ $p->user->id }}</p>
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
                            <td class="whitespace-nowrap px-5 py-4 text-right text-sm">
                                <button type="button" onclick="document.getElementById('detail-transaksi-{{ $p->id }}').showModal()" class="rounded-md bg-slate-950 px-3 py-2 text-xs font-semibold text-white hover:bg-slate-800">
                                    Detail
                                </button>

                                <dialog id="detail-transaksi-{{ $p->id }}" class="w-[min(920px,94vw)] rounded-lg border border-slate-200 p-0 text-left shadow-2xl backdrop:bg-slate-950/50">
                                    <div class="border-b border-slate-200 px-6 py-4">
                                        <div class="flex items-start justify-between gap-4">
                                            <div>
                                                <p class="text-xs font-semibold uppercase tracking-wide text-emerald-700">Detail Pemesanan</p>
                                                <h4 class="mt-1 text-lg font-bold text-slate-950">#INV-{{ $p->id }} - {{ $p->user->name }}</h4>
                                                <p class="mt-1 text-sm text-slate-500">ID Pengunjung: {{ $p->user->id }} | {{ $p->user->email }}</p>
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
                                                <p class="mt-2 font-bold text-slate-950">{{ $p->tiket->nama_tiket }}</p>
                                                <p class="mt-1 text-sm text-slate-500">{{ $p->jumlah_tiket }} tiket</p>
                                            </div>
                                            <div class="rounded-md bg-slate-50 p-4">
                                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Durasi Hari</p>
                                                <p class="mt-2 font-bold text-slate-950">{{ $p->durasi }} hari</p>
                                                <p class="mt-1 text-sm text-slate-500">{{ optional($p->tanggal)->format('d M Y') ?? '-' }}</p>
                                            </div>
                                            <div class="rounded-md bg-slate-50 p-4">
                                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Total</p>
                                                <p class="mt-2 font-bold text-slate-950">Rp {{ number_format($p->total_harga,0,',','.') }}</p>
                                                <p class="mt-1 text-sm text-slate-500">{{ ucfirst($p->status) }}</p>
                                            </div>
                                        </div>

                                        <div class="mt-5 grid gap-5 lg:grid-cols-2">
                                            <div class="rounded-md border border-slate-200 p-4">
                                                <p class="text-sm font-bold text-slate-950">Paket Camping</p>
                                                @if($p->paket_camping)
                                                    <p class="mt-3 font-semibold text-slate-950">{{ $p->paket_camping }}</p>
                                                    <p class="mt-1 text-sm text-slate-500">Rp {{ number_format($p->harga_paket,0,',','.') }}/hari</p>
                                                @else
                                                    <p class="mt-3 text-sm text-slate-500">Tidak ada paket camping.</p>
                                                @endif
                                            </div>

                                            <div class="rounded-md border border-slate-200 p-4">
                                                <p class="text-sm font-bold text-slate-950">Ketersediaan</p>
                                                <span class="mt-3 inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $availabilityClass }}">
                                                    {{ $availabilityLabel }}
                                                </span>
                                                @if($p->catatan_admin)
                                                    <p class="mt-2 text-sm text-slate-500">{{ $p->catatan_admin }}</p>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="mt-5 rounded-md border border-slate-200 p-4">
                                            <p class="text-sm font-bold text-slate-950">Item Rental Tambahan</p>
                                            @if(! empty($p->rental_items))
                                                <div class="mt-3 grid gap-3 md:grid-cols-2">
                                                    @foreach($p->rental_items as $item)
                                                        <div class="rounded-md bg-slate-50 p-3 text-sm">
                                                            <p class="font-semibold text-slate-950">{{ $item['nama'] }}</p>
                                                            <p class="mt-1 text-slate-500">{{ $item['jumlah'] }} x Rp {{ number_format($item['harga'],0,',','.') }}/hari</p>
                                                            <p class="mt-1 font-semibold text-slate-950">Rp {{ number_format($item['subtotal'],0,',','.') }}/hari</p>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div class="mt-3 flex justify-between border-t border-slate-200 pt-3 text-sm font-bold text-slate-950">
                                                    <span>Total rental / hari</span>
                                                    <span>Rp {{ number_format($p->rental_total,0,',','.') }}</span>
                                                </div>
                                            @else
                                                <p class="mt-3 text-sm text-slate-500">Tidak ada item rental tambahan.</p>
                                            @endif
                                        </div>

                                        @if(! empty($p->unavailable_rental_items))
                                            <div class="mt-5 rounded-md border border-sky-200 bg-sky-50 p-4">
                                                <p class="text-sm font-bold text-sky-900">Item Rental Kosong</p>
                                                <div class="mt-3 grid gap-2 md:grid-cols-2">
                                                    @foreach($p->unavailable_rental_items as $item)
                                                        <p class="rounded-md bg-white px-3 py-2 text-sm font-semibold text-sky-800">{{ $item['nama'] }} x{{ $item['jumlah'] }}</p>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif

                                        <div class="mt-5 rounded-md border border-slate-200 p-4">
                                            <p class="text-sm font-bold text-slate-950">Bukti Pembayaran</p>
                                            <div class="mt-3 text-sm">
                                                @if(in_array($p->midtrans_status, ['settlement', 'capture'], true))
                                                    <a href="{{ route('invoice', $p) }}" target="_blank" class="font-semibold text-emerald-700 hover:text-emerald-800">Lihat invoice</a>
                                                    <p class="mt-1 text-xs text-slate-400">Dibayar {{ optional($p->paid_at)->format('d M Y H:i') }}</p>
                                                @elseif($p->bukti_pembayaran)
                                                    <a href="{{ asset('bukti/'.$p->bukti_pembayaran) }}" target="_blank" class="font-semibold text-emerald-700 hover:text-emerald-800">Lihat bukti</a>
                                                @elseif($p->midtrans_status)
                                                    <span class="text-amber-600">Midtrans: {{ ucfirst($p->midtrans_status) }}</span>
                                                @else
                                                    <span class="text-slate-400">Belum ada</span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="mt-5 rounded-md border border-slate-200 p-4">
                                            <p class="text-sm font-bold text-slate-950">Validasi & Aksi</p>
                                            <div class="mt-4 space-y-4">
                                                @if($p->availability_status === 'waiting')
                                                    <div class="grid gap-4 md:grid-cols-[220px_1fr]">
                                                        <div class="rounded-md bg-slate-50 p-4">
                                                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Konfirmasi Semua</p>
                                                            <form action="{{ route('admin.transaksi.approve', $p) }}" method="POST" class="mt-3">
                                                                @csrf
                                                                @method('PATCH')
                                                                <button class="w-full rounded-md bg-emerald-700 px-3 py-2 text-xs font-semibold text-white hover:bg-emerald-800">Tersedia</button>
                                                            </form>
                                                        </div>

                                                        @if(! empty($p->rental_items))
                                                            <details class="rounded-md bg-slate-50 p-4 text-left">
                                                                <summary class="cursor-pointer rounded-md bg-sky-600 px-3 py-2 text-xs font-semibold text-white hover:bg-sky-700">Item Kosong</summary>
                                                                <form action="{{ route('admin.transaksi.partial', $p) }}" method="POST" class="mt-3 flex flex-col gap-3 text-xs">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <p class="font-semibold text-slate-950">Pilih item yang kosong</p>
                                                                    <div class="max-h-36 space-y-2 overflow-y-auto rounded-md border border-slate-200 bg-white p-3">
                                                                        @foreach($p->rental_items as $item)
                                                                            <label class="flex items-start gap-2 text-slate-600">
                                                                                <input type="checkbox" name="unavailable_items[]" value="{{ $item['nama'] }}" class="mt-0.5 rounded border-slate-300 text-sky-600">
                                                                                <span><span class="font-semibold text-slate-950">{{ $item['nama'] }}</span> x{{ $item['jumlah'] }}</span>
                                                                            </label>
                                                                        @endforeach
                                                                    </div>
                                                                    <input type="text" name="catatan_admin" placeholder="Catatan opsional" class="block w-full rounded-md border-slate-300 text-xs shadow-sm">
                                                                    <button class="block w-full rounded-md bg-sky-600 px-3 py-2 text-xs font-semibold text-white hover:bg-sky-700">Kirim ke Pengunjung</button>
                                                                </form>
                                                            </details>
                                                        @endif
                                                    </div>

                                                    <div class="rounded-md bg-slate-50 p-4">
                                                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Tolak Pesanan</p>
                                                        <form action="{{ route('admin.transaksi.reject', $p) }}" method="POST" class="mt-3 flex max-w-xl gap-2" onsubmit="return confirm('Tandai pesanan ditolak?');">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="text" name="catatan_admin" placeholder="Alasan tolak" class="min-w-0 flex-1 rounded-md border-slate-300 text-xs shadow-sm">
                                                            <button class="shrink-0 rounded-md bg-amber-600 px-4 py-2 text-xs font-semibold text-white hover:bg-amber-700">Tolak</button>
                                                        </form>
                                                    </div>
                                                @endif

                                                <div class="grid gap-4 md:grid-cols-2">
                                                    @if($p->status !== 'lunas' && $p->availability_status === 'approved')
                                                        <div class="rounded-md bg-slate-50 p-4">
                                                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Pembayaran</p>
                                                            <form action="{{ route('admin.verifikasi', $p) }}" method="POST" class="mt-3">
                                                                @csrf
                                                                <button class="w-full rounded-md bg-emerald-700 px-3 py-2 text-xs font-semibold text-white hover:bg-emerald-800">Verifikasi</button>
                                                            </form>
                                                        </div>
                                                    @endif

                                                    <div class="rounded-md bg-slate-50 p-4">
                                                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Kelola Data</p>
                                                        <div class="mt-3 flex flex-wrap gap-2">
                                                            <a href="{{ route('admin.transaksi.edit', $p) }}" class="rounded-md bg-sky-600 px-3 py-2 text-xs font-semibold text-white hover:bg-sky-700">Edit</a>

                                                            <form action="{{ route('admin.transaksi.destroy', $p) }}" method="POST" onsubmit="return confirm('Hapus transaksi ini? Stok tiket akan dikembalikan.');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="rounded-md bg-red-600 px-3 py-2 text-xs font-semibold text-white hover:bg-red-700">Hapus</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </dialog>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-12 text-center">
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
