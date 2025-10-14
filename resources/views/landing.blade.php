<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>CicilAja — Solusi Kredit Mudah dan Cepat</title>

        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        <link rel="icon" type="image/cicilaja.png" href="{{ asset('images/cicilaja.png') }}">


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

        @include('layouts.footer')
    </body>
</html>