<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-indigo-400 leading-tight transition-colors duration-300">
            Ajukan Kredit: {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-12 transition-colors duration-300">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-8 border border-gray-200 dark:border-gray-700 transition-colors duration-300">
                
                {{-- DETAIL PRODUK --}}
                <h3 class="text-2xl font-bold mb-6 text-indigo-600 dark:text-indigo-400">Detail Produk</h3>
                <div class="flex border-b border-gray-200 dark:border-gray-700 pb-4 mb-6">
                    <img src="{{ asset($product->image_path ?? 'placeholder.jpg') }}" alt="{{ $product->name }}" class="w-24 h-24 object-cover rounded mr-6 bg-gray-200 dark:bg-gray-700">
                    <div>
                        <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $product->name }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $product->category->name ?? 'Kategori Lain' }}</p>
                        <p class="text-xl font-extrabold text-indigo-600 dark:text-indigo-400 mt-2">
                            Harga Kredit: Rp {{ number_format($product->credit_price, 0, ',', '.') }}
                        </p>
                    </div>
                </div>

                <h3 class="text-2xl font-bold mb-6 text-indigo-600 dark:text-indigo-400">Form Pengajuan</h3>

                <form id="submission-form" action="{{ route('user.submissions.store') }}" method="POST" x-data="{ 
                    dp: {{ old('down_payment', 0) }}, 
                    formattedDp: 'Rp 0',
                    tenor: {{ old('tenor', $tenors[0]) }},
                    hargaKredit: {{ $product->credit_price }},
                    cicilanBulanan: 0,
                    totalHutang: 0,
                    showErrorModal: false, // STATE UNTUK MODAL ERROR
                    
                    init() {
                        this.formattedDp = 'Rp ' + new Intl.NumberFormat('id-ID').format(this.dp);
                        this.calculateInstallment();
                    },

                    updateDp(value) {
                        let numberString = value.replace(/[^0-9]/g, '').toString();
                        let number = parseInt(numberString) || 0;

                        // VALIDASI MAX DENGAN MODAL
                        if (number > this.hargaKredit) {
                            this.showErrorModal = true; // Tampilkan Modal
                            number = this.hargaKredit;  // Reset ke nilai maksimal
                        }

                        this.dp = number;
                        this.formattedDp = 'Rp ' + new Intl.NumberFormat('id-ID').format(number);
                        this.calculateInstallment();
                    },
                    
                    calculateInstallment() {
                        let sisaHarga = this.hargaKredit - this.dp;
                        let bunga = 0.10; 
                        
                        if (sisaHarga < 0) {
                            this.dp = 0;
                            this.formattedDp = 'Rp 0';
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
                }" x-init="init()"> 

                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    
                    {{-- Input Uang Muka (DP) --}}
                    <div class="mb-6">
                        <label for="down_payment_display" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Uang Muka (DP) - Maksimal Rp {{ number_format($product->credit_price, 0, ',', '.') }}
                        </label>
                        
                        <input type="text" 
                               id="down_payment_display" 
                               x-model="formattedDp"
                               @input="updateDp($event.target.value)"
                               class="mt-1 block w-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 rounded-md shadow-sm p-2.5 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-300"
                               placeholder="Rp 0"
                        >

                        <input type="hidden" name="down_payment" :value="dp">
                        @error('down_payment')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    {{-- Pilihan Tenor --}}
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Lama Cicilan (Tenor dalam Bulan)</label>
                        <div class="flex flex-wrap gap-3">
                            @foreach($tenors as $t)
                                <button type="button" @click="tenor = {{ $t }}; calculateInstallment();"
                                    :class="{ 
                                        'bg-indigo-600 text-white border-indigo-600 dark:bg-indigo-500 dark:border-indigo-500': tenor === {{ $t }}, 
                                        'bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 border-gray-300 dark:border-gray-600 hover:border-indigo-400 dark:hover:border-indigo-400': tenor !== {{ $t }} 
                                    }"
                                    class="px-5 py-2 border-2 rounded-lg font-semibold transition duration-200">
                                    {{ $t }} Bulan
                                </button>
                            @endforeach
                        </div>
                        <input type="hidden" name="tenor" :value="tenor">
                        @error('tenor')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    
                    {{-- Hasil Simulasi --}}
                    <div x-show="cicilanBulanan > 0" 
                         class="mt-6 p-6 bg-indigo-50 dark:bg-indigo-900/30 border-l-4 border-indigo-500 dark:border-indigo-400 rounded-lg transition-colors duration-300">
                        <p class="text-sm font-semibold text-indigo-700 dark:text-indigo-300">Estimasi Cicilan Bulanan Anda</p>
                        <p class="text-3xl font-extrabold text-gray-900 dark:text-white mt-1" x-text="formatRupiah(cicilanBulanan)"></p>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                            Total pinjaman yang akan dicicil: <span x-text="formatRupiah(totalHutang)"></span> (Termasuk Bunga)
                        </p>
                    </div>

                    <div class="mt-8">
                        <button type="submit" :disabled="cicilanBulanan <= 0" 
                                class="w-full bg-green-600 hover:bg-green-700 dark:bg-green-500 dark:hover:bg-green-600 disabled:bg-green-400 dark:disabled:bg-green-800/50 text-white font-bold py-3 px-4 rounded-lg transition duration-300 shadow-md">
                            Kirim Pengajuan Kredit
                        </button>
                    </div>

                    {{-- MODAL ERROR CUSTOM --}}
                    <div x-show="showErrorModal" style="display: none;" x-cloak 
                         class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-75 backdrop-blur-sm transition-opacity"
                         x-transition:enter="ease-out duration-300"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         x-transition:leave="ease-in duration-200"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0">
                        
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-6 w-full max-w-sm border border-gray-200 dark:border-gray-700 transform transition-all"
                             @click.away="showErrorModal = false"
                             x-transition:enter="ease-out duration-300"
                             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                             x-transition:leave="ease-in duration-200"
                             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
        
                            <div class="text-center">
                                <div class="mx-auto flex items-center justify-center h-10 w-10 rounded-full bg-red-100 dark:bg-red-900/30 mb-4">
                                    <i class="fas fa-exclamation-triangle text-red-600 dark:text-red-400 text-2xl"></i>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Perhatian!</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-300">
                                    Uang Muka tidak boleh melebihi Harga Kredit barang.
                                </p>
                            </div>
        
                            <div class="mt-6">
                                <button @click="showErrorModal = false" type="button"
                                    class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2.5 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:text-sm transition-colors">
                                    Oke, Saya Mengerti
                                </button>
                            </div>
                        </div>
                    </div>
                    {{-- END MODAL --}}

                </form>
            </div>
        </div>
    </div>
</x-app-layout>