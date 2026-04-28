<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-200">

<!-- NAVBAR -->
<div class="bg-[#1e1b2e] text-white px-10 py-5 font-bold text-lg">
    BUMI PERKEMAHAN PLESERAN
</div>

<!-- REGISTER CARD -->
<div class="flex justify-center items-center h-[85vh]">

    <div class="bg-white w-[500px] p-10 rounded-lg shadow-lg border">

        <h2 class="text-2xl mb-8">Register</h2>

        <!-- FORM -->
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- NAMA -->
            <div class="mb-5">
                <label class="block mb-2">Nama</label>
                <input type="text" name="name"
                    class="w-full bg-gray-200 p-3 rounded outline-none"
                    required>
            </div>

            <!-- EMAIL -->
            <div class="mb-5">
                <label class="block mb-2">Email</label>
                <input type="email" name="email"
                    class="w-full bg-gray-300 p-3 rounded outline-none"
                    required>
            </div>

            <!-- PASSWORD -->
            <div class="mb-5">
                <label class="block mb-2">Password</label>
                <input type="password" name="password"
                    class="w-full bg-gray-300 p-3 rounded outline-none"
                    required>
            </div>

            <!-- KONFIRMASI PASSWORD -->
            <div class="mb-6">
                <label class="block mb-2">Konfirmasi Password</label>
                <input type="password" name="password_confirmation"
                    class="w-full bg-gray-200 p-3 rounded outline-none"
                    required>
            </div>

            <!-- BUTTON -->
            <button class="w-full bg-[#1e1b2e] text-white py-3 rounded hover:opacity-90">
                Register
            </button>

        </form>

        <!-- LOGIN LINK -->
        <p class="text-center mt-4 text-sm">
            Sudah Punya akun?
            <a href="{{ route('login') }}" class="text-blue-600 hover:underline">
                Login
            </a>
        </p>

    </div>

</div>

</body>
</html>