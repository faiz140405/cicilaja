<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Semua Produk | CicilAja</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" type="image/cicilaja.png" href="{{ asset('images/cicilaja.png') }}">
    
    {{-- SCRIPT DARK MODE (Penting agar tidak flash putih saat refresh) --}}
    <script>
        if (localStorage.getItem('darkMode') === 'true' || (!('darkMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="font-sans antialiased text-gray-800 dark:text-gray-200 bg-gray-100 dark:bg-gray-900 transition-colors duration-300">
    
    @include('layouts.navbar') {{-- Pastikan navbar ini adalah yang sudah support dark mode --}}

    <main class="py-7">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- HEADER HALAMAN & SORTIR --}}
            <div class="flex flex-col md:flex-row justify-between items-center mb-10 border-b border-gray-200 dark:border-gray-700 pb-4 gap-4">
                <h1 class="text-3xl md:text-4xl font-extrabold text-indigo-800 dark:text-indigo-400 transition-colors duration-300">
                    Katalog Produk
                </h1>
                
                {{-- FORM SORTIR --}}
                <form method="GET" action="{{ route('products.index') }}" id="sortForm" class="w-full md:w-auto">
                    <div class="flex items-center justify-end space-x-2">
                        <label for="sort" class="text-sm font-medium text-gray-700 dark:text-gray-300">Urutkan:</label>
                        <select name="sort" id="sort" onchange="document.getElementById('sortForm').submit();"
                                class="rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-white shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500 transition-colors duration-300">
                            <option value="latest" {{ $sort == 'latest' ? 'selected' : '' }}>Terbaru</option>
                            <option value="lowest" {{ $sort == 'lowest' ? 'selected' : '' }}>Harga Termurah</option>
                            <option value="highest" {{ $sort == 'highest' ? 'selected' : '' }}>Harga Termahal</option>
                        </select>
                    </div>
                </form>
            </div>

            {{-- Grid Produk --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @forelse ($products as $product)
                    
                    @php
                        // Hitung harga setelah diskon
                        $discountPercent = $product->discount_percent ?? 0;
                        $hargaCicilanFinal = $product->credit_price * (1 - ($discountPercent / 100));
                    @endphp

                    {{-- CARD PRODUK --}}
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg dark:shadow-gray-900/50 overflow-hidden flex flex-col justify-between h-full hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border border-transparent dark:border-gray-700">
                        
                        {{-- Badge Diskon --}}
                        @if ($discountPercent > 0)
                            <div class="absolute top-0 right-0 bg-red-600 text-white text-xs font-bold px-3 py-1 rounded-bl-lg z-10 shadow-md">
                                DISKON {{ $discountPercent }}%
                            </div>
                        @endif
                        
                        {{-- GAMBAR --}}
                        <div class="relative">
                            <img class="w-full h-48 object-cover object-center bg-gray-200 dark:bg-gray-700" 
                                 src="{{ $product->image_url }}" 
                                 alt="{{ $product->name }}">
                        </div>
                             
                        <div class="p-5 flex flex-col flex-grow">
                            
                            {{-- Kategori dan Stok --}}
                            <div class="flex justify-between items-center text-sm mb-2">
                                <span class="px-3 py-1 bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200 rounded-full font-semibold text-xs transition-colors duration-300">
                                    {{ $product->category->name ?? 'N/A' }}
                                </span>
                                <span class="text-gray-600 dark:text-gray-400 text-xs font-medium">
                                    Stok: {{ $product->stock }}
                                </span>
                            </div>
                            
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1 truncate transition-colors duration-300" title="{{ $product->name }}">
                                {{ $product->name }}
                            </h3>
                            
                            {{-- HARGA --}}
                            <div class="mt-auto pt-3"> 
                                <p class="text-gray-500 dark:text-gray-500 text-xs line-through">
                                    Tunai: @currency($product->cash_price)
                                </p>
                                
                                <p class="text-xs font-bold text-gray-600 dark:text-gray-400 mt-1">Kredit Mulai dari:</p>
                                <p class="text-xl font-extrabold text-indigo-600 dark:text-indigo-400 transition-colors duration-300">
                                    @currency($hargaCicilanFinal)
                                </p>
                            </div>
                        </div>
                        
                        {{-- Tombol Ajukan Kredit --}}
                        <div class="p-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 transition-colors duration-300">
                            <a href="{{ route('user.submissions.create', ['product' => $product->id, 'price' => $hargaCicilanFinal]) }}" 
                               class="w-full inline-flex items-center justify-center py-2 border border-transparent 
                                      rounded-md shadow-sm text-sm font-medium text-white 
                                      bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600
                                      transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Ajukan Kredit
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-16">
                        <div class="inline-block p-4 rounded-full bg-gray-100 dark:bg-gray-800 mb-3">
                            <i class="fas fa-box-open text-4xl text-gray-400 dark:text-gray-500"></i>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400 text-lg">Tidak ada produk yang tersedia saat ini.</p>
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