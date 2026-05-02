<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bumi Perkemahan Pleseran</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white font-sans text-slate-900 antialiased">
    <nav
        class="fixed inset-x-0 top-0 z-50 border-b border-white/10 bg-slate-950/85 px-5 py-4 text-white backdrop-blur sm:px-8">
        <div class="mx-auto flex max-w-7xl items-center justify-between">
            <a href="{{ route('landing') }}" class="font-bold tracking-tight">Bumi Perkemahan Pleseran</a>
            <div class="hidden items-center gap-6 text-sm font-medium md:flex">
                <a href="#about" class="text-white/80 hover:text-white">Tentang</a>
                <a href="#galeri" class="text-white/80 hover:text-white">Galeri</a>
                <a href="#contact" class="text-white/80 hover:text-white">Kontak</a>
            </div>
            <a href="{{ route('login') }}"
                class="rounded-md bg-white px-4 py-2 text-sm font-semibold text-slate-950 hover:bg-slate-100">
                Login
            </a>
        </div>
    </nav>

    <header class="relative min-h-[88vh] overflow-hidden">
        <img src="{{ asset('images/bg.png') }}" alt="Bumi Perkemahan Pleseran"
            class="absolute inset-0 h-full w-full object-cover">
        <div class="absolute inset-0 bg-slate-950/45"></div>
        <div class="relative z-10 mx-auto flex min-h-[88vh] max-w-7xl items-end px-5 pb-16 pt-28 sm:px-8">
            <div class="max-w-3xl text-white">
                <p class="text-sm font-semibold uppercase tracking-wide text-emerald-200">Tawangmangu, Karanganyar</p>
                <h1 class="mt-4 text-4xl font-extrabold tracking-tight sm:text-6xl">Bumi Perkemahan Pleseran</h1>
                <p class="mt-5 max-w-2xl text-base leading-7 text-white/85 sm:text-lg">
                    Area camping dan wisata alam dengan suasana hutan, aliran sungai, dan udara pegunungan yang cocok
                    untuk liburan keluarga maupun kegiatan komunitas.
                </p>
                <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                    <a href="{{ auth()->check() ? route('pemesanan') : route('login') }}"
                        class="inline-flex items-center justify-center rounded-md bg-emerald-600 px-5 py-3 text-sm font-semibold text-white hover:bg-emerald-700">
                        Pesan Tiket
                    </a>
                    <a href="#galeri"
                        class="inline-flex items-center justify-center rounded-md border border-white/40 px-5 py-3 text-sm font-semibold text-white hover:bg-white/10">
                        Lihat Galeri
                    </a>
                </div>
            </div>
        </div>
    </header>

    <section id="about" class="px-5 py-16 sm:px-8">
        <div class="mx-auto grid max-w-7xl gap-10 lg:grid-cols-[1fr_1.2fr] lg:items-center">
            <img src="{{ asset('images/about.png') }}" alt="Area wisata Pleseran"
                class="h-full max-h-[460px] w-full rounded-lg object-cover shadow-sm">
            <div>
                <p class="text-sm font-semibold uppercase tracking-wide text-emerald-700">Tentang Lokasi</p>
                <h2 class="mt-3 text-3xl font-bold tracking-tight text-slate-950">Wisata alam yang tenang dan mudah
                    diakses.</h2>
                <p class="mt-5 leading-7 text-slate-600">
                    Bumi Perkemahan Pleseran berada di kawasan Tawangmangu, Karanganyar. Tempat ini dikenal sebagai area
                    camping dan wisata alam dengan suasana yang sejuk, cocok untuk berkemah, berkumpul, dan menikmati
                    waktu di luar ruangan.
                </p>
                <div class="mt-8 grid gap-4 sm:grid-cols-3">
                    <div class="rounded-lg border border-slate-200 p-4">
                        <p class="text-2xl font-bold text-slate-950">2.5 ha</p>
                        <p class="mt-1 text-sm text-slate-500">Area wisata</p>
                    </div>
                    <div class="rounded-lg border border-slate-200 p-4">
                        <p class="text-2xl font-bold text-slate-950">2016</p>
                        <p class="mt-1 text-sm text-slate-500">Mulai dikelola</p>
                    </div>
                    <div class="rounded-lg border border-slate-200 p-4">
                        <p class="text-2xl font-bold text-slate-950">24/7</p>
                        <p class="mt-1 text-sm text-slate-500">Camping area</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>

    <section id="galeri" class="relative bg-slate-50 px-5 py-16 sm:px-8">
        <div class="mx-auto max-w-7xl">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-wide text-emerald-700">Galeri</p>
                    <h2 class="mt-3 text-3xl font-bold tracking-tight text-slate-950">Suasana Pleseran</h2>
                </div>
                <div class="flex items-center gap-4">
                    <a href="{{ auth()->check() ? route('pemesanan') : route('login') }}"
                        class="hidden text-sm font-semibold text-emerald-700 hover:text-emerald-800 sm:block">Pesan
                        tiket sekarang</a>

                    {{-- Tombol Navigasi Slider (Geser Kiri/Kanan) --}}
                    <div class="flex gap-2">
                        <button id="btn-prev"
                            class="flex h-10 w-10 items-center justify-center rounded-full border border-slate-300 bg-white text-slate-600 shadow-sm transition hover:border-emerald-200 hover:bg-emerald-50 hover:text-emerald-700">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                        <button id="btn-next"
                            class="flex h-10 w-10 items-center justify-center rounded-full border border-slate-300 bg-white text-slate-600 shadow-sm transition hover:border-emerald-200 hover:bg-emerald-50 hover:text-emerald-700">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Slider Container --}}
            <div id="gallery-slider"
                class="hide-scrollbar mt-8 flex snap-x snap-mandatory gap-4 overflow-x-auto scroll-smooth">
                @forelse ($galeris as $item)
                    {{-- Item Gambar --}}
                    <div class="w-[85%] shrink-0 snap-center sm:w-[45%] lg:w-[23.5%]">
                        <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul ?? 'Galeri Pleseran' }}"
                            data-caption="{{ $item->judul }}"
                            class="gallery-item aspect-[4/3] w-full cursor-zoom-in rounded-2xl object-cover shadow-sm transition hover:opacity-80">
                    </div>
                @empty
                    <div class="w-full rounded-2xl border border-dashed border-slate-300 bg-white p-10 text-center">
                        <p class="text-sm text-slate-500">Belum ada foto yang diunggah oleh Admin.</p>
                    </div>
                @endforelse
            </div>

            <a href="{{ auth()->check() ? route('pemesanan') : route('login') }}"
                class="mt-6 inline-block text-sm font-semibold text-emerald-700 hover:text-emerald-800 sm:hidden">Pesan
                tiket sekarang &rarr;</a>
        </div>
    </section>

    {{-- ========================================== --}}
    {{--    LIGHTBOX MODAL (UNTUK GAMBAR BESAR)     --}}
    {{-- ========================================== --}}
    <div id="lightbox"
        class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/95 backdrop-blur-sm transition-opacity"
        onclick="closeLightbox()">
        {{-- Tombol Tutup --}}
        <button class="absolute right-6 top-6 text-white/70 transition hover:text-white" onclick="closeLightbox()">
            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        {{-- Gambar Utama --}}
        <div class="relative w-full max-w-5xl px-4 text-center">
            <img id="lightbox-img" src="" alt="View"
                class="mx-auto max-h-[80vh] rounded-lg object-contain shadow-2xl" onclick="event.stopPropagation()">
            <p id="lightbox-caption" class="mt-4 text-lg font-medium text-white"></p>
        </div>
    </div>

    <section class="px-5 py-16 sm:px-8">
        <div
            class="mx-auto grid max-w-7xl gap-8 rounded-lg bg-slate-950 p-6 text-white sm:p-10 lg:grid-cols-[1.1fr_0.9fr] lg:items-center">
            <div>
                <p class="text-sm font-semibold uppercase tracking-wide text-emerald-200">Reservasi Online</p>
                <h2 class="mt-3 text-3xl font-bold tracking-tight">Pesan tiket tanpa harus antre di lokasi.</h2>
                <p class="mt-4 leading-7 text-white/75">Pilih tiket, isi tanggal kunjungan, unggah bukti pembayaran,
                    lalu tunggu admin memverifikasi pesananmu.</p>
                <a href="{{ auth()->check() ? route('pemesanan') : route('login') }}"
                    class="mt-7 inline-flex rounded-md bg-emerald-600 px-5 py-3 text-sm font-semibold text-white hover:bg-emerald-700">
                    Mulai Pesan
                </a>
            </div>
            <img src="{{ asset('images/g5.png') }}" alt="Area camping Pleseran"
                class="aspect-[4/3] w-full rounded-lg object-cover">
        </div>
    </section>

    <footer id="contact" class="border-t border-slate-200 bg-white px-5 py-10 sm:px-8">
        <div class="mx-auto grid max-w-7xl gap-6 text-sm text-slate-600 md:grid-cols-3">
            <div>
                <p class="font-bold text-slate-950">Bumi Perkemahan Pleseran</p>
                <p class="mt-2">Jalan Candi Menggung Nglurah, Area Hutan, Tawangmangu, Karanganyar Regency, Central
                    Java 57792.</p>
            </div>
            <div>
                <p class="font-semibold text-slate-950">Kontak</p>
                <p class="mt-2">WA: 0812-2637-1995</p>
                <p>Email: BuperPleseran@gmail.com</p>
            </div>
            <div class="md:text-right">
                <p class="font-semibold text-slate-950">Layanan</p>
                <p class="mt-2">Tiket masuk dan camping area.</p>
            </div>
        </div>
    </footer>

    <script>
        // --- 1. LOGIKA SLIDER (GESER KIRI KANAN) ---
        const slider = document.getElementById('gallery-slider');
        const btnPrev = document.getElementById('btn-prev');
        const btnNext = document.getElementById('btn-next');

        if (slider && btnPrev && btnNext) {
            btnNext.addEventListener('click', () => {
                // Geser sebesar 1 gambar (mengambil lebar dari salah satu elemen anak)
                const scrollAmount = slider.firstElementChild.clientWidth + 16; // 16 adalah gap-4
                slider.scrollBy({
                    left: scrollAmount,
                    behavior: 'smooth'
                });
            });

            btnPrev.addEventListener('click', () => {
                const scrollAmount = slider.firstElementChild.clientWidth + 16;
                slider.scrollBy({
                    left: -scrollAmount,
                    behavior: 'smooth'
                });
            });
        }

        // --- 2. LOGIKA LIGHTBOX (KLIK GAMBAR BESAR) ---
        const lightbox = document.getElementById('lightbox');
        const lightboxImg = document.getElementById('lightbox-img');
        const lightboxCaption = document.getElementById('lightbox-caption');

        // Tambahkan event ke setiap gambar di galeri
        document.querySelectorAll('.gallery-item').forEach(item => {
            item.addEventListener('click', function() {
                // Set sumber gambar dan caption ke dalam lightbox
                lightboxImg.src = this.src;
                lightboxCaption.textContent = this.dataset.caption || '';

                // Tampilkan lightbox
                lightbox.classList.remove('hidden');
                lightbox.classList.add('flex');

                // Mencegah background scrolling
                document.body.style.overflow = 'hidden';
            });
        });

        // Fungsi tutup lightbox
        function closeLightbox() {
            lightbox.classList.add('hidden');
            lightbox.classList.remove('flex');

            // Kembalikan background scrolling
            document.body.style.overflow = 'auto';
        }
    </script>
</body>

</html>
