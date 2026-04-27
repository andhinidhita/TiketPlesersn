<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Bumi Perkemahan Pleseran</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<!-- NAVBAR -->
<nav class="bg-[#1e1b2e] text-white px-10 py-4 flex justify-between items-center">
    <h1 class="text-xl font-bold tracking-wide">
        BUMI PERKEMAHAN PLESERAN
    </h1>

    <ul class="flex gap-6 text-sm items-center">
        <li><a href="/dashboard" class="hover:text-gray-300">Home</a></li>
        <li><a href="/pemesanan" class="hover:text-gray-300">Pesan Sekarang</a></li>
        <li><a href="#" class="hover:text-gray-300">Galeri</a></li>

        <!-- ✅ LOGOUT FIX -->
        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" 
                    class="hover:text-red-400 bg-transparent border-none cursor-pointer">
                    Log Out
                </button>
            </form>
        </li>
    </ul>
</nav>

<!-- HERO SECTION -->
<div class="relative h-screen">
    
    <!-- BACKGROUND IMAGE -->
    <img src="{{ asset('images/bg.png') }}"
         class="absolute w-full h-full object-cover">

    <!-- OVERLAY -->
    <div class="absolute w-full h-full bg-black/50"></div>


</div>

</body>
</html>