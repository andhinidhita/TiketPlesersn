<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Pesanan</title>
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

                <a href="/dashboard" class="flex gap-3 px-4 py-2 hover:bg-gray-200 rounded">
                    🏠 Dashboard
                </a>

                <a href="/pemesanan" class="flex gap-3 px-4 py-2 hover:bg-gray-200 rounded">
                    🎫 Pesan Tiket
                </a>

                <a href="/riwayat" class="flex gap-3 px-4 py-2 bg-black text-white rounded">
                    📂 Riwayat Pesanan
                </a>

            </div>
        </div>

        <div class="p-4">
            <form action="/logout" method="POST">
                @csrf
                <button class="text-gray-700 hover:text-red-500">🔙 LogOut</button>
            </form>
        </div>

    </div>

    <!-- MAIN -->
    <div class="flex-1 flex flex-col">

        <!-- TOPBAR -->
        <div class="bg-[#1e1b2e] text-white flex justify-end items-center px-6 py-4">
            Hallo, {{ auth()->user()->name }}
        </div>

        <!-- CONTENT -->
        <div class="p-10 flex justify-center">

            <div class="bg-white p-8 rounded-xl shadow w-full max-w-5xl">

                <h2 class="text-xl font-bold mb-6">Riwayat Pemesanan</h2>

                <div class="border rounded-lg overflow-hidden">

                    <!-- HEADER -->
                    <div class="grid grid-cols-6 bg-gray-200 p-4 font-semibold text-sm">
                        <div>Tanggal Booking</div>
                        <div>Tiket</div>
                        <div>Harga</div>
                        <div>Jumlah</div>
                        <div>Total</div>
                        <div>Status</div>
                    </div>

                    <!-- DATA -->
                    @forelse($pemesanans as $pemesanan)
                    <div class="grid grid-cols-6 p-4 border-t text-sm items-center">

                        <div>
                            {{ \Carbon\Carbon::parse($pemesanan->tanggal)->format('d-m-Y') }}
                        </div>

                        <div>
                            {{ $pemesanan->tiket->nama_tiket }}
                        </div>

                        <div>
                            Rp {{ number_format($pemesanan->tiket->harga,0,',','.') }}
                        </div>

                        <div>
                            {{ $pemesanan->jumlah_tiket }}
                        </div>

                        <div>
                            Rp {{ number_format($pemesanan->total_harga,0,',','.') }}
                        </div>

                        <div>
                            <span class="{{ $pemesanan->status == 'lunas' ? 'text-green-600' : 'text-yellow-500' }}">
                                {{ $pemesanan->status }}
                            </span>
                        </div>

                    </div>
                    @empty

                    <div class="p-6 text-center text-gray-500">
                        Belum ada pesanan
                    </div>

                    @endforelse

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>