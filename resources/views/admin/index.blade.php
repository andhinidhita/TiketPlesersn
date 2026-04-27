<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            🎫 Admin - Verifikasi Tiket
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-md rounded-lg p-6">

                <h3 class="text-lg font-bold mb-4">Daftar Pemesanan</h3>

                <div class="overflow-x-auto">
                    <table class="w-full border border-gray-200 rounded-lg">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="p-3 text-left">Nama Tiket</th>
                                <th class="p-3 text-left">Jumlah</th>
                                <th class="p-3 text-left">Total</th>
                                <th class="p-3 text-left">Status</th>
                                <th class="p-3 text-left">Bukti</th>
                                <th class="p-3 text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pemesanans as $p)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="p-3">{{ $p->tiket->nama_tiket }}</td>
                                <td class="p-3">{{ $p->jumlah_tiket }}</td>
                                <td class="p-3">Rp {{ number_format($p->total_harga) }}</td>

                                <td class="p-3">
                                    @if($p->status == 'lunas')
                                        <span class="text-green-600 font-semibold">Lunas</span>
                                    @else
                                        <span class="text-yellow-600 font-semibold">Pending</span>
                                    @endif
                                </td>

                                <td class="p-3">
                                    @if($p->bukti_pembayaran)
                                        <a href="{{ asset('bukti/'.$p->bukti_pembayaran) }}" 
                                           target="_blank"
                                           class="text-blue-600 underline">
                                           Lihat
                                        </a>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>

                                <td class="p-3">
                                    <form action="/admin/verifikasi/{{ $p->id }}" method="POST">
                                        @csrf
                                        <button 
                                            class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded shadow">
                                            ✔ Verifikasi
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>