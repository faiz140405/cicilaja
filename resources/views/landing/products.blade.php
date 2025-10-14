<section id="produk" class="py-20 bg-white scroll-mt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-4xl font-extrabold text-gray-900 text-center mb-4">
            Pilihan Produk Unggulan
        </h2>
        <p class="text-center text-lg text-gray-600 mb-12">
            Pilih barang impian Anda dan hitung simulasi cicilan di bawah.
        </p>

        {{-- Grid Produk --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($products as $product)
                <div class="bg-gray-50 border border-gray-200 rounded-xl shadow-lg overflow-hidden transition duration-300 hover:shadow-xl hover:scale-[1.01]">
                    {{-- Gambar --}}
                    <div class="h-48 w-full overflow-hidden">
                        <img src="{{ asset($product->image_path ?? 'placeholder.jpg') }}" alt="{{ $product->name }}" class="w-full h-full object-cover transition duration-500 hover:scale-105">
                    </div>
                    
                    <div class="p-6">
                        {{-- Kategori & Stok --}}
                        <span class="text-xs font-semibold text-white bg-indigo-600 px-3 py-1 rounded-full inline-block mb-2">
                            {{ $product->category->name ?? 'Lainnya' }}
                        </span>
                        <span class="text-xs font-medium text-gray-500 float-right">Stok: {{ $product->stock }}</span>
                        
                        {{-- Nama Produk --}}
                        <h3 class="text-xl font-bold text-gray-900 truncate mt-1">{{ $product->name }}</h3>
                        
                        {{-- Harga --}}
                        <div class="mt-3">
                            <p class="text-sm text-gray-500 line-through">Tunai: Rp {{ number_format($product->cash_price, 0, ',', '.') }}</p>
                            <p class="text-2xl font-extrabold text-red-600 mt-1">
                                Kredit: Rp {{ number_format($product->credit_price, 0, ',', '.') }}
                            </p>
                        </div>
                        
                        {{-- Tombol Aksi --}}
                        <div class="mt-4">
                            {{-- Ganti href lama dengan route baru --}}
                            <a href="{{ route('user.submissions.create', $product) }}" class="w-full block text-center py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-indigo-600 hover:bg-indigo-600 transition duration-300">
                                Ajukan Kredit
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="md:col-span-3 text-center py-10 text-gray-500">
                    Maaf, belum ada produk yang tersedia saat ini.
                </div>
            @endforelse
        </div>
        
        @if ($products->count() > 0)
            <div class="text-center mt-10">
                <a href="{{route('products.index')}}" class="text-indigo-600 hover:text-indigo-800 font-medium">Lihat Semua Produk &rarr;</a>
            </div>
        @endif
    </div>
</section>