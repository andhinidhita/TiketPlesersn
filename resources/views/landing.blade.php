<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Bumi Perkemahan Pleseran</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<!-- ================= NAVBAR ================= -->
<nav class="fixed w-full z-50 bg-[#1e1b2e] text-white px-10 py-4 flex justify-between items-center">
    <h1 class="font-bold text-lg">BUMI PERKEMAHAN PLESERAN</h1>

    <ul class="flex gap-6 text-sm items-center">
        <li><a href="#" class="hover:text-gray-300">Home</a></li>
        <li><a href="#about" class="hover:text-gray-300">About</a></li>
        <li><a href="#galeri" class="hover:text-gray-300">Galeri</a></li>
        <li><a href="#contact" class="hover:text-gray-300">Contact</a></li>
        <li>
            <a href="/login" class="border px-4 py-1 rounded-full hover:bg-white hover:text-black">
                Login
            </a>
        </li>
    </ul>
</nav>


<!-- ================= HERO ================= -->
<section class="h-screen relative">

    <img src="{{ asset('images/bg.png') }}"
         class="absolute w-full h-full object-cover">

    <!-- overlay gradient -->
    <div class="absolute w-full h-full bg-gradient-to-r from-black/40 to-transparent"></div>

    <div class="relative z-10 h-full flex items-end px-16 pb-20 text-white">

        <div class="max-w-lg">

            <p class="text-sm leading-relaxed bg-black/30 p-4 rounded-lg">
                Buat kalian yang mau camping di pinggir sungai dengan background air terjun 
                dan telaga, inilah tempatnya...
            </p>

        </div>

    </div>

</section>


<!-- ================= ABOUT ================= -->
<section id="about" class="py-20 px-6 bg-gradient-to-r from-gray-100 to-gray-200">

    <div class="max-w-6xl mx-auto bg-white rounded-2xl shadow-lg p-8 grid md:grid-cols-2 gap-10 items-center">

        <!-- IMAGE -->
        <img src="{{ asset('images/about.png') }}" 
             class="rounded-xl shadow-md w-full object-cover">

        <!-- TEXT -->
        <div>
            <h2 class="text-2xl font-bold mb-4 text-[#1e1b2e]">
                BUMI PERKEMAHAN PLESERAN
            </h2>

            <p class="text-gray-600 mb-4 leading-relaxed">
                Bumi Perkemahan (Buper) Pleseran ini berada di area hutan lindung wilayah Perhutani KPH Surakarta. Tepatnya di Jalan Candi Menggung, Desa Nglurah, Area Hutan Lindung, Tawangmangu, Kabupaten KaranganyarTempat camping sekaligus wisata alam ini yang memiliki luas 2,5 hektare ini sudah dikelola sejak tahun 2016 lalu.Namun hingga saat ini, Bumi Perkemahan Pleseran masih menjadi pilihan untuk para wisatawan.
            </p>

            <p class="text-gray-600 leading-relaxed">
                Selain menjadi tempat camping favorit, di Bumi Perkemahan Pleseran menyuguhkan permainan outbond, seperti flying fox, kemudian bermain di sungai dan Telogo Asmoro, lalu memberi makan burung.
            </p>

            <!-- BUTTON BIAR GA KOSONG -->
            <a href="#galeri"
               class="inline-block mt-6 bg-[#1e1b2e] text-white px-6 py-2 rounded-lg hover:bg-black transition">
               Lihat Galeri →
            </a>
        </div>

    </div>

</section>


<!-- ================= GALERI ================= -->
<section id="galeri" class="py-20 px-10 bg-white">

    <h2 class="text-center text-2xl font-bold mb-10">
        GALERI BUPER PLESERAN
    </h2>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 max-w-6xl mx-auto">

        <img src="{{ asset('images/g1.png') }}" class="rounded-lg shadow-md hover:scale-105 transition">
        <img src="{{ asset('images/g2.png') }}" class="rounded-lg shadow-md hover:scale-105 transition">
        <img src="{{ asset('images/g3.png') }}" class="rounded-lg shadow-md hover:scale-105 transition">
        <img src="{{ asset('images/g4.png') }}" class="rounded-lg shadow-md hover:scale-105 transition">

    </div>

    <div class="text-center mt-8">
        <a href="#" class="text-blue-600 hover:underline">
            Lihat Semua →
        </a>
    </div>

</section>


<!-- ================= CTA ================= -->
<section class="py-20 bg-gray-100">

    <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-10 items-center px-6">

        <!-- TEXT -->
        <div class="bg-white p-8 rounded-2xl shadow-lg">

            <p class="text-sm text-gray-500 mb-2">
                BUMI PERKEMAHAN PLESERAN
            </p>

            <h2 class="text-2xl font-bold mb-4 leading-snug">
                Pilihan wisata terbaik agar liburan akhir pekanmu jadi semakin asik.
            </h2>

            <p class="text-gray-600 mb-6">
                Dapatkan pengalaman berkemah yang berkesan di tempat kami. 
                Nikmati udara segar pegunungan, ciptakan momen kebersamaan, 
                dan biarkan suara gemericik sungai menyambutmu setiap pagi.
            </p>

            <!-- BUTTON -->
            <a href="/pemesanan"
               class="bg-[#1e1b2e] text-white px-6 py-2 rounded-lg hover:bg-black transition">
               Pesan Sekarang →
            </a>

        </div>

        <!-- IMAGE -->
        <div class="relative">

            <img src="{{ asset('images/g5.png') }}"
                 class="rounded-2xl shadow-lg w-full object-cover">

            <!-- overlay kecil biar ga flat -->
            <div class="absolute inset-0 bg-black/10 rounded-2xl"></div>

        </div>

    </div>

</section>

<!-- ================= FOOTER ================= -->
<section id="contact" class="bg-[#1e1b2e] text-white py-10 px-10">

    <h2 class="text-xl font-bold mb-4">
        BUMI PERKEMAHAN PLESERAN
    </h2>

    <p class="mb-2">
         📍 Jalan Candi Menggung Nglurah, Area Hutan, Tawangmangu, Karanganyar Regency, Central Java 57792
    </p>

    <p class="mb-2">
         📞 WA: 0812-2637-1995
    </p>

    <p>
         ✉️ Email: BuperPleseran@gmail.com
    </p>

</section>

</body>
</html>