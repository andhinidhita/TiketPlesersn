<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Bumi Perkemahan Pleseran</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 font-sans text-slate-900 antialiased">
    <main class="min-h-screen lg:grid lg:grid-cols-[1.05fr_0.95fr]">
        <section class="relative hidden overflow-hidden lg:block">
            <img src="{{ asset('images/bg.png') }}" alt="Bumi Perkemahan Pleseran" class="absolute inset-0 h-full w-full object-cover">
            <div class="absolute inset-0 bg-slate-950/50"></div>
            <div class="relative z-10 flex min-h-screen flex-col justify-between p-10 text-white">
                <a href="{{ route('landing') }}" class="text-lg font-bold tracking-tight">Bumi Perkemahan Pleseran</a>
                <div class="max-w-xl">
                    <p class="text-sm font-semibold uppercase tracking-wide text-emerald-200">Reservasi Online</p>
                    <h1 class="mt-4 text-5xl font-extrabold tracking-tight">Masuk dan lanjutkan pemesanan tiketmu.</h1>
                    <p class="mt-5 text-base leading-7 text-white/80">
                        Kelola pesanan, lihat invoice, dan pantau status verifikasi pembayaran dari dashboard pengunjung.
                    </p>
                </div>
            </div>
        </section>

        <section class="flex min-h-screen items-center justify-center px-5 py-10 sm:px-8">
            <div class="w-full max-w-md">
                <div class="mb-8 flex items-center justify-between lg:hidden">
                    <a href="{{ route('landing') }}" class="font-bold text-slate-950">Bumi Perkemahan Pleseran</a>
                    <a href="{{ route('landing') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-950">Beranda</a>
                </div>

                <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-wide text-emerald-700">Selamat datang</p>
                        <h2 class="mt-2 text-3xl font-bold tracking-tight text-slate-950">Login</h2>
                        <p class="mt-2 text-sm text-slate-500">Masuk untuk membuka dashboard dan membuat pesanan.</p>
                    </div>

                    @if (session('status'))
                        <div class="mt-6 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mt-6 rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-5">
                        @csrf

                        <div>
                            <label for="email" class="block text-sm font-semibold text-slate-700">Email</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="username"
                                   class="mt-2 w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-emerald-600 focus:ring-emerald-600" required autofocus>
                        </div>

                        <div>
                            <div class="flex items-center justify-between">
                                <label for="password" class="block text-sm font-semibold text-slate-700">Password</label>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-xs font-semibold text-emerald-700 hover:text-emerald-800">
                                        Lupa password?
                                    </a>
                                @endif
                            </div>
                            <input id="password" type="password" name="password" autocomplete="current-password"
                                   class="mt-2 w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-emerald-600 focus:ring-emerald-600" required>
                        </div>

                        <label class="flex items-center gap-2 text-sm text-slate-600">
                            <input type="checkbox" name="remember" class="rounded border-slate-300 text-emerald-700 shadow-sm focus:ring-emerald-600">
                            Ingat saya
                        </label>

                        <button class="w-full rounded-md bg-emerald-700 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-emerald-800">
                            Masuk
                        </button>
                    </form>

                    <p class="mt-6 text-center text-sm text-slate-500">
                        Belum punya akun?
                        <a href="{{ route('register') }}" class="font-semibold text-emerald-700 hover:text-emerald-800">Daftar sekarang</a>
                    </p>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
