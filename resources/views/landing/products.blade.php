<section id="produk" class="py-16 bg-gray-100 dark:bg-gray-900 transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center" data-aos="zoom-in-down">
        <h2 class="text-3xl font-extrabold text-indigo-600 dark:text-indigo-400 transition-colors duration-300">
            <i class="fa-solid fa-cube"></i> Pilihan Produk
        </h2>
        <p class="mt-4 text-lg text-gray-600 dark:text-gray-300 transition-colors duration-300">
            Pilih barang impian Anda dan hitung simulasi cicilan di bawah.
        </p>

        <div class="mt-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($products as $product)
                
                @php
                    $discountPercent = $product->discount_percent ?? 0;
                    $hargaCicilanFinal = $product->credit_price * (1 - ($discountPercent / 100));
                @endphp

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg dark:shadow-gray-700/30 overflow-hidden flex flex-col justify-between h-full transition-all duration-300 hover:shadow-xl" data-aos="zoom-in-up">
                    
                    {{-- Badge Diskon --}}
                    @if ($discountPercent > 0)
                        <div class="absolute top-0 right-0 bg-red-600 text-white text-xs font-bold px-3 py-1 rounded-bl-lg z-10 shadow-sm">
                            DISKON {{ $discountPercent }}%
                        </div>
                    @endif
                    
                    {{-- GAMBAR: Relative container untuk badge positioning jika diperlukan --}}
                    <div class="relative">
                        <img class="w-full h-48 object-cover object-center bg-gray-200 dark:bg-gray-700" 
                             src="{{ $product->image_url }}" 
                             alt="{{ $product->name }}">
                    </div>
                        
                    <div class="p-6 flex flex-col flex-grow">
                        
                        {{-- Kategori dan Stok --}}
                        <div class="flex justify-between items-center text-sm mb-3">
                            <span class="px-3 py-1 bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200 rounded-full font-semibold text-xs transition-colors duration-300">
                                {{ $product->category->name ?? 'N/A' }}
                            </span>
                            <span class="text-gray-600 dark:text-gray-400 text-xs font-medium">
                                Stok: {{ $product->stock }}
                            </span>
                        </div>
                        
                        {{-- Nama Produk --}}
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2 transition-colors duration-300">
                            {{ $product->name }}
                        </h3>
                        
                        {{-- HARGA --}}
                        <div class="mt-auto"> 
                            {{-- Harga Tunai (Coret) --}}
                            <p class="text-gray-500 dark:text-gray-500 text-sm line-through mb-1">
                                Tunai: @currency($product->cash_price)
                            </p>
                            
                            <p class="text-sm text-gray-600 dark:text-gray-400">Harga Kredit:</p>
                            {{-- Harga Kredit Final --}}
                            <p class="text-2xl font-extrabold text-indigo-600 dark:text-indigo-400 transition-colors duration-300">
                                @currency($hargaCicilanFinal)
                            </p>
                        </div>
                    </div>
                    
                    {{-- Tombol Ajukan Kredit --}}
                    <div class="p-6 border-t border-gray-100 dark:border-gray-700 transition-colors duration-300">
                        <a href="{{ route('user.submissions.create', ['product' => $product->id, 'price' => $hargaCicilanFinal]) }}" 
                           class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent 
                                  rounded-md shadow-sm text-base font-medium text-white 
                                  bg-indigo-600 hover:bg-indigo-700 
                                  dark:bg-indigo-500 dark:hover:bg-indigo-600
                                  focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 
                                  transition duration-150 ease-in-out">
                            Ajukan Kredit
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center">
                    <p class="text-gray-600 dark:text-gray-400 text-lg">Tidak ada produk yang tersedia saat ini.</p>
                </div>
            @endforelse
        </div>

        {{-- Tombol Lihat Semua --}}
        <div class="mt-12">
            <a href="{{ route('products.index') }}" class="text-lg font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 transition duration-150 flex items-center justify-center gap-2">
                Lihat Semua Produk Kami <i class="fas fa-arrow-right text-sm"></i>
            </a>
        </div>
    </div>
</section>