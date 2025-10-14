<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" /> 
<section id="about" class="py-20 bg-white dark:bg-gray-900 transition duration-300 scroll-mt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- HEADER --}}
        <div class="text-center mb-16">
            <h2 class="text-4xl font-extrabold text-gray-900 dark:text-white"><span class="text-indigo-600 dark:text-indigo-400">Tentang</span> Cicil<span class="text-indigo-600 dark:text-indigo-400">Aja</span></h2>
            <p class="mt-3 text-lg text-gray-600 dark:text-gray-400">Solusi pembiayaan yang mudah, cepat, dan terpercaya.</p>
        </div>

        {{-- CONTENT CARD --}}
        <div class="bg-gray-50 dark:bg-gray-800 p-8 md:p-12 rounded-2xl shadow-2xl border border-gray-100 dark:border-gray-700">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16">
                
                {{-- KOLOM KIRI: MISI KAMI --}}
                <div class="order-2 lg:order-1">
                    <h3 class="text-3xl font-bold text-indigo-600 dark:text-indigo-400 mb-6 flex items-center">
                        <i class="fas fa-rocket text-indigo-600 mr-3"></i> {{-- ICON UNIK --}}
                        Misi Kami
                    </h3>
                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed mb-6 text-lg">
                        CicilAja didirikan dengan visi untuk menghilangkan hambatan dalam memiliki barang impian. Kami percaya bahwa setiap orang berhak mendapatkan akses kredit yang transparan dan terjangkau untuk kebutuhan kendaraan, elektronik, hingga perabotan rumah tangga.
                    </p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Proses pengajuan kami dirancang sederhana, cepat, dan 100% online.
                    </p>
                </div>

                {{-- KOLOM KANAN: KEUNGGULAN KAMI (DENGAN HOVER EFFECT) --}}
                <div class="order-1 lg:order-2 lg:border-l border-gray-300/50 lg:pl-10">
                    <h3 class="text-3xl font-bold text-indigo-600 dark:text-indigo-400 mb-6 flex items-center">
                        <i class="fas fa-hand-holding-heart text-indigo-600 mr-3"></i> {{-- ICON UNIK --}}
                        Keunggulan Kami
                    </h3>
                    
                    <ul class="space-y-4">
                        
                        {{-- Keunggulan 1: Cepat --}}
                        <li class="p-4 rounded-xl border border-transparent hover:border-indigo-300 transition duration-300 hover:shadow-lg bg-white dark:bg-gray-700">
                            <div class="flex items-start">
                                <i class="fas fa-bolt flex-shrink-0 w-6 h-6 text-yellow-600 mr-3 mt-1"></i> {{-- ICON BARU --}}
                                <div>
                                    <span class="font-bold text-gray-900 dark:text-white">Proses Kilat:</span> 
                                    <p class="text-gray-700 dark:text-gray-300">Pengajuan Anda diproses dalam waktu <span class="font-bold text-indigo-600">24 jam kerja</span> sejak dokumen lengkap diterima.</p>
                                </div>
                            </div>
                        </li>
                        
                        {{-- Keunggulan 2: Bunga Rendah --}}
                        <li class="p-4 rounded-xl border border-transparent hover:border-indigo-300 transition duration-300 hover:shadow-lg bg-white dark:bg-gray-700">
                            <div class="flex items-start">
                                <i class="fas fa-percent flex-shrink-0 w-6 h-6 text-blue-600 mr-3 mt-1"></i> {{-- ICON BARU --}}
                                <div>
                                    <span class="font-bold text-gray-900 dark:text-white">Bunga Kompetitif:</span> 
                                    <p class="text-gray-700 dark:text-gray-300">Suku bunga flat <span class="font-bold text-indigo-600">10%</span> yang transparan tanpa biaya tersembunyi. Tidak ada kejutan biaya di akhir.</p>
                                </div>
                            </div>
                        </li>

                         {{-- Keunggulan 3: Fleksibel --}}
                        <li class="p-4 rounded-xl border border-transparent hover:border-indigo-300 transition duration-300 hover:shadow-lg bg-white dark:bg-gray-700">
                            <div class="flex items-start">
                                <i class="fas fa-calendar-alt flex-shrink-0 w-6 h-6 text-green-600 mr-3 mt-1"></i> {{-- ICON BARU --}}
                                <div>
                                    <span class="font-bold text-gray-900 dark:text-white">Cicilan Fleksibel:</span> 
                                    <p class="text-gray-700 dark:text-gray-300">Pilihan tenor <span class="font-bold text-indigo-600">6, 12, 18, hingga 24 bulan</span> yang dapat disesuaikan dengan kemampuan Anda.</p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</section>