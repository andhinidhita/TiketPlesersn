<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Bumi Perkemahan Pleseran</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<!-- NAVBAR -->
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


<!-- HERO -->
<section class="h-screen relative">

    <img src="{{ asset('images/bg.png') }}"
         class="absolute w-full h-full object-cover">

    <div class="absolute w-full h-full bg-black/50"></div>

    <div class="relative z-10 h-full flex items-center px-16 text-white">
        <div>
           
            </h1>
            <p class="max-w-lg">
                Buat kalian yang mau camping di pinggir sungai dengan background air terjun dan pesawahan, inilah tempatnya...
            </p>
        </div>
    </div>

</section>


<!-- ABOUT -->
<section id="about" class="py-16 px-10 bg-gray-100">
    <div class="grid md:grid-cols-2 gap-10 items-center">

        <img src="{{ asset('images/about.png') }}" class="rounded-lg shadow-lg">

        <div>
            <h2 class="text-2xl font-bold mb-4">
                BUMI PERKEMAHAN PLESERAN
            </h2>

            <p class="text-gray-600 mb-4">
                Bumi Perkemahan (Buper) Pleseran ini berada di area hutan lindung wilayah Perhutani KPH Surakarta. Tepatnya di Jalan Candi Menggung, Desa Nglurah, Area Hutan Lindung, Tawangmangu, Kabupaten KaranganyarTempat camping sekaligus wisata alam ini yang memiliki luas 2,5 hektare ini sudah dikelola sejak tahun 2016 lalu.Namun hingga saat ini, Bumi Perkemahan Pleseran masih menjadi pilihan untuk para wisatawan.
            </p>

            <p class="text-gray-600">
                Selain menjadi tempat camping favorit, di Bumi Perkemahan Pleseran menyuguhkan permainan outbond, seperti flying fox, kemudian bermain di sungai dan Telogo Asmoro, lalu memberi makan burung.
            </p>
        </div>

    </div>
</section>


<!-- GALERI -->
<section id="galeri" class="py-16 px-10 bg-white">

    <h2 class="text-center text-2xl font-bold mb-10">
        GALERI BUPER PLESERAN
    </h2>

    <div class="grid md:grid-cols-4 gap-6">

        <img src="{{ asset('images/g1.png') }}" class="rounded-lg shadow-md hover:scale-105 transition">
        <img src="{{ asset('images/g2.png') }}" class="rounded-lg shadow-md hover:scale-105 transition">
        <img src="{{ asset('images/g3.png') }}" class="rounded-lg shadow-md hover:scale-105 transition">
        <img src="{{ asset('images/g4.png') }}" class="rounded-lg shadow-md hover:scale-105 transition">

    </div>

</section>


<!-- CTA -->
<section class="py-16 px-10 bg-gray-100">
    <div class="grid md:grid-cols-2 gap-10 items-center">

        <div>
            <p class="text-sm text-gray-500">BUMI PERKEMAHAN PLESERAN</p>

            <h2 class="text-2xl font-bold mb-4">
                Pilihan wisata terbaik agar liburan akhir pekanmu jadi semakin asik.
            </h2>

            <p class="text-gray-600">
                Dapatkan pengalaman berkemah yang berkesan di tempat kami. Nikmati udara segar pegunungan, ciptakan momen kebersamaan, dan biarkan suara gemercik sungai menyambutmu setiap pagi.
            </p>
        </div>

        <img src="{{ asset('images/g5.png') }}" class="rounded-lg shadow-lg">

    </div>
</section>


<!-- CONTACT / FOOTER -->
<section id="contact" class="bg-[#1e1b2e] text-white py-10 px-10">

    <h2 class="text-xl font-bold mb-4">BUMI PERKEMAHAN PLESERAN</h2>

    <p class="mb-2">
        Jalan Candi Menggung Nglurah, Tawangmangu
    </p>

    <p class="mb-2">
        WA: 0812-2637-1995
    </p>

    <p>
        Email: BuperPleseran@gmail.com
    </p>

</section>

</body>
</html>