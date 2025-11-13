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
                    duration: 1000, // Durasi animasi dalam ms
                    once: true,     // Animasi hanya berjalan sekali saat scroll
                });
            });
        </script>

        @include('layouts.footer')
    </body>
</html>