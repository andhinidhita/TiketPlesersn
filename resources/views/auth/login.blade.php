<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-200">

<!-- NAVBAR -->
<div class="bg-[#1e1b2e] text-white px-10 py-5 font-bold text-lg">
    BUMI PERKEMAHAN PLESERAN
</div>

<!-- LOGIN CARD -->
<div class="flex justify-center items-center h-[85vh]">

    <div class="bg-white w-[500px] p-10 rounded-lg shadow-lg border">

        <h2 class="text-center text-2xl mb-10">Login</h2>

        <!-- FORM -->
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="flex gap-6 mb-8">

                <!-- EMAIL -->
                <div class="w-1/2">
                    <label class="block mb-2">Username</label>
                    <input type="email" name="email"
                        class="w-full bg-gray-300 p-2 rounded outline-none"
                        required>
                </div>

                <!-- PASSWORD -->
                <div class="w-1/2">
                    <label class="block mb-2">Password</label>
                    <input type="password" name="password"
                        class="w-full bg-gray-300 p-2 rounded outline-none"
                        required>
                </div>

            </div>

            <!-- BUTTON LOGIN -->
            <button class="w-full bg-[#1e1b2e] text-white py-2 rounded mb-4 hover:opacity-90">
                Log in
            </button>

        </form>

        <!-- REGISTER -->
        <p class="text-center text-red-500 mb-3">
            Belum punya akun daftar sekarang!
        </p>

        <a href="{{ route('register') }}">
            <button class="w-full bg-[#1e1b2e] text-white py-2 rounded hover:opacity-90">
                Register
            </button>
        </a>

    </div>

</div>

</body>
</html>