<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Bumi Pleseran</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>

<!-- BACKGROUND FULL -->
<div class="relative h-screen">

    <!-- IMAGE -->
    <img src="{{ asset('images/bg.png') }}"
         class="absolute w-full h-full object-cover">

    <!-- OVERLAY -->
    <div class="absolute w-full h-full bg-black/40"></div>

    <!-- NAVBAR -->
    <div class="absolute top-0 w-full bg-[#1e1b2e] text-white px-10 py-4">
        <h1 class="text-xl font-bold">BUMI PERKEMAHAN PLESERAN</h1>
    </div>

    <!-- CONTENT -->
    <div class="relative z-10 flex items-center h-full px-20">

        <!-- LOGIN CARD -->
        <div class="bg-white p-10 rounded shadow-lg w-[400px]">

            <h1 class="text-2xl font-semibold mb-8 text-gray-700">
                Login
            </h1>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- EMAIL -->
                <div class="mb-5">
                    <label class="text-gray-600 text-sm">Username</label>
                    <input type="email" name="email" required
                        class="w-full p-3 bg-gray-200 rounded mt-1 outline-none">
                </div>

                <!-- PASSWORD -->
                <div class="mb-6">
                    <label class="text-gray-600 text-sm">Password</label>
                    <input type="password" name="password" required
                        class="w-full p-3 bg-gray-200 rounded mt-1 outline-none">
                </div>

                <!-- LOGIN BUTTON -->
                <button class="w-full bg-[#1e1b2e] text-white py-3 rounded mb-4 hover:bg-black">
                    Log in
                </button>

                <!-- TEXT -->
                <p class="text-red-500 text-sm mb-4">
                    Belum punya akun daftar sekarang!
                </p>

                <!-- REGISTER -->
                <a href="{{ route('register') }}">
                    <button type="button"
                        class="w-full bg-[#1e1b2e] text-white py-3 rounded hover:bg-black">
                        Register
                    </button>
                </a>

            </form>
        </div>

        <!-- TEXT KANAN -->
        <div class="ml-20 text-white max-w-lg">
            <h1 class="text-4xl font-bold mb-2">
                Bumi Perkemahan Pleseran
            </h1>
            <p class="text-lg">
                Silahkan Login untuk liburan terbaik anda...
            </p>
        </div>

    </div>

</div>

</body>
</html>