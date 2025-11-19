<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'CicilAja') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
        <link rel="icon" type="image/cicilaja.png" href="{{ asset('images/cicilaja.png') }}">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <script>
            if (localStorage.getItem('darkMode') === 'true' || (!('darkMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>
    </head>
    
    <body class="font-sans antialiased bg-gray-100 dark:bg-gray-900 transition-colors duration-300" 
          x-data="{ openPaymentModal: false, openPayoffModal: false, showProofModal: false, currentProofUrl: '' }">
        
        {{-- WRAPPER UTAMA (Typo diperbaiki) --}}
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900 transition-colors duration-300">
            
            @include('layouts.navigation')

            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow transition-colors duration-300">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main>
                {{ $slot }}
            </main>
        </div>

        {{-- MODAL KONFIRMASI (GLOBAL) --}}
        @include('admin.partials.confirmation-modal')

        {{-- MODAL BUKTI PEMBAYARAN (GLOBAL - DARK MODE FIXED) --}}
        <div x-cloak x-show="showProofModal" class="fixed inset-0 z-[70] overflow-y-auto">
            
            {{-- Overlay Gelap --}}
            <div class="fixed inset-0 bg-gray-900 bg-opacity-75 backdrop-blur-sm transition-opacity" @click="showProofModal = false"></div>

            {{-- Modal Content --}}
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl max-w-2xl w-full mx-4 relative z-20 border border-gray-200 dark:border-gray-700 transform transition-all">
                    
                    <div class="p-6">
                        {{-- Header Modal --}}
                        <div class="flex justify-between items-center mb-4 border-b border-gray-200 dark:border-gray-700 pb-3">
                            <h3 class="text-xl font-bold text-gray-800 dark:text-white">Bukti Pembayaran</h3>
                            <button @click="showProofModal = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition focus:outline-none">
                                <i class="fas fa-times text-xl"></i>
                            </button>
                        </div>
                        
                        {{-- Body Modal --}}
                        <div class="flex justify-center items-center bg-gray-100 dark:bg-gray-900 rounded-lg p-4 min-h-[250px] border border-gray-200 dark:border-gray-700">
                            
                            {{-- Tampilan Jika PDF --}}
                            <template x-if="currentProofUrl.includes('.pdf')">
                                <div class="text-center">
                                    <i class="fas fa-file-pdf text-5xl text-red-500 mb-3"></i>
                                    <p class="text-lg text-gray-700 dark:text-gray-300 font-semibold mb-2">Dokumen PDF</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Preview tidak tersedia untuk PDF.</p>
                                    
                                    <a :href="currentProofUrl" target="_blank" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition shadow-md">
                                        <i class="fas fa-download mr-2"></i> Download / Buka PDF
                                    </a>
                                </div>
                            </template>
                            
                            {{-- Tampilan Jika Gambar --}}
                            <template x-if="!currentProofUrl.includes('.pdf')">
                                <img :src="currentProofUrl" alt="Bukti Pembayaran" class="max-w-full h-auto max-h-[600px] rounded-md shadow-md object-contain" />
                            </template>
                        </div>
                        
                        {{-- Footer Modal --}}
                        <div class="mt-6 text-right">
                            <button @click="showProofModal = false" class="px-5 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-white rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition font-semibold">
                                Tutup
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </body>
</html>