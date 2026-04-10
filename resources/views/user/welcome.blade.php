
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Pergudangan</title>

    <!-- Tailwind CDN (bila tidak pakai Vite) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* ===== Custom CSS Tambahan ===== */
        body {
            @apply min-h-screen;
            background: none !important;
        }
        .stat-card {
            @apply bg-white rounded-xl shadow-xl p-6 flex items-center transition-transform transform hover:scale-105;
        }
        .stat-icon {
            @apply w-12 h-12 rounded-full flex items-center justify-center text-white;
        }


        /* Floating Telegram Button - REMOVED */
    </style>
</head>
<body class="antialiased text-gray-900">
    <div class="relative min-h-screen flex flex-col">
        <!-- Video Background -->
        <video autoplay loop muted playsinline class="fixed top-0 left-0 w-full h-full object-cover z-0" style="min-height:100vh; min-width:100vw;">
            <source src="{{ asset('storage/banner.mp4') }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <!-- Overlay agar konten tetap terbaca -->
        <div class="fixed top-0 left-0 w-full h-full bg-black/40 z-10"></div>

    <div class="flex flex-col justify-center items-center flex-1 px-4 lg:px-8 relative z-10">
            {{-- Logo dan Judul --}}
            <div class="text-center mb-10">
             <img src="{{ asset('logo/logo-jateng.svg') }}"
                 alt="Logo Provinsi Jawa Tengah"
                 class="mx-auto mb-4" style="max-width:240px; max-height:240px;">
                <h1 class="text-3xl lg:text-4xl font-bold text-white">
                    Sistem Pergudangan Online Distanbun
                </h1>
                <p class="text-lg text-gray-100 mt-2">
                    Dinas Pertanian dan Perkebunan Provinsi Jawa Tengah
                </p>

                <!-- Tombol Hero -->
                <div class="mt-10 flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <a href="{{ route('login') }}"
                       class="inline-flex items-center justify-center px-8 py-4 border-2 border-white text-white rounded-full font-bold text-lg hover:bg-white hover:text-gray-900 transition transform hover:scale-105 active:scale-95 w-full sm:w-auto">
                        Masuk ke Sistem
                    </a>

                </div>
            </div>


        </div>



    </div>

    <!-- Footer -->
    <footer class="mt-auto relative z-20" style="background: rgba(255,255,255,0.06); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); border-top:1px solid rgba(255,255,255,0.12);">
        <div class="max-w-7xl mx-auto px-4 py-8 grid grid-cols-1 md:grid-cols-2 gap-8 text-white">
            <div>
                <h2 class="font-bold text-lg mb-2">Alamat</h2>
                <p>Jl. Jenderal Gatot Subroto - Komplek Tarubudaya<br>
                Ungaran, 50501</p>
                <p class="mt-2"><span class="font-semibold">Telepon:</span> (024) 921010, 6921218, 6921348; Pimpinan (024) 6921430;</p>
                <p><span class="font-semibold">Fax:</span> 6921060, 6921348</p>
                <p><span class="font-semibold">Email:</span> distanbun@jatengprov.go.id</p>
                <p class="mt-2"><span class="font-semibold">Hari:</span> Senin - Kamis : 7:00 - 15:30 PM<br>
                <span class="font-semibold">Hari:</span> Jumat : 7:00 - 14:00</p>
            </div>
            <div>
                <h2 class="font-bold text-lg mb-2">Lokasi Peta</h2>
                <a href="https://maps.app.goo.gl/WxxYrvRzt3Hx99LV7" target="_blank" rel="noopener noreferrer" title="Buka di Google Maps">
                    <div class="rounded-lg overflow-hidden shadow-md border border-gray-300 cursor-pointer hover:ring-2 hover:ring-blue-400 transition">
                        <iframe src="https://www.google.com/maps?q=-7.1270136,110.4064432&hl=id&z=16&output=embed" width="100%" height="220" style="border:0; pointer-events:none;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </a>
            </div>
        </div>
        <div class="text-center text-xs py-2" style="color:rgba(255,255,255,0.75); border-top:1px solid rgba(255,255,255,0.04);">&copy; {{ date('Y') }} Dinas Pertanian dan Perkebunan Provinsi Jawa Tengah</div>
    </footer>

</body>
</html>

