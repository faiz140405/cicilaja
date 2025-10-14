<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ & Panduan | CicilAja</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-800 bg-gray-50 dark:bg-gray-900 transition duration-300" x-data="{ open: null }">
    @include('layouts.navbar')

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center mb-12">
            <h1 class="text-5xl font-extrabold text-indigo-600 dark:text-indigo-400">Tanya Jawab (FAQ)</h1>
            <p class="mt-3 text-lg text-gray-600 dark:text-gray-400">Panduan lengkap seputar pengajuan kredit.</p>
        </div>

        <div class="bg-white dark:bg-gray-800 p-8 md:p-12 rounded-xl shadow-xl border border-gray-200 dark:border-gray-700">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Panduan Pengajuan Kredit</h2>
            <div class="text-gray-700 dark:text-gray-300 space-y-4 mb-10">
                <p>1. Pilih produk impian Anda dari daftar produk di halaman utama.</p>
                <p>2. Klik "Ajukan Kredit" dan Anda akan diarahkan ke formulir pengajuan.</p>
                <p>3. Masukkan Uang Muka (DP) dan pilih Tenor (lama cicilan) yang Anda inginkan. Sistem akan menghitung estimasi cicilan bulanan Anda.</p>
                <p>4. Klik "Kirim Pengajuan Kredit". Pengajuan Anda akan masuk ke antrian verifikasi Admin.</p>
                <p>5. Cek status pengajuan Anda di Dashboard Pelanggan.</p>
            </div>

            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6 mt-12">Pertanyaan Umum</h2>
            
            {{-- Accordion FAQ --}}
            @php
                $faqs = [
                    ['q' => 'Berapa lama proses verifikasi pengajuan?', 'a' => 'Verifikasi membutuhkan waktu maksimal 1x24 jam kerja.'],
                    ['q' => 'Berapa bunga yang dikenakan?', 'a' => 'Kami mengenakan bunga flat sebesar 10% dari sisa harga setelah DP.'],
                    ['q' => 'Apakah saya bisa mengajukan lebih dari satu produk?', 'a' => 'Ya, Anda dapat mengajukan produk lain setelah pengajuan pertama Anda disetujui.'],
                    ['q' => 'Bagaimana cara upload bukti pembayaran?', 'a' => 'Akses menu "Cicilan Saya" di Dashboard Anda, lalu upload file bukti (gambar/PDF) pada periode cicilan yang tersedia.'],
                ];
            @endphp

            <div class="space-y-4">
                @foreach($faqs as $key => $faq)
                <div class="border border-gray-200 dark:border-gray-600 rounded-lg overflow-hidden">
                    <button @click="open = (open === {{ $key }} ? null : {{ $key }})" class="w-full text-left p-4 bg-gray-50 dark:bg-gray-700 text-lg font-semibold text-gray-800 dark:text-white flex justify-between items-center hover:bg-gray-100 dark:hover:bg-gray-600 transition duration-150">
                        {{ $faq['q'] }}
                        <svg :class="{'transform rotate-180': open === {{ $key }}}" class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="open === {{ $key }}" x-collapse.duration.500ms class="p-4 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-600">
                        {{ $faq['a'] }}
                    </div>
                </div>
                @endforeach
            </div>
            
        </div>
    </div>
</body>
</html>
