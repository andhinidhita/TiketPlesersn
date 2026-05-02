@extends('layouts.admin')

@section('title', 'Galeri - Admin')
@section('page_title', 'Galeri Wisata')
@section('subtitle', 'Kelola foto-foto menarik untuk ditampilkan di landing page.')

@section('content')
    {{-- Header Section --}}
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-950">@yield('page_title')</h1>
            <p class="mt-1.5 text-sm text-slate-600">@yield('subtitle')</p>
        </div>
        {{-- Tombol Pemicu Modal Upload --}}
        <button onclick="toggleModal()" class="inline-flex items-center gap-2 rounded-xl bg-slate-950 px-5 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-slate-800 transition">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Unggah Foto
        </button>
    </div>

    {{-- Notifikasi Sukses --}}
    @if(session('success'))
        <div class="mb-6 flex items-center rounded-xl bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700">
            <svg class="mr-3 h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Grid Layout untuk Galeri --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse ($galeris as $item)
            {{-- Kartu Foto --}}
            <div class="group relative overflow-hidden rounded-[24px] bg-white shadow-sm border border-slate-200">
                {{-- Menampilkan Gambar --}}
                <img src="{{ asset('storage/' . $item->gambar) }}" alt="Galeri" class="h-56 w-full object-cover transition duration-300 group-hover:scale-105">
                
                {{-- Overlay & Tombol Hapus (Muncul saat di-hover) --}}
                <div class="absolute inset-0 bg-slate-900/40 opacity-0 transition-opacity duration-300 group-hover:opacity-100 flex items-center justify-center">
                    <form action="{{ route('admin.galeri.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus foto ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="rounded-lg bg-red-600 px-4 py-2 text-sm font-bold text-white hover:bg-red-700 shadow-lg transition">
                            Hapus Foto
                        </button>
                    </form>
                </div>
                
                {{-- Caption/Judul (Jika ada) --}}
                @if($item->judul)
                    <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-slate-900/90 to-transparent p-4 pt-10">
                        <p class="text-sm font-semibold text-white truncate">{{ $item->judul }}</p>
                    </div>
                @endif
            </div>
        @empty
            {{-- Tampilan jika galeri kosong --}}
            <div class="col-span-full rounded-[28px] border border-dashed border-slate-300 bg-slate-50 p-10 text-center">
                <p class="text-sm font-semibold text-slate-500">Belum ada foto di galeri. Silakan unggah foto baru.</p>
            </div>
        @endforelse
    </div>

    {{-- ========================================== --}}
    {{--        MODAL UPLOAD FOTO SECTION         --}}
    {{-- ========================================== --}}
    <div id="modal-form" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm transition-opacity" onclick="handleOverlayClick(event)">
        <div class="relative w-full max-w-lg rounded-[28px] bg-white p-8 shadow-2xl transition-transform" onclick="event.stopPropagation()">
            
            <div class="mb-8">
                <h3 class="text-2xl font-extrabold text-slate-950">Unggah Foto Baru</h3>
                <p class="mt-1.5 text-sm text-slate-600">Pilih foto dari perangkat Anda untuk ditampilkan di galeri.</p>
                <button type="button" onclick="toggleModal()" class="absolute top-6 right-6 text-slate-400 hover:text-slate-600 transition">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Form Upload (WAJIB ada enctype="multipart/form-data") --}}
            <form action="{{ route('admin.galeri.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="space-y-6">
                    <div>
                        <label for="gambar" class="block text-sm font-bold text-slate-950">File Foto <span class="text-red-500">*</span></label>
                        <input type="file" name="gambar" id="gambar" accept="image/jpeg, image/png, image/webp" required 
                               class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-950 focus:border-emerald-500 focus:ring-emerald-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                        <p class="mt-1.5 text-xs text-slate-500">Format: JPG, PNG, WEBP. Maksimal 3MB.</p>
                        @error('gambar') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="judul" class="block text-sm font-bold text-slate-950">Judul / Keterangan (Opsional)</label>
                        <input type="text" name="judul" id="judul" class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3.5 text-sm font-semibold text-slate-950 focus:border-emerald-500 focus:ring-emerald-500" placeholder="Contoh: Pemandangan Sunset di Danau">
                        @error('judul') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="mt-10 flex items-center justify-end gap-3 border-t border-slate-100 pt-8">
                    <button type="button" onclick="toggleModal()" class="rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-bold text-slate-700 hover:bg-slate-50 transition">
                        Batal
                    </button>
                    <button type="submit" class="rounded-xl bg-emerald-700 px-5 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-emerald-800 transition">
                        Unggah Sekarang
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Script untuk mengatur Modal --}}
    <script>
        const modalForm = document.getElementById('modal-form');

        function toggleModal() {
            modalForm.classList.toggle('hidden');
            modalForm.classList.toggle('flex');
        }

        function handleOverlayClick(event) {
            if (event.target === modalForm) {
                toggleModal();
            }
        }
    </script>
@endsection