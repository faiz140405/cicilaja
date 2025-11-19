<section id="kontak" class="py-20 bg-gray-50 dark:bg-gray-900 scroll-mt-20 transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- HEADER SECTION --}}
        <div class="text-center mb-12" data-aos="fade-up">
            <h2 class="text-4xl md:text-5xl font-extrabold text-indigo-600 dark:text-indigo-400 transition-colors duration-300">
                <i class="fa-solid fa-headset mr-2"></i>Hubungi Kami
            </h2>
            <p class="mt-3 text-lg text-gray-600 dark:text-gray-400 transition-colors duration-300">
                Kami siap membantu menjawab pertanyaan Anda seputar simulasi dan pengajuan.
            </p>
        </div>

        {{-- MAIN CONTAINER --}}
        <div class="bg-white dark:bg-gray-800 p-8 md:p-12 rounded-2xl shadow-2xl border border-gray-100 dark:border-gray-700 space-y-12 transition-colors duration-300">
            
            {{-- BAGIAN 1: INFO KONTAK CARDS (3 Kolom) --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 text-center">
                
                {{-- CARD 1: Email --}}
                <div class="group p-6 border border-gray-100 dark:border-gray-700 rounded-xl hover:shadow-xl hover:border-indigo-200 dark:hover:border-indigo-900 transition duration-300 bg-gray-50 dark:bg-gray-700/50">
                    <div class="w-20 h-20 mx-auto mb-4 relative">
                        <iframe src="https://lottie.host/embed/99985857-ff0a-47b8-9a10-8a3dcdc4d005/lgRogfdVo2.lottie" class="absolute top-0 left-0 w-full h-full pointer-events-none" frameborder="0"></iframe>
                    </div>
                    <p class="font-bold text-xl text-gray-900 dark:text-white mb-2">Email</p>
                    <a href="mailto:cicilAja@gmail.com" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 transition font-medium break-all">
                        cicilAja@gmail.com
                    </a>
                </div>

                {{-- CARD 2: Telepon --}}
                <div class="group p-6 border border-gray-100 dark:border-gray-700 rounded-xl hover:shadow-xl hover:border-indigo-200 dark:hover:border-indigo-900 transition duration-300 bg-gray-50 dark:bg-gray-700/50">
                    <div class="w-20 h-20 mx-auto mb-4 relative">
                        <iframe src="https://lottie.host/embed/cc0a2406-a97c-4efd-9360-6cdc7a2f4012/NmcZflS7n6.lottie" class="absolute top-0 left-0 w-full h-full pointer-events-none" frameborder="0"></iframe>
                    </div>
                    <p class="font-bold text-xl text-gray-900 dark:text-white mb-2">Telepon / WA</p>
                    <a href="https://wa.me/6281809884140" target="_blank" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 transition font-medium">
                        +62 818 0988 4140
                    </a>
                </div>

                {{-- CARD 3: Alamat --}}
                <div class="group p-6 border border-gray-100 dark:border-gray-700 rounded-xl hover:shadow-xl hover:border-indigo-200 dark:hover:border-indigo-900 transition duration-300 bg-gray-50 dark:bg-gray-700/50">
                    <div class="w-20 h-20 mx-auto mb-4 relative">
                        <iframe src="https://lottie.host/embed/c83b7b44-dd24-4858-ba4a-7831d5d3e5da/ICNZDMcRuQ.lottie" class="absolute top-0 left-0 w-full h-full pointer-events-none" frameborder="0"></iframe>
                    </div>
                    <p class="font-bold text-xl text-gray-900 dark:text-white mb-2">Alamat Kantor</p>
                    <p class="text-gray-600 dark:text-gray-300 text-sm md:text-base">
                        Jl. Karang Rejo, Kec. Semaka, Kab. Tanggamus, Lampung
                    </p>
                </div>
            </div>

            {{-- BAGIAN 2: FORM & MAP (2 Kolom) --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 pt-10 border-t border-gray-200 dark:border-gray-700">
                
                {{-- KOLOM KIRI: FORMULIR --}}
                <div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                        <i class="fa-solid fa-envelope-open-text text-indigo-500"></i> Kirim Pesan
                    </h3>
                    
                    <form action="#" method="POST" class="space-y-5">
                        {{-- Input Nama --}}
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Lengkap</label>
                            <input type="text" id="name" name="name" required placeholder="Nama Anda"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 
                                       bg-white dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 transition">
                        </div>
                        
                        {{-- Input Email --}}
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Alamat Email</label>
                            <input type="email" id="email" name="email" required placeholder="contoh@email.com"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 
                                       bg-white dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 transition">
                        </div>
                        
                        {{-- Input Pesan --}}
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Pesan Anda</label>
                            <textarea id="message" name="message" rows="4" required placeholder="Tulis pesan Anda di sini..."
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 
                                       bg-white dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 transition"></textarea>
                        </div>
                        
                        {{-- Tombol Kirim --}}
                        <button type="submit"
                            class="w-full inline-flex justify-center items-center py-3 px-6 border border-transparent rounded-lg shadow-lg 
                                   text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 
                                   focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 
                                   transform transition hover:scale-[1.02] duration-200">
                            <i class="fa-solid fa-paper-plane mr-2"></i> Kirim Pesan
                        </button>
                    </form>
                </div>
                
                {{-- KOLOM KANAN: GOOGLE MAPS --}}
                <div class="flex flex-col h-full">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                        <i class="fa-solid fa-map-location-dot text-indigo-500"></i> Peta Lokasi
                    </h3>
                    
                    {{-- Wrapper Map dengan Border & Shadow --}}
                    <div class="flex-grow rounded-xl overflow-hidden shadow-lg border border-gray-200 dark:border-gray-600 relative min-h-[300px]">
                        <iframe 
                            src="https://maps.google.com/maps?q=-5.511520267423715,104.52149781086264&t=&z=15&ie=UTF8&iwloc=&output=embed"
                            class="absolute inset-0 w-full h-full border-0" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                    
                    <div class="mt-4 p-4 bg-indigo-50 dark:bg-gray-700/50 rounded-lg border border-indigo-100 dark:border-gray-600 text-center">
                        <p class="text-sm text-gray-600 dark:text-gray-300">
                            <i class="fa-regular fa-clock mr-1 text-indigo-600 dark:text-indigo-400"></i> Jam Operasional: 
                            <span class="font-bold text-indigo-700 dark:text-indigo-300 block sm:inline">Senin - Sabtu, 09.00 - 17.00 WIB</span>
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>