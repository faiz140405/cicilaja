<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>CicilAja — Solusi Kredit Mudah dan Cepat</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="..." crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
        <link rel="icon" type="image/cicilaja.png" href="{{ asset('images/cicilaja.png') }}">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
    </head>
    <body class="font-sans antialiased bg-gray-100 dark:bg-gray-900 transition duration-300" x-data="{ openPaymentModal: false, openPayoffModal: false, showProofModal: false, currentProofUrl: '' }">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        @include('admin.partials.confirmation-modal')

            <div x-cloak x-show="showProofModal" class="fixed inset-0 z-[70] overflow-y-auto">
        
        {{-- Overlay --}}
        <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" @click="showProofModal = false"></div>

        {{-- Modal Content --}}
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-white rounded-lg shadow-2xl max-w-2xl w-full mx-4 relative z-20">
                <div class="p-4 sm:p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Bukti Pembayaran</h3>
                    
                    <template x-if="currentProofUrl.includes('.pdf')">
                        <div class="text-center p-8 bg-gray-100 rounded-lg">
                            <p class="text-lg text-red-600 font-semibold">Tautan PDF tidak dapat ditampilkan langsung.</p>
                            <a :href="currentProofUrl" target="_blank" class="mt-2 inline-block px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                                Download atau Buka PDF
                            </a>
                        </div>
                    </template>
                    
                    <template x-if="!currentProofUrl.includes('.pdf')">
                        <img :src="currentProofUrl" alt="Bukti Pembayaran" class="max-w-full h-auto rounded-lg shadow-md mx-auto" />
                    </template>
                    
                    <div class="mt-6 text-right">
                        <button @click="showProofModal = false" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </body>
</html>
