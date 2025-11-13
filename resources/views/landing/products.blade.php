<section id="produk" class="py-16 bg-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center" data-aos="zoom-in-down">
        <h2 class="text-3xl font-extrabold text-indigo-600 dark:text-indigo-400"><i class="fa-solid fa-cube"></i> Pilihan Produk</h2>
        <p class="mt-4 text-lg text-gray-600">Pilih barang impian Anda dan hitung simulasi cicilan di bawah.</p>

        <div class="mt-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($products as $product)
                
                @php
                    $discountPercent = $product->discount_percent ?? 0;
                    $hargaCicilanFinal = $product->credit_price * (1 - ($discountPercent / 100));
                @endphp

                <div class="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col justify-between h-full" data-aos="zoom-in-up">
                    
                    {{-- Badge Diskon --}}
                    @if ($discountPercent > 0)
                        <div class="absolute top-0 right-0 bg-red-600 text-white text-xs font-bold px-3 py-1 rounded-bl-lg z-10">
                            DISKON {{ $discountPercent }}%
                        </div>
                    @endif
                    
                    {{-- GAMBAR: Menggunakan Accessor getImageUrlAttribute --}}
                    <img class="w-full h-48 object-cover object-center" 
                         src="{{ $product->image_url }}" 
                         alt="{{ $product->name }}">
                         
                    <div class="p-6 flex flex-col flex-grow">
                        
                        {{-- Kategori dan Stok --}}
                        <div class="flex justify-between items-center text-sm mb-3">
                            <span class="px-3 py-1 bg-indigo-100 text-indigo-800 rounded-full font-semibold">
                                {{ $product->category->name ?? 'N/A' }}
                            </span>
                            <span class="text-gray-600">Stok: {{ $product->stock }}</span>
                        </div>
                        
                        <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $product->name }}</h3>
                        
                        {{-- HARGA --}}
                        <div class="mt-auto"> 
                            <p class="text-gray-500 text-sm line-through mb-1">Tunai: @currency($product->cash_price)</p> {{-- Menggunakan cash_price --}}
                            
                            <p class="text-sm text-gray-600">Harga Kredit:</p>
                            <p class="text-2xl font-extrabold text-indigo-600">@currency($hargaCicilanFinal)</p>
                        </div>
                    </div>
                    
                    {{-- Tombol Ajukan Kredit --}}
                    <div class="p-6 border-t border-gray-100">
                        <a href="{{ route('user.submissions.create', ['product' => $product->id, 'price' => $hargaCicilanFinal]) }}" 
                           class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent 
                                rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 
                                hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 
                                focus:ring-indigo-500 transition duration-150 ease-in-out">
                            Ajukan Kredit
                        </a>
                    </div>
                </div>
            @empty
                <p class="col-span-full text-gray-600">Tidak ada produk yang tersedia saat ini.</p>
            @endforelse
        </div>
            <div class="mt-12">
                <a href="{{ route('products.index') }}" class="text-lg font-semibold text-indigo-600 hover:text-indigo-800 transition duration-150 flex items-center justify-center">
                    Lihat Semua Produk Kami <i class="fas fa-arrow-right ml-2 text-sm"></i>
                </a>
            </div>
    </div>
</section>