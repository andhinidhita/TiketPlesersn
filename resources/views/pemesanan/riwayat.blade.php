<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Pesanan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<!-- NAVBAR -->
<nav class="bg-[#1e1b2e] text-white px-10 py-4 flex justify-between">
    <h1 class="text-lg font-bold">BUMI PERKEMAHAN PLESERAN</h1>
    <a href="/dashboard" class="hover:underline">Dashboard</a>
</nav>

<div class="max-w-4xl mx-auto mt-10">

    <!-- NOTIF -->
    @if(session('success'))
        <div class="bg-green-500 text-white p-3 mb-6 rounded shadow">
            ✅ {{ session('success') }}
        </div>
    @endif

    <!-- HEADER -->
    <h2 class="text-2xl font-bold mb-2">
        Riwayat Pesanan Saya
    </h2>

    <p class="text-gray-600 mb-6">
        Lihat status dan detail pemesanan tiket kamu di sini
    </p>

    <!-- LIST PESANAN -->
    @forelse($pemesanans as $p)
        <div class="bg-white p-5 rounded-xl shadow mb-5 hover:shadow-lg transition">

            <!-- NAMA TIKET -->
            <h3 class="text-lg font-semibold mb-2">
                {{ $p->tiket->nama ?? 'Tiket' }}
            </h3>

            <!-- DETAIL -->
            <p class="text-sm text-gray-700">Jumlah: {{ $p->jumlah_tiket }}</p>
            <p class="text-sm text-gray-700">
                Total: Rp {{ number_format($p->total_harga) }}
            </p>

            <!-- STATUS -->
            <div class="mt-2">
                Status:
                @if($p->status == 'pending')
                    <span class="text-yellow-500 font-semibold">Pending</span>
                @elseif($p->status == 'lunas')
                    <span class="text-green-600 font-semibold">Lunas</span>
                @else
                    <span class="text-red-600 font-semibold">Ditolak</span>
                @endif
            </div>

            <!-- AKSI -->
            <div class="mt-3">

                @if($p->status == 'lunas')
                    <a href="{{ asset('bukti/'.$p->bukti_pembayaran) }}"
                       target="_blank"
                       class="text-blue-500 hover:underline text-sm">
                        Lihat Bukti Pembayaran
                    </a>
                @elseif($p->status == 'pending')
                    <p class="text-sm text-gray-500 italic">
                        Menunggu verifikasi admin
                    </p>
                @else
                    <p class="text-sm text-red-500">
                        Pembayaran ditolak, silakan upload ulang
                    </p>
                @endif

            </div>

        </div>
    @empty
        <div class="bg-white p-5 rounded shadow text-center text-gray-500">
            Belum ada pesanan
        </div>
    @endforelse

</div>

</body>
</html>