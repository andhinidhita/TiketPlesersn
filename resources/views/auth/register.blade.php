<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register - Bumi Perkemahan Pleseran</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 font-sans text-slate-900 antialiased">
    <main class="min-h-screen lg:grid lg:grid-cols-[0.95fr_1.05fr]">
        <section class="flex min-h-screen items-center justify-center px-5 py-10 sm:px-8">
            <div class="w-full max-w-md">
                <div class="mb-8 flex items-center justify-between">
                    <a href="{{ route('landing') }}" class="font-bold text-slate-950">Bumi Perkemahan Pleseran</a>
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-950">Login</a>
                </div>

                <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-wide text-emerald-700">Akun baru</p>
                        <h2 class="mt-2 text-3xl font-bold tracking-tight text-slate-950">Daftar</h2>
                        <p class="mt-2 text-sm text-slate-500">Buat akun untuk mulai memesan tiket secara online.</p>
                    </div>

                    @if ($errors->any())
                        <div class="mt-6 rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}" class="mt-8 space-y-5">
                        @csrf

                        <div>
                            <label for="name" class="block text-sm font-semibold text-slate-700">Nama Lengkap</label>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" autocomplete="name"
                                   class="mt-2 w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-emerald-600 focus:ring-emerald-600" required autofocus>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-semibold text-slate-700">Email</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="username"
                                   class="mt-2 w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-emerald-600 focus:ring-emerald-600" required>
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-semibold text-slate-700">Password</label>
                            <input id="password" type="password" name="password" autocomplete="new-password"
                                   class="mt-2 w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-emerald-600 focus:ring-emerald-600" required>
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-semibold text-slate-700">Konfirmasi Password</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password"
                                   class="mt-2 w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-emerald-600 focus:ring-emerald-600" required>
                        </div>

                        <button class="w-full rounded-md bg-emerald-700 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-emerald-800">
                            Buat Akun
                        </button>
                    </form>

                    <p class="mt-6 text-center text-sm text-slate-500">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="font-semibold text-emerald-700 hover:text-emerald-800">Masuk</a>
                    </p>
                </div>
            </div>
        </section>

        <section class="relative hidden overflow-hidden lg:block">
            <img src="{{ asset('images/g5.png') }}" alt="Area camping Pleseran" class="absolute inset-0 h-full w-full object-cover">
            <div class="absolute inset-0 bg-slate-950/45"></div>
            <div class="relative z-10 flex min-h-screen items-end p-10 text-white">
                <div class="max-w-xl">
                    <p class="text-sm font-semibold uppercase tracking-wide text-emerald-200">Mulai dari sini</p>
                    <h1 class="mt-4 text-5xl font-extrabold tracking-tight">Akunmu untuk semua pemesanan Pleseran.</h1>
                    <p class="mt-5 text-base leading-7 text-white/80">
                        Setelah daftar, kamu bisa langsung masuk dashboard, membuat pesanan, dan menyimpan riwayat invoice.
                    </p>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
