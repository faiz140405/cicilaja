<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Syarat & Ketentuan | CicilAja</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-800 bg-gray-50 dark:bg-gray-900 transition duration-300">
    @include('layouts.navbar')

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center mb-12">
            <h1 class="text-5xl font-extrabold text-indigo-600 dark:text-indigo-400">Syarat & Ketentuan</h1>
            <p class="mt-3 text-lg text-gray-600 dark:text-gray-400">Harap baca dengan seksama sebelum mengajukan kredit.</p>
        </div>

        <div class="bg-white dark:bg-gray-800 p-8 md:p-12 rounded-xl shadow-xl border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300">
            
            <h2 class="text-2xl font-bold mb-4 text-gray-900 dark:text-white">1. Persyaratan Umum</h2>
            <ul class="list-disc list-inside space-y-2 mb-6 ml-4">
                <li>Pemohon adalah Warga Negara Indonesia (WNI).</li>
                <li>Usia minimal 21 tahun dan maksimal 55 tahun saat kredit lunas.</li>
                <li>Memiliki penghasilan tetap/usaha yang dapat diverifikasi.</li>
            </ul>

            <h2 class="text-2xl font-bold mb-4 text-gray-900 dark:text-white mt-8">2. Mekanisme Pengajuan</h2>
            <ul class="list-disc list-inside space-y-2 mb-6 ml-4">
                <li>Harga kredit yang ditampilkan di website sudah termasuk bunga flat 10%.</li>
                <li>Uang Muka (DP) minimal adalah 10% dari Harga Kredit.</li>
                <li>Pengajuan dianggap sah setelah formulir diisi lengkap dan dikirimkan.</li>
                <li>Status pengajuan dapat dipantau melalui Dashboard Pelanggan.</li>
            </ul>

            <h2 class="text-2xl font-bold mb-4 text-gray-900 dark:text-white mt-8">3. Pembayaran dan Denda</h2>
            <ul class="list-disc list-inside space-y-2 mb-6 ml-4">
                <li>Cicilan wajib dibayar setiap bulan sebelum tanggal jatuh tempo.</li>
                <li>Pembayaran dilakukan dengan mengunggah bukti transfer melalui menu "Cicilan Saya".</li>
                <li>Keterlambatan pembayaran cicilan akan dikenakan denda sesuai dengan perjanjian yang disetujui.</li>
            </ul>

            <p class="mt-8 italic text-sm text-center">
                Dengan mengajukan kredit, Anda dianggap telah menyetujui semua Syarat & Ketentuan di atas.
            </p>
        </div>
    </div>
</body>
</html>