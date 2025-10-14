<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" /> 
<section id="kontak" class="py-20 bg-gray-50 scroll-mt-20 dark:bg-gray-800 transition duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-5xl font-extrabold text-indigo-600 dark:text-indigo-400">Hubungi Kami</h2>
            <p class="mt-3 text-lg text-gray-600 dark:text-gray-400">Kami siap membantu menjawab pertanyaan Anda.</p>
        </div>

        <div class="bg-white dark:bg-gray-700 p-8 md:p-12 rounded-xl shadow-2xl border border-gray-100 dark:border-gray-600 space-y-8">
            
            {{-- Kontak Utama Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center mb-8">
                
                {{-- CARD 1: Email --}}
                <div class="p-4 border rounded-xl shadow-sm hover:shadow-lg transition duration-200">
                    <i class="fa-solid fa-envelope text-indigo-600 mx-auto mb-3" style="font-size: 2.5rem;"></i>
                    <p class="font-semibold text-gray-900 dark:text-white">Email</p>
                    <p class="text-indigo-600 dark:text-indigo-400">cicilAja@gmail.com</p>
                </div>

                {{-- CARD 2: Telepon --}}
                <div class="p-4 border rounded-xl shadow-sm hover:shadow-lg transition duration-200">
                    <i class="fa-solid fa-phone text-indigo-600 mx-auto mb-3" style="font-size: 2.5rem;"></i>
                    <p class="font-semibold text-gray-900 dark:text-white">Telepon</p>
                    <p class="text-indigo-600 dark:text-indigo-400">+62 818 0988 4140</p>
                </div>

                {{-- CARD 3: Alamat --}}
                <div class="p-4 border rounded-xl shadow-sm hover:shadow-lg transition duration-200">
                    <i class="fa-solid fa-map-marker-alt text-indigo-600 mx-auto mb-3" style="font-size: 2.5rem;"></i>
                    <p class="font-semibold text-gray-900 dark:text-white">Alamat</p>
                    <p class="text-indigo-600 dark:text-indigo-400">Jl, Karang Rejo, Kec. Semaka, Tanggamus</p>
                </div>
            </div>

            {{-- FORMULIR DAN PETA (2 KOLOM DI LAYAR BESAR) --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 pt-8 border-t border-gray-200 dark:border-gray-600">
                
                {{-- KOLOM KIRI: FORMULIR KONTAK --}}
                <div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Kirim Pesan kepada Kami</h3>
                    <form action="#" method="POST" class="space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Lengkap</label>
                            <input type="text" id="name" name="name" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-800 dark:text-white dark:border-gray-600">
                        </div>
                        
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Alamat Email</label>
                            <input type="email" id="email" name="email" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-800 dark:text-white dark:border-gray-600">
                        </div>
                        
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pesan Anda</label>
                            <textarea id="message" name="message" rows="4" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-800 dark:text-white dark:border-gray-600"></textarea>
                        </div>
                        
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
                            src="https://maps.google.com/maps?q=Jl,%20Karang%20Rejo,%20Kec.%20Semaka,%20Tanggamus&t=&z=13&ie=UTF8&iwloc=&output=embed" 
                            width="100%" 
                            height="400" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                    <p class="mt-3 text-sm text-indigo-900 dark:text-gray-400">Silakan kunjungi kantor pusat kami pada jam kerja. <span class="font-bold text-indigo-900">Pukul 09.00 - 21.00 WIB</span></p>
                </div> 

            </div>
        </div>
    </div>
</section>