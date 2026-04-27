<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pemesanan Tiket</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>

<div class="relative min-h-screen">

    <!-- BACKGROUND -->
    <img src="{{ asset('images/bg.png') }}"
         class="absolute w-full h-full object-cover">

    <!-- OVERLAY -->
    <div class="absolute w-full h-full bg-black/50"></div>

    <!-- NAVBAR -->
    <div class="absolute top-0 w-full bg-[#1e1b2e] text-white px-10 py-4 z-20">
        <h1 class="text-xl font-bold">BUMI PERKEMAHAN PLESERAN</h1>
    </div>

    <!-- CONTENT -->
<div class="relative z-10 flex justify-center items-center min-h-screen px-5 pt-24">

        <div class="bg-white w-full max-w-2xl p-8 rounded-2xl shadow-xl">

            <h2 class="text-2xl font-semibold mb-6">
                Pemesanan Tiket
            </h2>

            <!-- NOTIF -->
            @if(session('success'))
                <div class="bg-green-500 text-white p-3 mb-4 rounded">
                    ✅ {{ session('success') }}
                </div>
            @endif

            <!-- ERROR -->
            @if ($errors->any())
                <div class="bg-red-100 text-red-600 p-3 mb-4 rounded">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="/pemesanan" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- PILIH TIKET -->
                <div class="mb-4">
                    <label class="block mb-1 font-medium">Pilih Tiket</label>
                    <select name="tiket_id"
                        class="w-full border rounded p-3">

                        <option value="1">Tiket Camping - Rp 15.000</option>
                        <option value="2">Tiket Masuk - Rp 10.000</option>

                    </select>
                </div>

                <!-- JUMLAH -->
                <div class="mb-4">
                    <label class="block mb-1 font-medium">Jumlah Tiket</label>
                    <input type="number" name="jumlah_tiket"
                        min="1" value="1"
                        class="w-full border rounded p-3" required>
                </div>

                <!-- TANGGAL -->
                <div class="mb-4">
                    <label class="block mb-1 font-medium">Tanggal</label>
                    <input type="date" name="tanggal"
                        class="w-full border rounded p-3" required>
                </div>

                <!-- BUKTI -->
                <div class="mb-4">
                    <label class="block mb-1 font-medium">Upload Bukti Pembayaran</label>
                    <input type="file" name="bukti_pembayaran"
                        class="w-full border rounded p-3">
                </div>

                <!-- INFO -->
                <p class="mb-4 text-sm text-gray-600">
                    Untuk Payment Transfer ke BRI: <b>6718-0105-2339-535</b>
                </p>

                <!-- BUTTON -->
                <button class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition">
                    Pesan Sekarang
                </button>

            </form>

        </div>

    </div>

</div>

</body>
</html>