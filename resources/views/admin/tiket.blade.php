@extends('layouts.admin')

@section('title', 'Tiket Wisata - Admin')
@section('page_title', 'Tiket Wisata')
@section('subtitle', 'Pantau harga dan stok tiket yang tersedia untuk pengunjung.')

@section('content')
    {{-- Header Section: Judul dan Tombol Tambah --}}
    <div class="mb-8 flex items-center justify-between">
        {{-- Notifikasi Sukses --}}
        @if (session('success'))
            <div class="mb-6 flex items-center rounded-xl bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700">
                <svg class="mr-3 h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ session('success') }}
            </div>
        @endif
        <div>
            <h1 class="text-3xl font-extrabold text-slate-950">@yield('page_title')</h1>
            <p class="mt-1.5 text-sm text-slate-600">@yield('subtitle')</p>
        </div>
        {{-- Tombol Tambah yang Akan Memicu Modal --}}
        <button id="btn-tambah"
            class="inline-flex items-center gap-2 rounded-xl bg-slate-950 px-5 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-slate-800">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Tiket Baru
        </button>
    </div>

    {{-- Main Card Section --}}
    <div class="overflow-hidden rounded-[28px] border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 px-6 py-5">
            <p class="text-xs font-extrabold uppercase tracking-[0.28em] text-slate-400">Inventori</p>
            <h3 class="mt-2 text-xl font-extrabold text-slate-950">Daftar Tiket</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-extrabold uppercase tracking-widest text-slate-500">Nama
                            Tiket</th>
                        <th class="px-6 py-4 text-left text-xs font-extrabold uppercase tracking-widest text-slate-500">
                            Harga</th>
                        <th class="text-center px-6 py-4 text-xs font-extrabold uppercase tracking-widest text-slate-500">Stok
                        </th>
                        <th class="text-center px-6 py-4 text-xs font-extrabold uppercase tracking-widest text-slate-500">Aksi
                        </th> {{-- Kolom Aksi Baru --}}
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse ($tikets as $tiket)
                        <tr>
                            <td class="px-6 py-5 text-sm font-extrabold text-slate-950">{{ $tiket->nama_tiket }}</td>
                            <td class="px-6 py-5 text-sm font-semibold text-slate-600">Rp
                                {{ number_format($tiket->harga, 0, ',', '.') }}</td>
                            <td class="text-center px-6 py-5 text-sm font-semibold text-slate-600">{{ $tiket->stok }}</td>
                            <td class="flex items-center justify-center space-x-2 px-6 py-5 text-sm font-semibold">
                                <button type="button"
                                    class="btn-edit rounded-md bg-sky-600 px-3 py-2 text-xs font-semibold text-white hover:bg-sky-700"
                                    data-id="{{ $tiket->id }}" data-nama="{{ $tiket->nama_tiket }}"
                                    data-harga="{{ $tiket->harga }}" data-stok="{{ $tiket->stok }}">
                                    Edit
                                </button>

                                <form action="{{ route('admin.tiket.destroy', $tiket->id) }}" method="POST"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus tiket ini?');"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="rounded-md bg-red-600 px-3 py-2 text-xs font-semibold text-white hover:bg-red-700">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-14 text-center text-sm text-slate-500">Belum ada data tiket.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ========================================== --}}
    {{--    MODAL FORM (TAMBAH / EDIT) SECTION    --}}
    {{-- ========================================== --}}
    {{-- Container utama modal (full screen fixed, tersembunyi dengan 'hidden') --}}
    <div id="modal-form"
        class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/50 p-4 backdrop-blur-sm transition-opacity"
        onclick="handleOverlayClick(event)">

        {{-- Inner Card Modal --}}
        <div class="relative w-full max-w-xl scale-95 transform rounded-[28px] bg-white p-8 shadow-2xl transition-transform"
            onclick="event.stopPropagation()">

            {{-- Header Modal --}}
            <div class="mb-8">
                <h3 id="modal-title" class="text-2xl font-extrabold text-slate-950">Aksi Tiket</h3>
                <p id="modal-subtitle" class="mt-1.5 text-sm text-slate-600">Isi detail tiket wisata di bawah ini.</p>
                <button type="button"
                    class="modal-close absolute right-6 top-6 text-slate-400 transition hover:text-slate-600">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Form yang isinya dinamis lewat JS --}}
            <form id="tiket-form" method="POST">
                @csrf
                {{-- Input tersembunyi untuk metode PUT saat edit --}}
                <div id="method-container"></div>

                <div class="space-y-6">
                    {{-- Input Nama Tiket --}}
                    <div>
                        <label for="nama_tiket" class="block text-sm font-bold text-slate-950">Nama Tiket</label>
                        <input type="text" name="nama_tiket" id="nama_tiket"
                            class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3.5 text-sm font-semibold text-slate-950 focus:border-emerald-500 focus:ring-emerald-500"
                            placeholder="Contoh: Tiket Masuk Akhir Pekan">
                        @error('nama_tiket')
                            <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Grid untuk Harga dan Stok --}}
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label for="harga" class="block text-sm font-bold text-slate-950">Harga (Rp)</label>
                            <input type="number" name="harga" id="harga"
                                class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3.5 text-sm font-semibold text-slate-950 focus:border-emerald-500 focus:ring-emerald-500"
                                placeholder="0">
                            @error('harga')
                                <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="stok" class="block text-sm font-bold text-slate-950">Stok</label>
                            <input type="number" name="stok" id="stok"
                                class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3.5 text-sm font-semibold text-slate-950 focus:border-emerald-500 focus:ring-emerald-500"
                                placeholder="0">
                            @error('stok')
                                <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Footer Modal: Tombol Aksi --}}
                <div class="mt-10 flex items-center justify-end gap-3 border-t border-slate-100 pt-8">
                    <button type="button"
                        class="modal-close rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-bold text-slate-700 transition hover:bg-slate-50">
                        Batal
                    </button>
                    <button type="submit"
                        class="rounded-xl bg-emerald-700 px-5 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-emerald-800">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ========================================== --}}
    {{--        JAVASCRIPT HANDLING MODAL         --}}
    {{-- ========================================== --}}
    <script type="text/javascript">
        // 1. Ambil semua elemen DOM yang dibutuhkan
        const modalForm = document.getElementById('modal-form');
        const form = document.getElementById('tiket-form');
        const methodContainer = document.getElementById('method-container');
        const modalTitle = document.getElementById('modal-title');
        const modalSubtitle = document.getElementById('modal-subtitle');
        const modalCloses = document.querySelectorAll('.modal-close');

        const btnTambah = document.getElementById('btn-tambah');
        const inputNama = document.getElementById('nama_tiket');
        const inputHarga = document.getElementById('harga');
        const inputStok = document.getElementById('stok');

        // 2. Fungsi umum untuk menampilkan/menyembunyikan modal
        function toggleModal() {
            modalForm.classList.toggle('hidden');
            modalForm.classList.toggle('flex');
            // Sedikit trik JS untuk memastikan efek transisi 'hidden applies the same CSS properties as flex' tidak bentrok
        }

        // 3. Tangani Aksi Klik "Tambah Tiket Baru"
        btnTambah.addEventListener('click', function() {
            // Reset Form ke keadaan kosong
            form.reset();
            methodContainer.innerHTML = ''; // Hapus input PUT

            // Atur URL form untuk route STORE (Pastikan routenya sudah benar)
            form.action = "{{ route('admin.tiket.store') }}";

            // Ubah Teks Modal
            modalTitle.textContent = 'Tambah Tiket Baru';
            modalSubtitle.textContent = 'Isi detail tiket wisata di bawah ini untuk menambah inventori.';

            // Tampilkan Modal
            toggleModal();
        });

        // 4. Tangani Aksi Klik Tombol "Edit" pada tabel (Event Delegation)
        document.querySelectorAll('.btn-edit').forEach(button => {
            button.addEventListener('click', function() {
                // Ambil data dari atribut tombol yang diklik
                const id = this.getAttribute('data-id');
                const nama = this.getAttribute('data-nama');
                const harga = this.getAttribute('data-harga');
                const stok = this.getAttribute('data-stok');

                // Isi form dengan data tiket tersebut
                inputNama.value = nama;
                inputHarga.value = harga;
                inputStok.value = stok;

                // Atur URL form untuk route UPDATE dengan ID tiket (Ganti :id secara dinamis)
                let updateUrl = "{{ route('admin.tiket.update', ':id') }}";
                form.action = updateUrl.replace(':id', id);

                // Tambahkan input tersembunyi untuk metode PUT
                methodContainer.innerHTML = '@method('PUT')';

                // Ubah Teks Modal
                modalTitle.textContent = 'Edit Data Tiket';
                modalSubtitle.textContent = 'Perbarui detail data tiket ' + nama + ' di bawah ini.';

                // Tampilkan Modal
                toggleModal();
            });
        });

        // 5. Tangani Penutupan Modal (Tombol Batal, Tanda Silang)
        modalCloses.forEach(closeBtn => {
            closeBtn.addEventListener('click', toggleModal);
        });

        // 6. Fungsi opsional: Menutup modal dengan mengklik area overlay (luar kotak modal)
        function handleOverlayClick(event) {
            if (event.target === modalForm) {
                toggleModal();
            }
        }
    </script>
@endsection
