<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pemesanan Tiket</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<div class="flex h-screen">

    <!-- SIDEBAR -->
    <div class="w-64 bg-gray-100 border-r flex flex-col justify-between">

        <div>
            <div class="bg-[#1e1b2e] text-white p-6 font-bold text-lg">
                Bumi Perkemahan Pleseran
            </div>

            <div class="p-4 space-y-3">

                <a href="/dashboard"
                   class="flex items-center gap-3 px-4 py-2 hover:bg-gray-200 rounded-lg">
                    🏠 Dashboard
                </a>

                <a href="/pemesanan"
                   class="flex items-center gap-3 bg-black text-white px-4 py-2 rounded-lg">
                    🎫 Pesan Tiket
                </a>

                <a href="/riwayat"
                   class="flex items-center gap-3 px-4 py-2 hover:bg-gray-200 rounded-lg">
                    📂 Riwayat Pesanan
                </a>

            </div>
        </div>


    </div>


    <!-- MAIN -->
    <div class="flex-1 flex flex-col">

        <!-- TOPBAR -->
        <div class="bg-[#1e1b2e] text-white flex justify-end items-center px-6 py-4">
            <span class="mr-3">Hallo, {{ auth()->user()->name }}</span>
            <div class="w-8 h-8 bg-gray-300 rounded-full"></div>
        </div>


        <!-- CONTENT -->
        <div class="p-10 flex justify-center">

            <div class="bg-white p-8 rounded-xl shadow w-full max-w-2xl">

                <h2 class="text-xl font-bold mb-6">Pemesanan Tiket</h2>

                @if(session('success'))
                    <div class="bg-green-500 text-white p-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="/pemesanan" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- PILIH TIKET -->
                    <div class="mb-4">
                        <label class="block mb-1">Pilih Tiket</label>
                        <select name="tiket_id" class="w-full border rounded-lg p-3">
                            @foreach($tikets as $tiket)
                                <option value="{{ $tiket->id }}">
                                    {{ $tiket->nama_tiket }} - Rp {{ number_format($tiket->harga,0,',','.') }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- JUMLAH -->
                    <div class="mb-4">
                        <label class="block mb-1">Jumlah Tiket</label>
                        <input type="number" name="jumlah_tiket" min="1"
                               class="w-full border rounded-lg p-3" required>
                    </div>

                    <!-- TANGGAL -->
                    <div class="mb-4">
                        <label class="block mb-1">Tanggal</label>
                        <input type="date" name="tanggal"
                               class="w-full border rounded-lg p-3" required>
                    </div>

                    <!-- UPLOAD -->
                    <div class="mb-4">
                        <label class="block mb-1">Upload Bukti Pembayaran</label>
                        <input type="file" name="bukti_pembayaran"
                               class="w-full border rounded-lg p-3">
                    </div>

                    <!-- INFO -->
                    <p class="text-sm mb-4">
                        UNTUK PAYMENT TRANSFER KE REKENING BRI 6718-0105-2339-535
                    </p>

                    <!-- BUTTON -->
                    <button class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700">
                        Pesan Sekarang
                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

</body>
</html>