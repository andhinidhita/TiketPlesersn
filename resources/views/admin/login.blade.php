<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login Admin - Bumi Perkemahan Pleseran</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#243d4d] font-sans text-slate-900 antialiased">
    <main class="flex min-h-screen items-center justify-center px-5 py-10">
        <section class="w-full max-w-[560px] rounded-2xl border border-white/30 bg-white px-8 py-9 shadow-2xl shadow-slate-950/25 sm:px-10">
            <div class="text-center">
                <p class="text-xs font-extrabold uppercase tracking-[0.28em] text-sky-700">Admin Area</p>
                <h1 class="mt-3 text-4xl font-extrabold tracking-tight text-[#252433]">Login</h1>
                <p class="mt-2 text-sm font-medium text-slate-500">Masuk untuk mengelola transaksi dan data wisata.</p>
            </div>

            @if ($errors->any())
                <div class="mt-7 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.store') }}" class="mt-8 space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-extrabold uppercase tracking-wide text-slate-600">Email Admin</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="test@example.com" autocomplete="username"
                           class="mt-2 h-12 w-full rounded-xl border border-slate-200 bg-[#e8eefc] px-4 text-base font-semibold text-[#252433] shadow-sm outline-none transition placeholder:text-slate-400 focus:border-sky-500 focus:bg-white focus:ring-4 focus:ring-sky-100" required autofocus>
                </div>

                <div>
                    <label for="password" class="block text-sm font-extrabold uppercase tracking-wide text-slate-600">Password</label>
                    <input id="password" type="password" name="password" placeholder="Masukkan password" autocomplete="current-password"
                           class="mt-2 h-12 w-full rounded-xl border border-slate-200 bg-[#e8eefc] px-4 text-base font-semibold text-[#252433] shadow-sm outline-none transition placeholder:text-slate-400 focus:border-sky-500 focus:bg-white focus:ring-4 focus:ring-sky-100" required>
                </div>

                <button class="mt-2 h-12 w-full rounded-xl bg-[#252133] text-base font-extrabold text-white shadow-lg shadow-slate-950/20 transition hover:bg-[#171321]">
                    Log in
                </button>
            </form>

            <div class="mt-7 flex items-center justify-between text-sm">
                <a href="{{ route('landing') }}" class="font-semibold text-slate-500 hover:text-slate-900">Kembali ke website</a>
                <span class="font-semibold text-slate-400">Khusus admin</span>
            </div>
        </section>
    </main>
</body>
</html>
