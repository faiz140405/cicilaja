<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>CicilAja — Solusi Kredit Mudah dan Cepat</title>

        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" /> 
        <link rel="icon" type="image/cicilaja.png" href="{{ asset('images/cicilaja.png') }}">
        <link rel="stylesheet" href="https://lottie.host/304ff75b-a30c-4de5-a178-70896e25f6ce/zfsS19pRcb.lottie">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-900 bg-gray-100 dark:bg-gray-900 transition duration-300">
        
        {{-- TATA LETAK DUA KOLOM --}}
        <div class="min-h-screen flex">

            {{-- KOLOM KIRI: GAMBAR GRAFIS (TAMPIL HANYA DI LAYAR BESAR) --}}
            <div class="hidden md:flex md:w-1/2 bg-white-600 items-center justify-center p-10 relative overflow-hidden">
                <div class="text-center text-indigo z-10">
                    <h1 class="text-4xl font-extrabold mb-4">Selamat Datang!</h1>
                    <p class="text-xl opacity-90">Masuk untuk kelola pengajuan kredit Anda. Hanya di</p>
                    
                    {{-- Ganti URL ini dengan ilustrasi bertema kredit/dashboard Anda --}}
                    <img src="{{ asset('images/cicilaja.png') }}" 
                         alt="Ilustrasi Dashboard" 
                         class="mt-10 w-full max-w-sm mx-auto shadow-2xl rounded-lg"> 

                    {{-- Anda harus menempatkan file 'login_graphic.svg' di public/images/ --}}
                </div>
            </div>

            {{-- KOLOM KANAN: FORM LOGIN --}}
            <div class="w-full md:w-1/2 flex flex-col justify-center items-center p-6 sm:p-8 lg:p-12 bg-white dark:bg-gray-800">
                <div class="w-full max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-700 shadow-xl overflow-hidden sm:rounded-lg border border-gray-200 dark:border-gray-600">
                    
                    {{ $slot }} {{-- Ini adalah tempat form login/register Anda dimuat --}}
                    
                </div>
            </div>
            
        </div>

    </body>
</html>