@csrf

{{-- ALPINE.JS UNTUK FORMAT RUPIAH --}}
<div x-data="{ 
    formatRupiah(value) {
        if (!value) return '';
        // Hapus karakter non-digit
        let number = value.replace(/[^0-9]/g, '');
        // Format ke Ribuan
        return new Intl.NumberFormat('id-ID').format(number);
    },
    // Fungsi untuk mengembalikan nilai asli (integer) saat submit
    cleanNumber(value) {
        return value.replace(/[^0-9]/g, '');
    }
}" class="space-y-6">
    
    {{-- Nama Produk --}}
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Produk</label>
        <input type="text" name="name" id="name" value="{{ old('name', $product->name ?? '') }}" required 
               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2.5 focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white @error('name') border-red-500 @enderror">
        @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    {{-- Kategori --}}
    <div>
        <label for="product_category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kategori</label>
        <select name="product_category_id" id="product_category_id" required 
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2.5 focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white @error('product_category_id') border-red-500 @enderror">
            <option value="">-- Pilih Kategori --</option>
            @foreach ($categories as $id => $name)
                <option value="{{ $id }}" {{ old('product_category_id', $product->product_category_id ?? '') == $id ? 'selected' : '' }}>
                    {{ $name }}
                </option>
            @endforeach
        </select>
        @error('product_category_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        {{-- Harga Tunai (Formatted) --}}
        <div x-data="{ displayValue: '{{ old('cash_price', $product->cash_price ?? '') }}' }" 
             x-init="displayValue = formatRupiah(displayValue)">
            
            <label for="cash_price_display" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Harga Tunai (Rp)</label>
            
            <div class="relative mt-1 rounded-md shadow-sm">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <span class="text-gray-500 sm:text-sm">Rp</span>
                </div>
                {{-- Input Tampilan (Formatted) --}}
                <input type="text" id="cash_price_display" 
                       x-model="displayValue" 
                       @input="displayValue = formatRupiah($event.target.value)"
                       class="block w-full rounded-md border-gray-300 pl-10 focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white @error('cash_price') border-red-500 @enderror" 
                       placeholder="0" required>
                
                {{-- Input Asli (Hidden Integer) --}}
                <input type="hidden" name="cash_price" :value="cleanNumber(displayValue)">
            </div>
            @error('cash_price')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        {{-- Harga Kredit (Formatted) --}}
        <div x-data="{ displayValue: '{{ old('credit_price', $product->credit_price ?? '') }}' }" 
             x-init="displayValue = formatRupiah(displayValue)">
            
            <label for="credit_price_display" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Harga Kredit Total (Rp)</label>
            
            <div class="relative mt-1 rounded-md shadow-sm">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <span class="text-gray-500 sm:text-sm">Rp</span>
                </div>
                <input type="text" id="credit_price_display" 
                       x-model="displayValue" 
                       @input="displayValue = formatRupiah($event.target.value)"
                       class="block w-full rounded-md border-gray-300 pl-10 focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white @error('credit_price') border-red-500 @enderror" 
                       placeholder="0" required>
                       
                <input type="hidden" name="credit_price" :value="cleanNumber(displayValue)">
            </div>
            @error('credit_price')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
    </div>
    
    {{-- Diskon (Percent) --}}
    <div>
        <label for="discount_percent" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Diskon (%)</label>
        <input type="number" name="discount_percent" id="discount_percent" value="{{ old('discount_percent', $product->discount_percent ?? 0) }}" min="0" max="100"
               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2.5 focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
    </div>

    {{-- Stok --}}
    <div>
        <label for="stock" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Stok</label>
        <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock ?? '') }}" required min="0" 
               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2.5 focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white @error('stock') border-red-500 @enderror">
        @error('stock')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    {{-- Deskripsi --}}
    <div>
        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi Produk</label>
        <textarea name="description" id="description" rows="3" 
                  class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2.5 focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('description', $product->description ?? '') }}</textarea>
    </div>

    {{-- Gambar Produk --}}
    <div>
        <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Gambar Produk</label>
        <input type="file" name="image" id="image" accept="image/*"
               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2.5 focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        @error('image')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror

        @if (isset($product) && $product->image_path)
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Gambar saat ini:</p>
            <img src="{{ $product->image_url }}" alt="Current Image" class="h-20 w-20 object-cover mt-1 rounded border">
        @endif
    </div>
</div>