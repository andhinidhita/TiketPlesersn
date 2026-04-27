<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<div class="flex h-screen">

    <!-- SIDEBAR -->
    <div class="w-64 bg-gray-100 border-r flex flex-col justify-between">

        <!-- TOP SIDEBAR -->
        <div>
            <div class="bg-[#1e1b2e] text-white p-6 font-bold text-lg">
                Bumi Perkemahan Pleseran
            </div>

            <div class="p-4 space-y-3">

                <!-- DASHBOARD -->
                <a href="/dashboard"
                   class="flex items-center gap-3 bg-black text-white px-4 py-2 rounded-lg">
                    🏠 Dashboard
                </a>

                <!-- PESAN -->
                <a href="/pemesanan"
                   class="flex items-center gap-3 px-4 py-2 hover:bg-gray-200 rounded-lg">
                    🎫 Pesan Tiket
                </a>

                <!-- RIWAYAT -->
                <a href="/riwayat"
                   class="flex items-center gap-3 px-4 py-2 hover:bg-gray-200 rounded-lg">
                    📂 Riwayat Pesanan
                </a>

            </div>
        </div>

        <!-- LOGOUT -->
        <div class="p-4">
            <form action="/logout" method="POST">
                @csrf
                <button class="flex items-center gap-2 text-gray-700 hover:text-red-500">
                    🔙 Log Out
                </button>
            </form>
        </div>

    </div>


    <!-- MAIN CONTENT -->
    <div class="flex-1 flex flex-col">

        <!-- TOPBAR -->
        <div class="bg-[#1e1b2e] text-white flex justify-end items-center px-6 py-4">
            <span class="mr-3">Hallo, {{ auth()->user()->name }}</span>
            <div class="w-8 h-8 bg-gray-300 rounded-full"></div>
        </div>

        <!-- CONTENT -->
        <div class="p-10">

            <h2 class="text-2xl font-bold mb-6">Dashboard</h2>

            <!-- CARD -->
            <div class="grid md:grid-cols-3 gap-6">

                <div class="bg-white p-6 rounded-xl shadow">
                    <p class="text-gray-500">Pesanan Saya</p>
                    <h1 class="text-3xl font-bold">
                        {{ \App\Models\Pemesanan::where('user_id', auth()->id())->count() }}
                    </h1>
                </div>

                <div class="bg-white p-6 rounded-xl shadow">
                    <p class="text-gray-500">Tiket Saya</p>
                    <h1 class="text-3xl font-bold">
                        {{ \App\Models\Pemesanan::where('user_id', auth()->id())->sum('jumlah_tiket') }}
                    </h1>
                </div>

                <div class="bg-white p-6 rounded-xl shadow">
                    <p class="text-gray-500">Status Terakhir</p>
                    <h1 class="text-lg font-semibold text-green-600">
                        {{ optional(\App\Models\Pemesanan::where('user_id', auth()->id())->latest()->first())->status ?? '-' }}
                    </h1>
                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>