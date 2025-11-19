<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>CicilAja — Solusi Kredit Mudah dan Cepat</title>

        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        <link rel="icon" type="image/cicilaja.png" href="{{ asset('images/cicilaja.png') }}">
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">


        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-800 bg-white">
        @include('layouts.navbar')

        <main>
            @include('landing.hero')
            @include('landing.products', ['products' => $products])
            @include('landing.simulation')
            @include('landing.testimonials')
            @include('landing.about')
            @include('landing.contact')
        </main>

        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                AOS.init({
                    duration: 1000,
                });
            });
        </script>

        @include('layouts.footer')
        <div x-data="{ showScrollTop: false }" 
             @scroll.window="showScrollTop = (window.pageYOffset > 300) ? true : false"
             class="fixed bottom-6 right-6 z-50 flex flex-col gap-3">

            <button 
                x-show="showScrollTop"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-4"
                @click="window.scrollTo({top: 0, behavior: 'smooth'})"
                class="p-3 bg-gray-800 hover:bg-gray-700 text-white rounded-full shadow-lg transition-colors duration-300 flex items-center justify-center w-12 h-12"
                aria-label="Kembali ke atas">
                <i class="fas fa-arrow-up"></i>
            </button>

            <a href="https://wa.me/6281809884140?text=Halo%20CicilAja,%20saya%20butuh%20bantuan." 
               target="_blank"
               class="p-3 bg-green-500 hover:bg-green-600 text-white rounded-full shadow-lg transition-colors duration-300 flex items-center justify-center w-12 h-12 animate-bounce-slow"
               aria-label="Hubungi WhatsApp">
                <i class="fab fa-whatsapp text-2xl"></i>
            </a>

        </div>
    </body>
</html>