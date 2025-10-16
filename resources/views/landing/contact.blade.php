<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
<section id="kontak" class="py-20 bg-gray-50 scroll-mt-20 dark:bg-gray-800 transition duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- HEADER --}}
        <div class="text-center mb-12">
            <h2 class="text-5xl font-extrabold text-indigo-600 dark:text-indigo-400"><i class="fa-solid fa-headset"></i> Hubungi Kami</h2>
            <p class="mt-3 text-lg text-gray-600 dark:text-gray-400">Kami siap membantu menjawab pertanyaan Anda.</p>
        </div>

        <div class="bg-white dark:bg-gray-700 p-8 md:p-12 rounded-xl shadow-2xl border border-gray-100 dark:border-gray-600 space-y-10">
            
            {{-- BAGIAN 1: KONTAK UTAMA CARDS (3 Kolom di Desktop) --}}
            {{-- PERBAIKAN: Mengganti md:grid-cols-2 di baris sebelumnya menjadi md:grid-cols-3 untuk 3 cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 text-center">
                
                {{-- CARD 1: Email (Lottie Icon) --}}
                <div class="p-4 border rounded-xl shadow-sm hover:shadow-lg transition duration-200">
                    <div class="w-20 h-20 mx-auto mb-4 relative">
                        <iframe 
                            src="https://lottie.host/embed/99985857-ff0a-47b8-9a10-8a3dcdc4d005/lgRogfdVo2.lottie" {{-- LOTTIE UNTUK EMAIL --}}
                            class="absolute top-0 left-0 w-full h-full object-contain" 
                            frameborder="0" 
                            allowfullscreen 
                            scrolling="no">
                        </iframe>
                    </div>
                    <p class="font-semibold text-xl text-gray-900 dark:text-white mb-1">Email</p>
                    <a href="mailto:cicilAja@gmail.com" class="text-indigo-600 dark:text-indigo-400 hover:underline text-lg">cicilAja@gmail.com</a>
                </div>

                {{-- CARD 2: Telepon (Lottie Icon) --}}
                <div class="p-4 border rounded-xl shadow-sm hover:shadow-lg transition duration-200">
                    <div class="w-20 h-20 mx-auto mb-4 relative">
                        <iframe 
                            src="https://lottie.host/embed/cc0a2406-a97c-4efd-9360-6cdc7a2f4012/NmcZflS7n6.lottie" {{-- LOTTIE UNTUK TELEPON --}}
                            class="absolute top-0 left-0 w-full h-full object-contain" 
                            frameborder="0" 
                            allowfullscreen 
                            scrolling="no">
                        </iframe>
                    </div>
                    <p class="font-semibold text-xl text-gray-900 dark:text-white mb-1">Telepon</p>
                    <a href="tel:+6281809884140" class="text-indigo-600 dark:text-indigo-400 hover:underline text-lg">+62 818 0988 4140</a>
                </div>

                {{-- CARD 3: Alamat (Lottie Icon) --}}
                <div class="p-4 border rounded-xl shadow-sm hover:shadow-lg transition duration-300">
                    <div class="w-20 h-20 mx-auto mb-4 relative">
                        <iframe 
                            src="https://lottie.host/embed/c83b7b44-dd24-4858-ba4a-7831d5d3e5da/ICNZDMcRuQ.lottie" {{-- LOTTIE UNTUK ALAMAT --}}
                            class="absolute top-0 left-0 w-full h-full object-contain" 
                            frameborder="0" 
                            allowfullscreen 
                            scrolling="no">
                        </iframe>
                    </div>
                    <p class="font-semibold text-xl text-gray-900 dark:text-white mb-1">Alamat</p>
                    <p class="text-indigo-600 dark:text-indigo-400 text-lg">Jl, Karang Rejo, Kec. Semaka, Tanggamus</p>
                </div>
            </div>

            {{-- BAGIAN 2: FORMULIR DAN PETA (2 Kolom di Desktop) --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 pt-8 border-t border-gray-200 dark:border-gray-600">
                
                {{-- KOLOM KIRI: FORMULIR KONTAK --}}
                <div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Kirim Pesan kepada Kami</h3>
                    <form action="#" method="POST" class="space-y-4">
                        
                        {{-- Input Nama --}}
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Lengkap</label>
                            <input type="text" id="name" name="name" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-800 dark:text-white dark:border-gray-600">
                        </div>
                        
                        {{-- Input Email --}}
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Alamat Email</label>
                            <input type="email" id="email" name="email" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-800 dark:text-white dark:border-gray-600">
                        </div>
                        
                        {{-- Input Pesan --}}
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pesan Anda</label>
                            <textarea id="message" name="message" rows="4" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-800 dark:text-white dark:border-gray-600"></textarea>
                        </div>
                        
                        {{-- Tombol Kirim --}}
                        <button type="submit"
                            class="w-full inline-flex justify-center py-3 px-4 border border-transparent 
                                rounded-md shadow-sm text-base font-medium text-white 
                                bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 
                                focus:ring-offset-2 focus:ring-indigo-500 transition duration-150">
                            Kirim Pesan
                        </button>
                    </form>
                </div>
                
                {{-- KOLOM KANAN: GOOGLE MAPS --}}
                <div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Lokasi Kami</h3>
                    <div class="aspect-w-16 aspect-h-9 rounded-lg overflow-hidden shadow-xl border border-gray-300 dark:border-gray-600">
                        <iframe 
                            src="https://maps.google.com/maps?q=-5.511520267423715,104.52149781086264&t=&z=15&ie=UTF8&iwloc=&output=embed" 
                            width="100%" 
                            height="400" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                    {{-- Perbaikan styling info jam kerja --}}
                    <p class="mt-3 text-sm text-gray-500 dark:text-gray-400">Silakan kunjungi kantor pusat kami pada jam kerja: <span class="font-bold text-indigo-600 dark:text-indigo-400">Pukul 09.00 - 21.00 WIB</span></p>
                </div>

            </div>
        </div>
    </div>
</section>