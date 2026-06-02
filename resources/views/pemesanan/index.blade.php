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
                                <option value="{{ $tiket->id }}" data-camping="{{ str_contains(strtolower($tiket->nama_tiket), 'camping') ? '1' : '0' }}" @selected(old('tiket_id') == $tiket->id) @disabled($tiket->stok < 1)>
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

                    <div>
                        <label for="durasi" class="block text-sm font-semibold text-slate-700">Durasi Hari</label>
                        <input id="durasi" type="number" name="durasi" min="1" value="{{ old('durasi', 1) }}"
                               class="mt-2 w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-emerald-600 focus:ring-emerald-600" required>
                        <p class="mt-2 text-xs text-slate-500">Untuk camping, harga paket dikalikan jumlah hari.</p>
                    </div>

                    <div id="paket-camping-wrap" class="hidden md:col-span-2">
                        <label for="paket_camping" class="block text-sm font-semibold text-slate-700">Paket Camping</label>
                        <select id="paket_camping" name="paket_camping" class="mt-2 w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
                            <option value="">Pilih paket camping</option>
                            @foreach($campingPackages as $nama => $paket)
                                <option value="{{ $nama }}" data-harga="{{ $paket['harga'] }}" data-fasilitas="{{ $paket['fasilitas'] }}" @selected(old('paket_camping') === $nama)>
                                    {{ $nama }} - Rp {{ number_format($paket['harga'],0,',','.') }}
                                </option>
                            @endforeach
                        </select>
                        <div id="paket-detail" class="mt-3 hidden rounded-md bg-emerald-50 p-4 text-sm text-slate-700">
                            <p class="font-semibold text-emerald-800" id="paket-harga"></p>
                            <p class="mt-1" id="paket-fasilitas"></p>
                        </div>
                    </div>

                    <div id="rental-wrap" class="hidden md:col-span-2">
                        <div class="flex flex-col gap-1 sm:flex-row sm:items-end sm:justify-between">
                            <div>
                                <p class="block text-sm font-semibold text-slate-700">Rental Item Tambahan</p>
                                <p class="mt-1 text-xs text-slate-500">Opsional. Admin akan mengonfirmasi jika ada item yang kosong.</p>
                            </div>
                            <p id="rental-total-preview" class="text-sm font-bold text-emerald-700">Rp 0/hari</p>
                        </div>
                        <div class="mt-3 grid gap-3 sm:grid-cols-2">
                            @foreach($rentalItems as $nama => $harga)
                                <div class="rounded-md border border-slate-200 p-3">
                                    <div class="flex items-start justify-between gap-3">
                                        <div>
                                            <p class="text-sm font-semibold text-slate-950">{{ $nama }}</p>
                                            <p class="mt-1 text-xs text-slate-500">Rp {{ number_format($harga,0,',','.') }}/hari</p>
                                        </div>
                                        <input type="number" min="0" name="rental_items[{{ $nama }}]" value="{{ old('rental_items.'.$nama, 0) }}"
                                               data-rental-price="{{ $harga }}"
                                               class="rental-input w-20 rounded-md border-slate-300 text-sm shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- <div class="md:col-span-2">
                        <label for="bukti_pembayaran" class="block text-sm font-semibold text-slate-700">Bukti Pembayaran</label>
                        <input id="bukti_pembayaran" type="file" name="bukti_pembayaran"
                               class="mt-2 block w-full rounded-md border border-slate-300 text-sm text-slate-700 file:mr-4 file:border-0 file:bg-slate-950 file:px-4 file:py-2.5 file:text-sm file:font-semibold file:text-white hover:file:bg-slate-800">
                        <p class="mt-2 text-xs text-slate-500">Format JPG, JPEG, atau PNG. Maksimal 2 MB.</p>
                    </div> -->
                </div>

                <div class="flex flex-col gap-3 border-t border-slate-200 pt-6 sm:flex-row sm:items-center sm:justify-between">
                    <!-- <p class="max-w-xl text-sm text-slate-500">
                        Pesanan camping akan dikonfirmasi admin terlebih dahulu sebelum kamu bisa lanjut pembayaran.
                    </p> -->
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
                    <p class="mt-1">Untuk camping, tunggu admin mengonfirmasi paket tersedia sebelum lanjut bayar.</p>
                </div>
                <div class="rounded-md bg-slate-50 p-4">
                    <p class="font-semibold text-slate-950">3. Lanjut pembayaran</p>
                    <p class="mt-1">Kalau tersedia, tombol pembayaran akan muncul di invoice.</p>
                </div>
            </div>
        </aside>
    </div>

    <script>
        const tiketSelect = document.getElementById('tiket_id');
        const paketWrap = document.getElementById('paket-camping-wrap');
        const paketSelect = document.getElementById('paket_camping');
        const paketDetail = document.getElementById('paket-detail');
        const paketHarga = document.getElementById('paket-harga');
        const paketFasilitas = document.getElementById('paket-fasilitas');
        const rentalWrap = document.getElementById('rental-wrap');
        const rentalInputs = document.querySelectorAll('.rental-input');
        const rentalTotalPreview = document.getElementById('rental-total-preview');

        function formatRupiah(value) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0,
            }).format(value);
        }

        function togglePaketCamping() {
            const selected = tiketSelect.options[tiketSelect.selectedIndex];
            const isCamping = selected && selected.dataset.camping === '1';

            paketWrap.classList.toggle('hidden', !isCamping);
            rentalWrap.classList.toggle('hidden', !isCamping);
            paketSelect.required = isCamping;

            if (!isCamping) {
                paketSelect.value = '';
                paketDetail.classList.add('hidden');
            }
        }

        function updateRentalTotal() {
            let total = 0;

            rentalInputs.forEach((input) => {
                total += Number(input.dataset.rentalPrice || 0) * Number(input.value || 0);
            });

            rentalTotalPreview.textContent = formatRupiah(total) + '/hari';
        }

        function showPaketDetail() {
            const selected = paketSelect.options[paketSelect.selectedIndex];

            if (!selected || !selected.value) {
                paketDetail.classList.add('hidden');
                return;
            }

            paketHarga.textContent = formatRupiah(Number(selected.dataset.harga || 0)) + ' per hari';
            paketFasilitas.textContent = selected.dataset.fasilitas;
            paketDetail.classList.remove('hidden');
        }

        tiketSelect.addEventListener('change', togglePaketCamping);
        paketSelect.addEventListener('change', showPaketDetail);
        rentalInputs.forEach((input) => input.addEventListener('input', updateRentalTotal));
        togglePaketCamping();
        showPaketDetail();
        updateRentalTotal();
    </script>
@endsection
