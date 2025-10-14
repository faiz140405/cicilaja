<section id="beranda" class="relative overflow-hidden bg-white dark:bg-gray-900 transition duration-300 py-16 lg:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Menggunakan GRID untuk pembagian ruang Teks (Kiri) dan Gambar (Kanan) --}}
        <div class="lg:grid lg:grid-cols-2 lg:gap-12 lg:items-center">
            
            {{-- KOLOM 1: Teks & Tombol --}}
            <div class="order-1 lg:order-1 text-center lg:text-left pt-10 lg:pt-0">
                
                {{-- Judul --}}
                <h1 class="text-5xl tracking-tight font-extrabold text-gray-900 sm:text-6xl md:text-7xl dark:text-white">
                    <span class="block xl:inline">Selamat Datang di <i class="fa-solid fa-arrow-right text-indigo-600"></i></span>
                    <span class="block text-indigo-600 xl:inline dark:text-indigo-400">Cicil<span><span class="text-gray-900 dark:text-white">Aja</span></span>
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
                <img class="w-full h-auto max-h-96 object-contain rounded-xl 
                            shadow-2xl shadow-indigo-400/50 transform transition duration-500 
                            hover:scale-[1.02] 
                            dark:shadow-indigo-700/50"
                    src="{{ asset('images/icon-bg.png') }}"
                    alt="Ilustrasi belanja kredit online dan kemudahan bertransaksi">
            </div>
    </div>
</section>