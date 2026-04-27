<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register - Bumi Pleseran</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>

<div class="relative h-screen">

    <!-- BACKGROUND -->
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

        <!-- CARD -->
        <div class="bg-white p-10 rounded shadow-lg w-[400px]">

            <h1 class="text-2xl font-semibold mb-8 text-gray-700">
                Register
            </h1>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- NAMA -->
                <div class="mb-4">
                    <label class="text-gray-600 text-sm">Nama</label>
                    <input type="text" name="name" required
                        class="w-full p-3 bg-gray-200 rounded mt-1 outline-none">
                </div>

                <!-- EMAIL -->
                <div class="mb-4">
                    <label class="text-gray-600 text-sm">Email</label>
                    <input type="email" name="email" required
                        class="w-full p-3 bg-gray-200 rounded mt-1 outline-none">
                </div>

                <!-- PASSWORD -->
                <div class="mb-4">
                    <label class="text-gray-600 text-sm">Password</label>
                    <input type="password" name="password" required
                        class="w-full p-3 bg-gray-200 rounded mt-1 outline-none">
                </div>

                <!-- KONFIRMASI -->
                <div class="mb-6">
                    <label class="text-gray-600 text-sm">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required
                        class="w-full p-3 bg-gray-200 rounded mt-1 outline-none">
                </div>

                <!-- BUTTON -->
                <button class="w-full bg-[#1e1b2e] text-white py-3 rounded hover:bg-black mb-4">
                    Register
                </button>

                <!-- LOGIN LINK -->
                <p class="text-sm text-gray-600 text-center">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-blue-500 hover:underline">
                        Login
                    </a>
                </p>

            </form>
        </div>

        <!-- TEXT KANAN -->
        <div class="ml-20 text-white max-w-lg">
            <h1 class="text-4xl font-bold mb-2">
                Bumi Perkemahan Pleseran
            </h1>
            <p class="text-lg">
                Daftar dan nikmati liburanmu....
            </p>
        </div>

    </div>

</div>

</body>
</html>