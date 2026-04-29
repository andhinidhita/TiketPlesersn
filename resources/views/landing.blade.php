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
    <nav class="fixed inset-x-0 top-0 z-50 border-b border-white/10 bg-slate-950/85 px-5 py-4 text-white backdrop-blur sm:px-8">
        <div class="mx-auto flex max-w-7xl items-center justify-between">
            <a href="{{ route('landing') }}" class="font-bold tracking-tight">Bumi Perkemahan Pleseran</a>
            <div class="hidden items-center gap-6 text-sm font-medium md:flex">
                <a href="#about" class="text-white/80 hover:text-white">Tentang</a>
                <a href="#galeri" class="text-white/80 hover:text-white">Galeri</a>
                <a href="#contact" class="text-white/80 hover:text-white">Kontak</a>
            </div>
            <a href="{{ route('login') }}" class="rounded-md bg-white px-4 py-2 text-sm font-semibold text-slate-950 hover:bg-slate-100">
                Login
            </a>
        </div>
    </nav>

    <header class="relative min-h-[88vh] overflow-hidden">
        <img src="{{ asset('images/bg.png') }}" alt="Bumi Perkemahan Pleseran" class="absolute inset-0 h-full w-full object-cover">
        <div class="absolute inset-0 bg-slate-950/45"></div>
        <div class="relative z-10 mx-auto flex min-h-[88vh] max-w-7xl items-end px-5 pb-16 pt-28 sm:px-8">
            <div class="max-w-3xl text-white">
                <p class="text-sm font-semibold uppercase tracking-wide text-emerald-200">Tawangmangu, Karanganyar</p>
                <h1 class="mt-4 text-4xl font-extrabold tracking-tight sm:text-6xl">Bumi Perkemahan Pleseran</h1>
                <p class="mt-5 max-w-2xl text-base leading-7 text-white/85 sm:text-lg">
                    Area camping dan wisata alam dengan suasana hutan, aliran sungai, dan udara pegunungan yang cocok untuk liburan keluarga maupun kegiatan komunitas.
                </p>
                <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                    <a href="{{ auth()->check() ? route('pemesanan') : route('login') }}" class="inline-flex items-center justify-center rounded-md bg-emerald-600 px-5 py-3 text-sm font-semibold text-white hover:bg-emerald-700">
                        Pesan Tiket
                    </a>
                    <a href="#galeri" class="inline-flex items-center justify-center rounded-md border border-white/40 px-5 py-3 text-sm font-semibold text-white hover:bg-white/10">
                        Lihat Galeri
                    </a>
                </div>
            </div>
        </div>
    </header>

    <section id="about" class="px-5 py-16 sm:px-8">
        <div class="mx-auto grid max-w-7xl gap-10 lg:grid-cols-[1fr_1.2fr] lg:items-center">
            <img src="{{ asset('images/about.png') }}" alt="Area wisata Pleseran" class="h-full max-h-[460px] w-full rounded-lg object-cover shadow-sm">
            <div>
                <p class="text-sm font-semibold uppercase tracking-wide text-emerald-700">Tentang Lokasi</p>
                <h2 class="mt-3 text-3xl font-bold tracking-tight text-slate-950">Wisata alam yang tenang dan mudah diakses.</h2>
                <p class="mt-5 leading-7 text-slate-600">
                    Bumi Perkemahan Pleseran berada di kawasan Tawangmangu, Karanganyar. Tempat ini dikenal sebagai area camping dan wisata alam dengan suasana yang sejuk, cocok untuk berkemah, berkumpul, dan menikmati waktu di luar ruangan.
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

    <section id="galeri" class="bg-slate-50 px-5 py-16 sm:px-8">
        <div class="mx-auto max-w-7xl">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-wide text-emerald-700">Galeri</p>
                    <h2 class="mt-3 text-3xl font-bold tracking-tight text-slate-950">Suasana Pleseran</h2>
                </div>
                <a href="{{ auth()->check() ? route('pemesanan') : route('login') }}" class="text-sm font-semibold text-emerald-700 hover:text-emerald-800">Pesan tiket sekarang</a>
            </div>

            <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <img src="{{ asset('images/g1.png') }}" alt="Galeri Pleseran 1" class="aspect-[4/3] w-full rounded-lg object-cover shadow-sm">
                <img src="{{ asset('images/g2.png') }}" alt="Galeri Pleseran 2" class="aspect-[4/3] w-full rounded-lg object-cover shadow-sm">
                <img src="{{ asset('images/g3.png') }}" alt="Galeri Pleseran 3" class="aspect-[4/3] w-full rounded-lg object-cover shadow-sm">
                <img src="{{ asset('images/g4.png') }}" alt="Galeri Pleseran 4" class="aspect-[4/3] w-full rounded-lg object-cover shadow-sm">
            </div>
        </div>
    </section>

    <section class="px-5 py-16 sm:px-8">
        <div class="mx-auto grid max-w-7xl gap-8 rounded-lg bg-slate-950 p-6 text-white sm:p-10 lg:grid-cols-[1.1fr_0.9fr] lg:items-center">
            <div>
                <p class="text-sm font-semibold uppercase tracking-wide text-emerald-200">Reservasi Online</p>
                <h2 class="mt-3 text-3xl font-bold tracking-tight">Pesan tiket tanpa harus antre di lokasi.</h2>
                <p class="mt-4 leading-7 text-white/75">Pilih tiket, isi tanggal kunjungan, unggah bukti pembayaran, lalu tunggu admin memverifikasi pesananmu.</p>
                <a href="{{ auth()->check() ? route('pemesanan') : route('login') }}" class="mt-7 inline-flex rounded-md bg-emerald-600 px-5 py-3 text-sm font-semibold text-white hover:bg-emerald-700">
                    Mulai Pesan
                </a>
            </div>
            <img src="{{ asset('images/g5.png') }}" alt="Area camping Pleseran" class="aspect-[4/3] w-full rounded-lg object-cover">
        </div>
    </section>

    <footer id="contact" class="border-t border-slate-200 bg-white px-5 py-10 sm:px-8">
        <div class="mx-auto grid max-w-7xl gap-6 text-sm text-slate-600 md:grid-cols-3">
            <div>
                <p class="font-bold text-slate-950">Bumi Perkemahan Pleseran</p>
                <p class="mt-2">Jalan Candi Menggung Nglurah, Area Hutan, Tawangmangu, Karanganyar Regency, Central Java 57792.</p>
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
</body>
</html>
