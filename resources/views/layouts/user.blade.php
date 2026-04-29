<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Bumi Perkemahan Pleseran')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 font-sans text-slate-900 antialiased">
    <div class="min-h-screen">
        <nav class="sticky top-0 z-40 border-b border-slate-200 bg-white/95 backdrop-blur">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-5 py-4 sm:px-8">
                <a href="{{ route('dashboard') }}" class="leading-tight">
                    <p class="text-xs font-semibold uppercase tracking-wide text-emerald-700">Tiket Wisata</p>
                    <p class="text-base font-extrabold text-slate-950">Bumi Perkemahan Pleseran</p>
                </a>

                <div class="hidden items-center gap-2 md:flex">
                    <a href="{{ route('dashboard') }}"
                       class="rounded-md px-3 py-2 text-sm font-semibold transition {{ request()->routeIs('dashboard') ? 'bg-slate-950 text-white' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-950' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('pemesanan') }}"
                       class="rounded-md px-3 py-2 text-sm font-semibold transition {{ request()->routeIs('pemesanan') ? 'bg-slate-950 text-white' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-950' }}">
                        Pesan Tiket
                    </a>
                    <a href="{{ route('riwayat') }}"
                       class="rounded-md px-3 py-2 text-sm font-semibold transition {{ request()->routeIs('riwayat') ? 'bg-slate-950 text-white' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-950' }}">
                        Riwayat
                    </a>
                </div>

                <div class="flex items-center gap-3">
                    <div class="hidden text-right sm:block">
                        <p class="text-sm font-semibold text-slate-950">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-slate-500">{{ auth()->user()->email }}</p>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="rounded-md border border-slate-200 px-3 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100 hover:text-slate-950">
                            Keluar
                        </button>
                    </form>
                </div>
            </div>

            <div class="mx-auto flex max-w-7xl gap-2 overflow-x-auto px-5 pb-4 md:hidden">
                <a href="{{ route('dashboard') }}"
                   class="whitespace-nowrap rounded-md px-3 py-2 text-sm font-semibold {{ request()->routeIs('dashboard') ? 'bg-slate-950 text-white' : 'bg-white text-slate-600' }}">
                    Dashboard
                </a>
                <a href="{{ route('pemesanan') }}"
                   class="whitespace-nowrap rounded-md px-3 py-2 text-sm font-semibold {{ request()->routeIs('pemesanan') ? 'bg-slate-950 text-white' : 'bg-white text-slate-600' }}">
                    Pesan Tiket
                </a>
                <a href="{{ route('riwayat') }}"
                   class="whitespace-nowrap rounded-md px-3 py-2 text-sm font-semibold {{ request()->routeIs('riwayat') ? 'bg-slate-950 text-white' : 'bg-white text-slate-600' }}">
                    Riwayat
                </a>
            </div>
        </nav>

        @hasSection('page_title')
            <header class="border-b border-slate-200 bg-white">
                <div class="mx-auto max-w-7xl px-5 py-6 sm:px-8">
                    <p class="text-sm font-medium text-slate-500">@yield('eyebrow', 'Area Pengunjung')</p>
                    <div class="mt-1 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <h1 class="text-2xl font-bold tracking-tight text-slate-950">@yield('page_title')</h1>
                        @yield('header_action')
                    </div>
                </div>
            </header>
        @endif

        <main class="mx-auto max-w-7xl px-5 py-8 sm:px-8">
            @yield('content')
        </main>
    </div>
</body>
</html>
