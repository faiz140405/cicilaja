<section id="kontak" class="py-20 bg-gray-50 scroll-mt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-extrabold text-gray-900">Hubungi Kami</h2>
            <p class="mt-3 text-lg text-gray-600">Kami siap membantu menjawab pertanyaan Anda.</p>
        </div>

        <div class="bg-white p-8 md:p-12 rounded-xl shadow-2xl border border-gray-100 space-y-8">
            
            {{-- Kontak Utama Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
                <div class="p-6 border rounded-xl shadow-sm hover:shadow-md transition duration-200">
                    <svg class="w-10 h-10 text-indigo-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8m-2 4v7a2 2 0 01-2 2H7a2 2 0 01-2-2v-7"></path></svg>
                    <p class="font-semibold text-gray-900">Email</p>
                    <p class="text-indigo-600">cicilAja@gmail.com</p>
                </div>
                <div class="p-6 border rounded-xl shadow-sm hover:shadow-md transition duration-200">
                    <svg class="w-10 h-10 text-indigo-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.287.957l-1.673 1.673c-1.54 1.54 1.54 4.582 3.318 6.318l1.673 1.673a1 1 0 01.957-.287l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    <p class="font-semibold text-gray-900">Telepon</p>
                    <p class="text-indigo-600">+62 818-0988-4140</p>
                </div>
                <div class="p-6 border rounded-xl shadow-sm hover:shadow-md transition duration-200">
                    <svg class="w-10 h-10 text-indigo-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <p class="font-semibold text-gray-900">Alamat</p>
                    <p class="text-indigo-600">Jl, Karang Rejo, Kec. Semaka, Kabupaten Tanggamus, Lampung 35386</p>
                </div>
            </div>

            {{-- Formulir Kontak Sederhana --}}
            <div class="pt-6 border-t border-gray-100">
                <h3 class="text-2xl font-bold text-gray-900 mb-6 text-center">Kirim Pesan Langsung</h3>
                <form class="space-y-4 max-w-lg mx-auto">
                    <input type="text" placeholder="Nama Lengkap" class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    <input type="email" placeholder="Email Anda" class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    <textarea placeholder="Pesan Anda" rows="4" class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required></textarea>
                    <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3 rounded-lg hover:bg-indigo-700 transition duration-150 shadow-md">Kirim Pesan</button>
                </form>
            </div>
        </div>
    </div>
</section>
