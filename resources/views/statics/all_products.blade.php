<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semua Produk | CicilAja</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-800 bg-gray-50 dark:bg-gray-900 transition duration-300">
    @include('layouts.navbar')

    <main class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <header class="text-center mb-12">
                <h1 class="text-5xl font-extrabold text-indigo-600 dark:text-indigo-400">Semua Pilihan Kredit</h1>
                <p class="mt-3 text-xl text-gray-600 dark:text-gray-400">Temukan barang impian Anda dan ajukan kredit sekarang juga.</p>
            </header>

            {{-- Grid Produk --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($products as $product)
                    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-lg overflow-hidden transition duration-300 hover:shadow-2xl hover:border-indigo-400">
                        
                        {{-- Badge Diskon --}}
                        @if ($product->discount_percent > 0)
                            <div class="absolute top-0 right-0 bg-red-600 text-white text-xs font-bold px-3 py-1 rounded-bl-lg z-10">
                                DISKON {{ $product->discount_percent }}%
                            </div>
                        @endif
                        
                        {{-- Gambar --}}
                        <div class="h-48 w-full overflow-hidden">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover transition duration-500 hover:scale-105">
                        </div>
                        
                        <div class="p-6">
                            {{-- Kategori & Stok --}}
                            <span class="text-xs font-semibold text-white bg-indigo-600 px-3 py-1 rounded-full inline-block mb-2">
                                {{ $product->category->name ?? 'Lainnya' }}
                            </span>
                            <span class="text-xs font-medium text-gray-500 float-right">Stok: {{ $product->stock }}</span>
                            
                            {{-- Nama Produk --}}
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white truncate mt-1">{{ $product->name }}</h3>
                            
                            {{-- Harga --}}
                            <div class="mt-3">
                                @php
                                    $hargaSetelahDiskon = $product->credit_price * (1 - ($product->discount_percent / 100));
                                @endphp
                                
                                @if ($product->discount_percent > 0)
                                    <p class="text-sm text-gray-500 line-through">Kredit Awal: Rp {{ number_format($product->credit_price, 0, ',', '.') }}</p>
                                @endif
                                
                                <p class="text-2xl font-extrabold text-red-600 mt-1">
                                    Kredit: Rp {{ number_format($hargaSetelahDiskon, 0, ',', '.') }}
                                </p>
                            </div>
                            
                            {{-- Tombol Aksi --}}
                            <div class="mt-4">
                                <a href="{{ route('user.submissions.create', ['product' => $product->id, 'price' => $hargaSetelahDiskon]) }}" 
                                   class="w-full block text-center py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-indigo-600 hover:bg-indigo-600 transition duration-300">
                                    Ajukan Kredit
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="lg:col-span-3 text-center py-10 text-gray-500">
                        Maaf, belum ada produk yang tersedia saat ini.
                    </div>
                @endforelse
            </div>
            
            {{-- Pagination --}}
            <div class="mt-10">
                {{ $products->links() }}
            </div>
        </div>
    </main>
    
    @include('layouts.footer')
</body>
</html>
