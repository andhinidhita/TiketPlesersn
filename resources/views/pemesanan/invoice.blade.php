<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice</title>

    <!-- WAJIB ADA INI -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<div class="flex justify-center items-center min-h-screen p-5">

    <div class="bg-white w-full max-w-2xl p-8 rounded-2xl shadow-lg">

        <!-- HEADER -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold">🧾 INVOICE</h1>
                <p class="text-sm text-gray-500">
                    #INV-{{ $pemesanan->id }}
                </p>
            </div>

            <div class="text-right">
                <h2 class="font-semibold">
                    Bumi Perkemahan Pleseran
                </h2>
                <p class="text-sm text-gray-500">
                    Tawangmangu
                </p>
            </div>
        </div>

        <hr class="mb-6">

        <!-- INFO -->
        <div class="flex justify-between mb-6">
            <div>
                <p class="text-gray-500 text-sm">Nama</p>
                <p class="font-semibold">
                    {{ $pemesanan->user->name }}
                </p>
            </div>

            <div class="text-right">
                <p class="text-gray-500 text-sm">Tanggal</p>
                <p class="font-semibold">
                    {{ \Carbon\Carbon::parse($pemesanan->created_at)->format('d M Y') }}
                </p>
            </div>
        </div>

        <!-- TABLE -->
        <table class="w-full border rounded-lg overflow-hidden">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-left">Tiket</th>
                    <th class="p-3 text-center">Jumlah</th>
                    <th class="p-3 text-center">Harga</th>
                    <th class="p-3 text-center">Total</th>
                </tr>
            </thead>

            <tbody>
                <tr class="border-t">
                    <td class="p-3 font-semibold">
                        🎫 {{ $pemesanan->tiket->nama_tiket }}
                    </td>
                    <td class="p-3 text-center">
                        {{ $pemesanan->jumlah_tiket }}
                    </td>
                    <td class="p-3 text-center">
                        Rp {{ number_format($pemesanan->tiket->harga) }}
                    </td>
                    <td class="p-3 text-center font-bold">
                        Rp {{ number_format($pemesanan->total_harga) }}
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- STATUS -->
        <div class="mt-6">
            <p class="text-gray-500 text-sm mb-1">Status</p>

            <span class="px-3 py-1 rounded-full text-white text-sm
                {{ $pemesanan->status == 'lunas' ? 'bg-green-500' : 'bg-yellow-500' }}">
                
                {{ ucfirst($pemesanan->status) }}
            </span>
        </div>

        <!-- FOOTER -->
        <div class="mt-8 text-center text-sm text-gray-500">
            Terima kasih telah melakukan pemesanan 🙏
        </div>

        <!-- PRINT BUTTON -->
        <div class="mt-6 text-center">
            <button onclick="window.print()"
                class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                🖨 Print
            </button>
        </div>

    </div>

</div>

</body>
</html>