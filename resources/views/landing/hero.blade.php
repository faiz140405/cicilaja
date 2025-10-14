<link rel="stylesheet" href="https://lottie.host/304ff75b-a30c-4de5-a178-70896e25f6ce/zfsS19pRcb.lottie">
<section id="beranda" class="relative overflow-hidden bg-white dark:bg-gray-900 transition duration-300 py-16 lg:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Menggunakan GRID untuk pembagian ruang Teks (Kiri) dan Gambar (Kanan) --}}
        <div class="lg:grid lg:grid-cols-2 lg:gap-12 lg:items-center">
            
            {{-- KOLOM 1: Teks & Tombol --}}
            <div class="order-1 lg:order-1 text-center lg:text-left pt-0 lg:pt-10">
                
                {{-- Judul: Menggunakan ukuran font besar (sm:text-6xl md:text-7xl) --}}
                <h1 class="text-5xl tracking-tight font-extrabold text-gray-900 sm:text-6xl md:text-7xl dark:text-white">
                    
                    {{-- Baris 1: Teks Statis --}}
                    <span class="block xl:inline">Selamat Datang di</span>
                    
                    {{-- Baris 2: Teks Dinamis Typed.js --}}
                    <span class="block text-indigo-600 xl:inline dark:text-indigo-400">
                        <span id="typed-text-output"></span> 
                    </span>
                </h1>
                
                {{-- Subjudul --}}
                <p class="mt-4 text-lg text-gray-500 md:text-xl lg:mx-0 dark:text-gray-400">
                    Beli barang impianmu, cicil dengan mudah dan cepat. Solusi kredit yang terpercaya.
                </p>
                
                {{-- Tombol Aksi --}}
                <div class="mt-8 flex justify-center lg:justify-start space-x-4">
                    <div class="rounded-md shadow">
                        <a href="#produk" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 transition duration-300 md:py-4 md:text-lg md:px-10">
                            Lihat Produk
                        </a>
                    </div>
                    <div class="mt-0">
                        <a href="#simulasi" class="w-full flex items-center justify-center px-8 py-3 border border-indigo-600 text-base font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 transition duration-300 md:py-4 md:text-lg md:px-10 dark:bg-transparent dark:text-indigo-400 dark:border-indigo-400 dark:hover:bg-indigo-900/20">
                            Hitung Cicilan
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="order-2 lg:order-2 mt-10 lg:mt-0">
            
            {{-- WRAPPER YANG MENENTUKAN UKURAN ILUSTRASI (Aspek Rasio 1:1) --}}
            <div class="relative w-full pb-[100%] lg:pb-[75%] rounded-xl transform hover:scale-[1.02] overflow-hidden">
                
                {{-- Ganti src dengan link Lottie JSON/Embed Anda yang sebenarnya --}}
                <iframe 
                    src="https://lottie.host/embed/6c7a4a03-1e18-4432-9497-c65b8cceb227/erewxGNsiE.json" 
                    class="absolute top-0 left-0 w-full h-full object-contain"
                    frameborder="0" 
                    allowfullscreen 
                    scrolling="no">
                </iframe>
            </div>
        </div>
    </div>
</section>
{{-- Letakkan ini di akhir file landing.blade.php --}}
<script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Cek apakah elemen target ada di halaman
        if (document.getElementById('typed-text-output')) {
            var typed = new Typed('#typed-text-output', {
                strings: [
                    "CicilAja"
                ],
                typeSpeed: 70,    // Kecepatan mengetik
                backSpeed: 50,    // Kecepatan menghapus
                loop: true,       // Ulangi terus-menerus
                backDelay: 2000,  // Jeda sebelum menghapus
                startDelay: 500
            });
        }
    });
</script>