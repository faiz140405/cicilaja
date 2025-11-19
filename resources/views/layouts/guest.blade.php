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
    <body class="font-sans antialiased text-gray-900 bg-gray-100 dark:bg-gray-900 transition duration-300" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" x-init="document.documentElement.classList.toggle('dark', darkMode)">
        
        {{-- TATA LETAK DUA KOLOM --}}
        <div class="min-h-screen flex">

            {{-- KOLOM KIRI: GAMBAR GRAFIS (TAMPIL HANYA DI LAYAR BESAR) --}}
            <div class="hidden md:flex md:w-1/2 bg-white dark:bg-gray-800 items-center justify-center p-10 relative overflow-hidden">
                <div class="text-center text-indigo z-10">
                    <h1 class="text-4xl font-extrabold mb-4 text-indigo-800 dark:text-indigo-400">Selamat Datang!</h1>
                    <p class="text-xl opacity-90 text-gray-700 dark:text-gray-300">Masuk untuk kelola pengajuan kredit Anda</p>

                    <!-- Dark Mode Toggle Button -->
                    <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode); document.documentElement.classList.toggle('dark', darkMode)" class="mt-4 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 transition duration-300">
                        <i :class="darkMode ? 'fas fa-sun' : 'fas fa-moon'" class="mr-2"></i>
                        <span x-text="darkMode ? 'Light Mode' : 'Dark Mode'"></span>
                    </button>

                    <iframe
                        src="https://lottie.host/embed/04c34f83-8c1f-42b7-b22b-1ba81c3dbaab/zyMyR2FEQE.lottie"
                        alt="Ilustrasi Dashboard"
                        class="mt-10 mx-auto rounded-lg"
                        style="width: 400px; height: 400px;">
                    </iframe>
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