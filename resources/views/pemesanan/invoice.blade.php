<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice #INV-{{ $pemesanan->id }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @if($pemesanan->status === 'pending')
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    @endif
</head>
<body class="bg-slate-50 font-sans text-slate-900 antialiased">
    <main class="mx-auto min-h-screen max-w-4xl px-5 py-8">
        <div class="mb-5 flex items-center justify-between print:hidden">
            <a href="{{ route('riwayat') }}" class="text-sm font-semibold text-slate-600 hover:text-slate-950">Kembali</a>
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

            <div class="overflow-x-auto py-6">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead>
                        <tr>
                            <th class="py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Tiket</th>
                            <th class="py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Harga</th>
                            <th class="py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Jumlah</th>
                            <th class="py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <tr>
                            <td class="py-4 text-sm font-semibold text-slate-950">{{ $pemesanan->tiket->nama_tiket }}</td>
                            <td class="py-4 text-right text-sm text-slate-600">Rp {{ number_format($pemesanan->tiket->harga,0,',','.') }}</td>
                            <td class="py-4 text-right text-sm text-slate-600">{{ $pemesanan->jumlah_tiket }}</td>
                            <td class="py-4 text-right text-sm font-semibold text-slate-950">Rp {{ number_format($pemesanan->total_harga,0,',','.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="flex justify-end border-t border-slate-200 pt-6">
                <div class="w-full max-w-xs">
                    <div class="flex items-center justify-between text-sm text-slate-500">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($pemesanan->total_harga,0,',','.') }}</span>
                    </div>
                    <div class="mt-3 flex items-center justify-between text-lg font-bold text-slate-950">
                        <span>Total</span>
                        <span>Rp {{ number_format($pemesanan->total_harga,0,',','.') }}</span>
                    </div>
                </div>
            </div>

            @if($pemesanan->status === 'pending')
            <div class="mt-8 flex justify-end print:hidden">
                <button id="pay-button" class="inline-flex items-center justify-center rounded-md bg-emerald-700 px-6 py-3 text-sm font-bold text-white shadow-sm hover:bg-emerald-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                    Bayar Sekarang
                </button>
            </div>
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
            <p class="mt-2 text-sm text-slate-500">Terima kasih, pembayaran tiket Anda telah kami terima dan terkonfirmasi.</p>
            
            <button id="btn-lihat-tiket" class="mt-6 w-full rounded-md bg-emerald-700 px-4 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-emerald-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                Lihat Tiket Saya
            </button>
        </div>
    </div>

    @if($pemesanan->status === 'pending' && isset($snapToken))
    <script type="text/javascript">
        var payButton = document.getElementById('pay-button');
        var successModal = document.getElementById('success-modal');
        var btnLihatTiket = document.getElementById('btn-lihat-tiket');

        payButton.addEventListener('click', function () {
            window.snap.pay('{{ $snapToken }}', {
                onSuccess: function(result){
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