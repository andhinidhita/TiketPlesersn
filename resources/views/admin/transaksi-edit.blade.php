@extends('layouts.admin')

@section('title', 'Edit Transaksi - Admin')
@section('page_title', 'Edit Transaksi')

@section('header_action')
    <a href="{{ route('admin.transaksi') }}" class="rounded-md border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100">
        Kembali
    </a>
@endsection

@section('content')
    <div class="max-w-3xl rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
        <div class="border-b border-slate-200 pb-5">
            <h3 class="text-base font-bold text-slate-950">Data Pemesanan</h3>
            <p class="mt-1 text-sm text-slate-500">
                {{ $pemesanan->user->name }} - {{ $pemesanan->user->email }}
            </p>
        </div>

        @if ($errors->any())
            <div class="mt-5 rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('admin.transaksi.update', $pemesanan) }}" method="POST" class="mt-6 space-y-5">
            @csrf
            @method('PATCH')

            <div>
                <label for="tiket_id" class="block text-sm font-semibold text-slate-700">Tiket</label>
                <select id="tiket_id" name="tiket_id" class="mt-2 w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-sky-600 focus:ring-sky-600">
                    @foreach ($tikets as $tiket)
                        <option value="{{ $tiket->id }}" @selected(old('tiket_id', $pemesanan->tiket_id) == $tiket->id)>
                            {{ $tiket->nama_tiket }} - Rp {{ number_format($tiket->harga,0,',','.') }} (Stok: {{ $tiket->stok }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label for="jumlah_tiket" class="block text-sm font-semibold text-slate-700">Jumlah Tiket</label>
                    <input id="jumlah_tiket" type="number" name="jumlah_tiket" min="1" value="{{ old('jumlah_tiket', $pemesanan->jumlah_tiket) }}"
                           class="mt-2 w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-sky-600 focus:ring-sky-600" required>
                </div>

                <div>
                    <label for="tanggal" class="block text-sm font-semibold text-slate-700">Tanggal Kunjungan</label>
                    <input id="tanggal" type="date" name="tanggal" value="{{ old('tanggal', optional($pemesanan->tanggal)->format('Y-m-d')) }}"
                           class="mt-2 w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-sky-600 focus:ring-sky-600" required>
                </div>
            </div>

            <div>
                <label for="status" class="block text-sm font-semibold text-slate-700">Status</label>
                <select id="status" name="status" class="mt-2 w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-sky-600 focus:ring-sky-600">
                    <option value="pending" @selected(old('status', $pemesanan->status) === 'pending')>Pending</option>
                    <option value="lunas" @selected(old('status', $pemesanan->status) === 'lunas')>Lunas</option>
                </select>
            </div>

            <div class="rounded-md bg-slate-50 p-4 text-sm text-slate-600">
                Total harga akan dihitung ulang otomatis dari harga tiket dan jumlah tiket.
            </div>

            <div class="flex justify-end gap-3 border-t border-slate-200 pt-5">
                <a href="{{ route('admin.transaksi') }}" class="rounded-md border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100">
                    Batal
                </a>
                <button class="rounded-md bg-sky-600 px-4 py-2 text-sm font-semibold text-white hover:bg-sky-700">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection
