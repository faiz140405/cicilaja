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
</head>
<body class="font-sans antialiased text-gray-800 bg-gray-100">
    @include('layouts.navbar')

    <main class="py-7">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- HEADER HALAMAN & SORTIR --}}
            <div class="flex justify-between items-center mb-10 border-b pb-4">
                <h1 class="text-4xl font-extrabold text-indigo-800">Katalog Produk</h1>
                
                {{-- FORM SORTIR --}}
                <form method="GET" action="{{ route('products.index') }}" id="sortForm">
                    <div class="flex items-center space-x-2">
                        <label for="sort" class="text-sm font-medium text-gray-700">Urutkan:</label>
                        <select name="sort" id="sort" onchange="document.getElementById('sortForm').submit();"
                                class="rounded-md border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500">
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

                    <div class="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col justify-between h-full hover:shadow-xl transition duration-200">
                        
                        {{-- Badge Diskon --}}
                        @if ($discountPercent > 0)
                            <div class="absolute top-0 right-0 bg-red-600 text-white text-xs font-bold px-3 py-1 rounded-bl-lg z-10">
                                DISKON {{ $discountPercent }}%
                            </div>
                        @endif
                        
                        {{-- GAMBAR --}}
                        <img class="w-full h-48 object-cover object-center" 
                             src="{{ $product->image_url }}" 
                             alt="{{ $product->name }}">
                             
                        <div class="p-4 flex flex-col flex-grow">
                            
                            {{-- Kategori dan Stok --}}
                            <div class="flex justify-between items-center text-sm mb-2">
                                <span class="px-3 py-1 bg-indigo-100 text-indigo-800 rounded-full font-semibold text-xs">
                                    {{ $product->category->name ?? 'N/A' }}
                                </span>
                                <span class="text-gray-600 text-xs">Stok: {{ $product->stock }}</span>
                            </div>
                            
                            <h3 class="text-lg font-bold text-gray-900 mb-1 truncate">{{ $product->name }}</h3>
                            
                            {{-- HARGA --}}
                            <div class="mt-auto pt-2"> 
                                <p class="text-gray-500 text-xs line-through">Tunai: @currency($product->cash_price)</p>
                                
                                <p class="text-md font-bold  text-gray-600 mt-1">Kredit Mulai dari:</p>
                                <p class="text-xl font-extrabold text-indigo-600">@currency($hargaCicilanFinal)</p>
                            </div>
                        </div>
                        
                        {{-- Tombol Ajukan Kredit --}}
                        <div class="p-4 border-t border-gray-100">
                            <a href="{{ route('user.submissions.create', ['product' => $product->id, 'price' => $hargaCicilanFinal]) }}" 
                               class="w-full inline-flex items-center justify-center py-2 border border-transparent 
                                      rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 
                                      hover:bg-indigo-700 transition duration-150 ease-in-out">
                                Ajukan Kredit
                            </a>
                        </div>
                    </div>
                @empty
                    <p class="col-span-full text-gray-600 text-center py-10">Tidak ada produk yang tersedia saat ini.</p>
                @endforelse
            </div>
            
            {{-- Pagination --}}
            <div class="mt-8">
                {{ $products->links() }}
            </div>

        </div>
    </main>
    
    @include('layouts.footer')
</body>
</html>