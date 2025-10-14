@csrf
<div class="space-y-6">
    {{-- Nama Produk --}}
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700">Nama Produk</label>
        <input type="text" name="name" id="name" value="{{ old('name', $product->name ?? '') }}" required 
               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2.5 @error('name') border-red-500 @enderror">
        @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    {{-- Kategori --}}
    <div>
        <label for="product_category_id" class="block text-sm font-medium text-gray-700">Kategori</label>
        <select name="product_category_id" id="product_category_id" required 
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2.5 @error('product_category_id') border-red-500 @enderror">
            <option value="">-- Pilih Kategori --</option>
            @foreach ($categories as $id => $name)
                <option value="{{ $id }}" {{ old('product_category_id', $product->product_category_id ?? '') == $id ? 'selected' : '' }}>
                    {{ $name }}
                </option>
            @endforeach
        </select>
        @error('product_category_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div class="grid grid-cols-2 gap-6">
        {{-- Harga Tunai --}}
        <div>
            <label for="cash_price" class="block text-sm font-medium text-gray-700">Harga Tunai (Rp)</label>
            <input type="number" name="cash_price" id="cash_price" value="{{ old('cash_price', $product->cash_price ?? '') }}" required min="0" 
                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2.5 @error('cash_price') border-red-500 @enderror">
            @error('cash_price')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        {{-- Harga Kredit --}}
        <div>
            <label for="credit_price" class="block text-sm font-medium text-gray-700">Harga Kredit (Total Rp)</label>
            <input type="number" name="credit_price" id="credit_price" value="{{ old('credit_price', $product->credit_price ?? '') }}" required min="0" 
                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2.5 @error('credit_price') border-red-500 @enderror">
            @error('credit_price')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
    </div>

    {{-- Stok --}}
    <div>
        <label for="stock" class="block text-sm font-medium text-gray-700">Stok</label>
        <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock ?? '') }}" required min="0" 
               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2.5 @error('stock') border-red-500 @enderror">
        @error('stock')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    {{-- Deskripsi --}}
    <div>
        <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi Produk</label>
        <textarea name="description" id="description" rows="3" 
                  class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2.5 @error('description') border-red-500 @enderror">{{ old('description', $product->description ?? '') }}</textarea>
        @error('description')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    {{-- Gambar Produk --}}
    <div>
        <label for="image" class="block text-sm font-medium text-gray-700">Gambar Produk</label>
        <input type="file" name="image" id="image" accept="image/*"
               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2.5 @error('image') border-red-500 @enderror">
        @error('image')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror

        @if (isset($product) && $product->image_path)
            <p class="mt-2 text-sm text-gray-500">Gambar saat ini:</p>
            <img src="{{ asset($product->image_path) }}" alt="Current Image" class="h-20 w-20 object-cover mt-1 rounded">
        @endif
    </div>
</div>