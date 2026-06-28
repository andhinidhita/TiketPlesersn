<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice #INV-{{ $pemesanan->id }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @php
        $canPay = $pemesanan->status === 'pending'
            && $pemesanan->availability_status === 'approved'
            && auth()->user()->role !== 'admin';
    @endphp

    @if($canPay)
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    @endif
</head>
<body class="bg-slate-50 font-sans text-slate-900 antialiased">
    <main class="mx-auto min-h-screen max-w-4xl px-5 py-8">
        <div class="mb-5 flex items-center justify-between print:hidden">
            <a href="{{ auth()->user()->role === 'admin' ? route('admin.transaksi') : route('riwayat') }}" class="text-sm font-semibold text-slate-600 hover:text-slate-950">Kembali</a>
            <button onclick="window.print()" class="rounded-md bg-slate-950 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">
                Cetak
            </button>
        </div>

        <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <div class="flex flex-col gap-6 border-b border-slate-200 pb-6 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-wide text-emerald-700">Invoice</p>
                    <h1 class="mt-2 text-3xl font-bold text-slate-950">#INV-{{ $pemesanan->id }}</h1>
                    <p class="mt-2 text-sm text-slate-500">Bukti pemesanan tiket Bumi Perkemahan Pleseran.</p>
                </div>
                <div class="text-sm sm:text-right">
                    <p class="font-bold text-slate-950">Bumi Perkemahan Pleseran</p>
                    <p class="mt-1 text-slate-500">Tawangmangu, Karanganyar</p>
                </div>
            </div>

            <div class="grid gap-5 border-b border-slate-200 py-6 sm:grid-cols-3">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Nama</p>
                    <p class="mt-2 font-semibold text-slate-950">{{ $pemesanan->user->name }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Tanggal Kunjungan</p>
                    <p class="mt-2 font-semibold text-slate-950">{{ optional($pemesanan->tanggal)->format('d M Y') ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Status</p>
                    <span class="mt-2 inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $pemesanan->status == 'lunas' ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">
                        {{ ucfirst($pemesanan->status) }}
                    </span>
                </div>
            </div>

            @if($pemesanan->availability_status !== 'approved')
                <div class="mt-6 rounded-md border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800">
                    Pesanan ini belum bisa dibayar karena masih menunggu konfirmasi ketersediaan dari admin.
                </div>
            @endif

            <div class="overflow-x-auto py-6">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead>
                        <tr>
                            <th class="py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Tiket</th>
                            <th class="py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Paket</th>
                            <th class="py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Harga</th>
                            <th class="py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Jumlah</th>
                            <th class="py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Durasi</th>
                            <th class="py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <tr>
                            <td class="py-4 text-sm font-semibold text-slate-950">{{ $pemesanan->tiket->nama_tiket }}</td>
                            <td class="py-4 text-sm text-slate-600">
                                @if($pemesanan->paket_camping)
                                    <p class="font-semibold text-slate-950">{{ $pemesanan->paket_camping }}</p>
                                    <p class="mt-1 text-xs text-slate-500">Rp {{ number_format($pemesanan->harga_paket,0,',','.') }}/hari</p>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="py-4 text-right text-sm text-slate-600">Rp {{ number_format($pemesanan->tiket->harga,0,',','.') }}</td>
                            <td class="py-4 text-right text-sm text-slate-600">{{ $pemesanan->jumlah_tiket }}</td>
                            <td class="py-4 text-right text-sm text-slate-600">{{ $pemesanan->durasi }} hari</td>
                            <td class="py-4 text-right text-sm font-semibold text-slate-950">Rp {{ number_format($pemesanan->total_harga,0,',','.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            @if(! empty($pemesanan->rental_items))
                <div class="border-t border-slate-200 py-6">
                    <p class="text-sm font-bold text-slate-950">Rental Tambahan</p>
                    <div class="mt-3 grid gap-2 sm:grid-cols-2">
                        @foreach($pemesanan->rental_items as $item)
                            <div class="rounded-md bg-slate-50 px-3 py-2 text-sm text-slate-600">
                                <span class="font-semibold text-slate-950">{{ $item['nama'] }}</span>
                                <span> x{{ $item['jumlah'] }} - Rp {{ number_format($item['subtotal'],0,',','.') }}/hari</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="flex justify-end border-t border-slate-200 pt-6">
                <div class="w-full max-w-xs">
                    <div class="flex items-center justify-between text-sm text-slate-500">
                        <span>Rental / hari</span>
                        <span>Rp {{ number_format($pemesanan->rental_total,0,',','.') }}</span>
                    </div>
                    <div class="mt-2 flex items-center justify-between text-sm text-slate-500">
                        <span>Durasi</span>
                        <span>{{ $pemesanan->durasi }} hari</span>
                    </div>
                    <div class="mt-3 flex items-center justify-between text-lg font-bold text-slate-950">
                        <span>Total</span>
                        <span>Rp {{ number_format($pemesanan->total_harga,0,',','.') }}</span>
                    </div>
                </div>
            </div>

            @if($canPay)
            <div class="mt-8 flex justify-end print:hidden">
                <button id="pay-button" type="button" @disabled(empty($snapToken)) class="inline-flex items-center justify-center rounded-md px-6 py-3 text-sm font-bold text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 {{ empty($snapToken) ? 'cursor-not-allowed bg-slate-400' : 'bg-emerald-700 hover:bg-emerald-800' }}">
                    Bayar Sekarang
                </button>
            </div>

            @if(empty($snapToken))
                <p class="mt-3 text-right text-sm text-red-600 print:hidden">
                    Tombol bayar belum siap. Periksa koneksi internet dan konfigurasi Midtrans, lalu refresh halaman.
                </p>
            @endif
            @endif

        </section>
    </main>

    <div id="success-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/50 backdrop-blur-sm transition-opacity">
        <div class="relative w-full max-w-sm scale-100 rounded-xl bg-white p-6 text-center shadow-2xl transition-transform sm:p-8">
            
            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-emerald-100">
                <svg class="h-8 w-8 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            
            <h3 class="mt-5 text-xl font-bold text-slate-950">Pembayaran Berhasil!</h3>
            <p class="mt-2 text-sm text-slate-500">Terima kasih, pembayaran tiket Anda sudah masuk dan menunggu verifikasi admin.</p>
            
            <button id="btn-lihat-tiket" class="mt-6 w-full rounded-md bg-emerald-700 px-4 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-emerald-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                Lihat Tiket Saya
            </button>
        </div>
    </div>

    @if($canPay && ! empty($snapToken))
    <script type="text/javascript">
        var payButton = document.getElementById('pay-button');
        var successModal = document.getElementById('success-modal');
        var btnLihatTiket = document.getElementById('btn-lihat-tiket');

        function syncMidtransResult(result) {
            fetch("{{ url('/midtrans/callback') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify(result),
                keepalive: true,
            });
        }

        payButton.addEventListener('click', function () {
            if (!window.snap) {
                alert('Script Midtrans belum berhasil dimuat. Pastikan internet aktif, lalu refresh halaman.');
                return;
            }

            window.snap.pay('{{ $snapToken }}', {
                onSuccess: function(result){
                    syncMidtransResult(result);

                    // 1. Munculkan Modal Keren kita (Hapus class 'hidden')
                    successModal.classList.remove('hidden');
                    successModal.classList.add('flex');

                    // 2. Jika tombol "Lihat Tiket Saya" diklik, arahkan ke riwayat
                    btnLihatTiket.addEventListener('click', function() {
                        window.location.href = "{{ route('riwayat') }}";
                    });

                    // 3. (Opsional) Otomatis redirect setelah 4 detik
                    setTimeout(function() {
                        window.location.href = "{{ route('riwayat') }}";
                    }, 4000);
                },
                onPending: function(result){
                    syncMidtransResult(result);
                    alert("Menunggu pembayaran Anda!");
                },
                onError: function(result){
                    alert("Pembayaran gagal!");
                },
                onClose: function(){
                    // Biarkan kosong atau beri notifikasi halus
                    console.log('Pop-up ditutup');
                }
            });
        });
    </script>
    @endif
    
</body>
</html>
