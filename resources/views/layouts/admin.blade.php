<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin - Bumi Perkemahan Pleseran')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 font-sans text-slate-900 antialiased">
    <div class="min-h-screen lg:grid lg:grid-cols-[280px_1fr]">
        <aside class="border-b border-slate-200 bg-slate-950 text-white lg:min-h-screen lg:border-b-0">
            <div class="border-b border-white/10 px-5 py-6">
                <p class="text-xs font-semibold uppercase tracking-wide text-emerald-300">Panel Admin</p>
                <h1 class="mt-2 text-lg font-extrabold leading-tight">Bumi Perkemahan Pleseran</h1>
            </div>

            <nav class="px-3 py-6">
                <div class="space-y-6">
                    <div>
                        <p class="px-3 text-xs font-bold uppercase tracking-[0.28em] text-white/35">Admin</p>
                        <div class="mt-3 space-y-1">
                            <a href="{{ route('admin.dashboard') }}"
                               class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold transition {{ request()->routeIs('admin.dashboard') ? 'bg-white text-slate-950' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                                <span class="h-2.5 w-2.5 rounded-full bg-sky-400"></span>
                                Dashboard
                            </a>
                            <a href="{{ route('admin.transaksi') }}"
                               class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold transition {{ request()->routeIs('admin.transaksi') ? 'bg-white text-slate-950' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                                <span class="h-2.5 w-2.5 rounded-full bg-sky-400"></span>
                                Cek Transaksi
                            </a>
                        </div>
                    </div>

                    <div>
                        <p class="px-3 text-xs font-bold uppercase tracking-[0.28em] text-white/35">Konten</p>
                        <div class="mt-3 space-y-1">
                            <a href="{{ route('admin.galeri') }}"
                               class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold transition {{ request()->routeIs('admin.galeri') ? 'bg-white text-slate-950' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                                <span class="h-2.5 w-2.5 rounded-full bg-sky-400"></span>
                                Galeri
                            </a>
                            <a href="{{ route('admin.tiket') }}"
                               class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold transition {{ request()->routeIs('admin.tiket') ? 'bg-white text-slate-950' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                                <span class="h-2.5 w-2.5 rounded-full bg-sky-400"></span>
                                Tiket Wisata
                            </a>
                        </div>
                    </div>

                    <div>
                        <p class="px-3 text-xs font-bold uppercase tracking-[0.28em] text-white/35">Pengguna</p>
                        <div class="mt-3 space-y-1">
                            <a href="{{ route('admin.admins') }}"
                               class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold transition {{ request()->routeIs('admin.admins') ? 'bg-white text-slate-950' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                                <span class="h-2.5 w-2.5 rounded-full bg-sky-400"></span>
                                Data Admin
                            </a>
                            <a href="{{ route('admin.members') }}"
                               class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold transition {{ request()->routeIs('admin.members') ? 'bg-white text-slate-950' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                                <span class="h-2.5 w-2.5 rounded-full bg-sky-400"></span>
                                Data Member
                            </a>
                        </div>
                    </div>

                    <div>
                        <p class="px-3 text-xs font-bold uppercase tracking-[0.28em] text-white/35">Sesi</p>
                        <div class="mt-3 space-y-1">
                            <a href="{{ route('landing') }}"
                               class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold text-white/70 transition hover:bg-white/10 hover:text-white">
                                <span class="h-2.5 w-2.5 rounded-full bg-sky-300"></span>
                                Lihat Website
                            </a>
                        </div>
                    </div>
                </div>
            </nav>

            <div class="hidden px-5 py-5 lg:block">
                <div class="rounded-lg border border-white/10 bg-white/5 p-4">
                    <p class="text-sm font-semibold">{{ auth()->user()->name }}</p>
                    <p class="mt-1 truncate text-xs text-white/60">{{ auth()->user()->email }}</p>
                    <form action="{{ route('logout') }}" method="POST" class="mt-4">
                        @csrf
                        <button class="text-sm font-semibold text-red-200 hover:text-red-100">
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <main>
            <header class="border-b border-slate-200 bg-white px-5 py-6 sm:px-8">
                <p class="text-sm font-medium text-slate-500">@yield('eyebrow', 'Admin')</p>
                <div class="mt-1 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <h2 class="text-2xl font-bold tracking-tight text-slate-950">@yield('page_title')</h2>
                    @yield('header_action')
                </div>
            </header>

            <section class="px-5 py-8 sm:px-8">
                @yield('content')
            </section>
        </main>
    </div>
</body>
</html>
