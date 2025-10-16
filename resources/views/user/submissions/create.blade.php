<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Ajukan Kredit: {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
                <h3 class="text-2xl font-bold mb-6 text-indigo-600">Detail Produk</h3>
                <div class="flex border-b pb-4 mb-6">
                    <img src="{{ asset($product->image_path ?? 'placeholder.jpg') }}" alt="{{ $product->name }}" class="w-24 h-24 object-cover rounded mr-6">
                    <div>
                        <p class="text-lg font-semibold">{{ $product->name }}</p>
                        <p class="text-sm text-gray-500">{{ $product->category->name ?? 'Kategori Lain' }}</p>
                        <p class="text-xl font-extrabold text-indigo-600 mt-2">Harga Kredit: Rp {{ number_format($product->credit_price, 0, ',', '.') }}</p>
                    </div>
                </div>

                <h3 class="text-2xl font-bold mb-6 text-indigo-600">Form Pengajuan</h3>

                <form id="submission-form" action="{{ route('user.submissions.store') }}" method="POST" x-data="{ 
                    dp: 0, 
                    tenor: {{ $tenors[0] }},
                    hargaKredit: {{ $product->credit_price }},
                    cicilanBulanan: 0,
                    totalHutang: 0,
                    
                    calculateInstallment() {
                        let sisaHarga = this.hargaKredit - this.dp;
                        let bunga = 0.10;
                        
                        if (sisaHarga < 0) {
                            alert('Uang Muka melebihi Harga Kredit!');
                            this.cicilanBulanan = 0;
                            this.totalHutang = 0;
                            return;
                        }
                        
                        this.totalHutang = sisaHarga + (sisaHarga * bunga);
                        this.cicilanBulanan = Math.ceil(this.totalHutang / this.tenor);
                    },
                    formatRupiah(number) {
                        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);
                    }
                }" @change="calculateInstallment()">

                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    
                    {{-- Input Uang Muka (DP) --}}
                    <div class="mb-6">
                        <label for="down_payment" class="block text-sm font-medium text-gray-700">Uang Muka (DP) - Maksimal Rp {{ number_format($product->credit_price, 0, ',', '.') }}</label>
                        <input type="number" name="down_payment" id="down_payment" x-model.number="dp" min="0" max="{{ $product->credit_price }}" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2.5 @error('down_payment') border-red-500 @enderror">
                        @error('down_payment')<p class="mt-1 text-sm text-green-600">{{ $message }}</p>@enderror
                    </div>

                    {{-- Pilihan Tenor (Lama Cicilan) --}}
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Lama Cicilan (Tenor dalam Bulan)</label>
                        <div class="flex space-x-4">
                            @foreach($tenors as $t)
                                <button type="button" @click="tenor = {{ $t }}; calculateInstallment();"
                                    :class="{ 'bg-indigo-600 text-white border-indigo-600': tenor === {{ $t }}, 'bg-white text-gray-700 border-gray-300 hover:border-indigo-400': tenor !== {{ $t }} }"
                                    class="px-5 py-2 border-2 rounded-lg font-semibold transition duration-200">
                                    {{ $t }} Bulan
                                </button>
                            @endforeach
                        </div>
                        <input type="hidden" name="tenor" :value="tenor">
                        @error('tenor')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    
                    {{-- Hasil Simulasi Langsung (Alpine.js) --}}
                    <div x-show="cicilanBulanan > 0" class="mt-6 p-6 bg-indigo-50 border-l-4 border-indigo-500 rounded-lg">
                        <p class="text-sm font-semibold text-indigo-700">Estimasi Cicilan Bulanan Anda</p>
                        <p class="text-3xl font-extrabold text-gray-900 mt-1" x-text="formatRupiah(cicilanBulanan)"></p>
                        <p class="text-sm text-gray-600 mt-2">Total pinjaman yang akan dicicil: <span x-text="formatRupiah(totalHutang)"></span></p>
                    </div>

                    <div class="mt-8">
                        <button type="submit" :disabled="cicilanBulanan <= 0" 
                                class="w-full bg-green-500 disabled:bg-green-400 hover:bg-green-600 text-white font-bold py-3 px-4 rounded-lg transition duration-300">
                            Kirim Pengajuan Kredit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>