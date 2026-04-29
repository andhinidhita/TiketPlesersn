@extends('layouts.user')

@section('title', 'Pesan Tiket - Bumi Perkemahan Pleseran')
@section('page_title', 'Pesan Tiket')

@section('content')
    <div class="grid gap-6 xl:grid-cols-[1fr_360px]">
        <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
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

            <form action="{{ route('pemesanan') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div class="grid gap-5 md:grid-cols-2">
                    <div class="md:col-span-2">
                        <label for="tiket_id" class="block text-sm font-semibold text-slate-700">Jenis Tiket</label>
                        <select id="tiket_id" name="tiket_id" class="mt-2 w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
                            @foreach($tikets as $tiket)
                                <option value="{{ $tiket->id }}" @selected(old('tiket_id') == $tiket->id) @disabled($tiket->stok < 1)>
                                    {{ $tiket->nama_tiket }} - Rp {{ number_format($tiket->harga,0,',','.') }} (Stok: {{ $tiket->stok }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="jumlah_tiket" class="block text-sm font-semibold text-slate-700">Jumlah Tiket</label>
                        <input id="jumlah_tiket" type="number" name="jumlah_tiket" min="1" value="{{ old('jumlah_tiket') }}"
                               class="mt-2 w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-emerald-600 focus:ring-emerald-600" required>
                    </div>

                    <div>
                        <label for="tanggal" class="block text-sm font-semibold text-slate-700">Tanggal Kunjungan</label>
                        <input id="tanggal" type="date" name="tanggal" value="{{ old('tanggal') }}"
                               class="mt-2 w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-emerald-600 focus:ring-emerald-600" required>
                    </div>

                    <div class="md:col-span-2">
                        <label for="bukti_pembayaran" class="block text-sm font-semibold text-slate-700">Bukti Pembayaran</label>
                        <input id="bukti_pembayaran" type="file" name="bukti_pembayaran"
                               class="mt-2 block w-full rounded-md border border-slate-300 text-sm text-slate-700 file:mr-4 file:border-0 file:bg-slate-950 file:px-4 file:py-2.5 file:text-sm file:font-semibold file:text-white hover:file:bg-slate-800">
                        <p class="mt-2 text-xs text-slate-500">Format JPG, JPEG, atau PNG. Maksimal 2 MB.</p>
                    </div>
                </div>

                <div class="flex flex-col gap-3 border-t border-slate-200 pt-6 sm:flex-row sm:items-center sm:justify-between">
                    <p class="max-w-xl text-sm text-slate-500">
                        Transfer ke BRI 6718-0105-2339-535. Pesanan akan berstatus pending sampai admin memverifikasi bukti pembayaran.
                    </p>
                    <button class="inline-flex items-center justify-center rounded-md bg-emerald-700 px-5 py-2.5 text-sm font-semibold text-white hover:bg-emerald-800">
                        Buat Pesanan
                    </button>
                </div>
            </form>
        </div>

        <aside class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-wide text-emerald-700">Informasi</p>
            <h3 class="mt-2 text-lg font-bold text-slate-950">Alur Pemesanan</h3>
            <div class="mt-5 space-y-4 text-sm text-slate-600">
                <div class="rounded-md bg-slate-50 p-4">
                    <p class="font-semibold text-slate-950">1. Pilih tiket</p>
                    <p class="mt-1">Pastikan stok tersedia untuk tanggal kunjunganmu.</p>
                </div>
                <div class="rounded-md bg-slate-50 p-4">
                    <p class="font-semibold text-slate-950">2. Transfer pembayaran</p>
                    <p class="mt-1">Gunakan nominal sesuai total yang muncul di invoice.</p>
                </div>
                <div class="rounded-md bg-slate-50 p-4">
                    <p class="font-semibold text-slate-950">3. Tunggu verifikasi</p>
                    <p class="mt-1">Admin akan mengecek bukti pembayaran sebelum status menjadi lunas.</p>
                </div>
            </div>
        </aside>
    </div>
@endsection
