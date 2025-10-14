<footer class="bg-gray-800 text-white mt-12 pt-10 pb-6 border-t-4 border-indigo-600 dark:bg-gray-900 transition duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 border-b border-gray-700 pb-8 mb-6">
            
            {{-- Kolom 1: Logo & Deskripsi --}}
            <div>
                <h3 class="text-3xl font-extrabold text-indigo-400 tracking-wider">
                    Cicil<span class="text-white">Aja</span>
                </h3>
                <p class="text-sm text-gray-400 mt-4">
                    Solusi kredit barang impian Anda. Proses cepat, bunga transparan. Beli sekarang, bayar nanti.
                </p>
                <div class="mt-4 flex space-x-4">
                    
                    {{-- Ikon Media Sosial (Font Awesome) --}}
                    
                    {{-- Facebook --}}
                    <a href="#" aria-label="Facebook" class="text-gray-400 hover:text-indigo-400 transition duration-150">
                        <i class="fab fa-facebook-square text-2xl"></i>
                    </a>
                    
                    {{-- Instagram --}}
                    <a href="#" aria-label="Instagram" class="text-gray-400 hover:text-indigo-400 transition duration-150">
                        <i class="fab fa-instagram text-2xl"></i>
                    </a>
                    
                    {{-- Twitter / X --}}
                    <a href="#" aria-label="Twitter" class="text-gray-400 hover:text-indigo-400 transition duration-150">
                        <i class="fab fa-twitter text-2xl"></i>
                    </a>
                    
                    {{-- LinkedIn --}}
                    <a href="#" aria-label="LinkedIn" class="text-gray-400 hover:text-indigo-400 transition duration-150">
                        <i class="fab fa-linkedin text-2xl"></i>
                    </a>
                </div>
            </div>

            {{-- Kolom 2: Navigasi Cepat --}}
            <div>
                <h4 class="text-lg font-semibold mb-4 border-b border-gray-700 pb-2">Navigasi</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('landing') }}" class="text-gray-400 hover:text-white transition duration-150">Beranda</a></li>
                    <li><a href="#produk" class="text-gray-400 hover:text-white transition duration-150">Produk</a></li>
                    <li><a href="#simulasi" class="text-gray-400 hover:text-white transition duration-150">Simulasi Kredit</a></li>
                    <li><a href="#about" class="text-gray-400 hover:text-white transition duration-150">Tentang Kami</a></li>
                    <li><a href="#kontak" class="text-gray-400 hover:text-white transition duration-150">Kontak</a></li>
                </ul>
            </div>

            {{-- Kolom 3: Layanan --}}
            <div>
                <h4 class="text-lg font-semibold mb-4 border-b border-gray-700 pb-2">Layanan Kami</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('login') }}" class="text-gray-400 hover:text-white transition duration-150">Login Mitra</a></li>
                    <li><a href="{{ route('register') }}" class="text-gray-400 hover:text-white transition duration-150">Daftar Akun Baru</a></li>
                    <li><a href="{{ route('faq') }}" class="text-gray-400 hover:text-white transition duration-150">FAQ (Tanya Jawab)</a></li>
                    <li><a href="{{ route('terms') }}" class="text-gray-400 hover:text-white transition duration-150">Syarat & Ketentuan</a></li>
                </ul>
            </div>

            {{-- Kolom 4: Kontak --}}
            <div>
                <h4 class="text-lg font-semibold mb-4 border-b border-gray-700 pb-2">Hubungi Kami</h4>
                <p class="text-sm text-gray-400 mb-2">Email: cicilAja@gmail.com</p>
                <p class="text-sm text-gray-400 mb-2">Telepon: +62 818 0988 4140</p>
                <p class="text-sm text-gray-400">Alamat: Jl, Karang Rejo, Kec. Semaka, Kabupaten Tanggamus, Lampung 35386</p>
            </div>
        </div>
        
        {{-- Copyright & Dark Mode Toggle --}}
        <div class="text-center text-gray-500 text-xs">
            &copy; {{ date('Y') }} CicilAja. Semua hak cipta dilindungi.
        </div>
    </div>
</footer>