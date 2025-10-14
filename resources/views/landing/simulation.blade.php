<section id="simulasi" class="py-20 bg-gray-50 scroll-mt-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-4xl font-extrabold text-indigo-600 dark:text-indigo-400 text-center mb-2">
            Kalkulator Simulasi Pembiayaan
        </h2>
        <p class="text-center text-md text-gray-600 mb-12">
            Belanja jadi lebih nyaman dengan cek jumlah cicilan per bulan terlebih dahulu.
        </p>

        {{-- Alpine.js State Management --}}
        <div x-data="{ 
            // Input States
            hargaBarang: 0,
            uangMuka: 0,
            lamaCicilan: 3, // Default ke 3 bulan
            
            // Result States
            sisaHarga: 0,
            bunga: 0.10, 
            totalBayar: 0,
            cicilanPerBulan: 0,
            
            // Fungsi Perhitungan (tetap sama)
            hitungCicilan() {
                if (this.hargaBarang <= 0) {
                    this.cicilanPerBulan = 0;
                    alert('Mohon masukkan Harga Barang yang valid.');
                    return;
                }
                if (this.uangMuka >= this.hargaBarang) {
                    this.cicilanPerBulan = 0;
                    alert('Uang Muka harus lebih kecil dari Harga Barang.');
                    return;
                }

                // Perhitungan
                this.sisaHarga = this.hargaBarang - this.uangMuka;
                this.totalBayar = this.sisaHarga + (this.sisaHarga * this.bunga);
                this.cicilanPerBulan = this.totalBayar / this.lamaCicilan;
            },
            
            // Format Rupiah
            formatRupiah(number) {
                if (number === 0) return 'Rp -';
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                }).format(number);
            },
            
            // Format angka biasa (untuk detail)
            formatNumber(number) {
                 if (number === 0) return 'Rp -';
                 return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                 }).format(number);
            }
        }" class="bg-white rounded-2xl shadow-2xl overflow-hidden">

            <div class="grid grid-cols-1 md:grid-cols-2">
                
                {{-- KIRI: Form Input (Hitung Estimasi Cicilan) --}}
                <div class="p-8 md:p-10">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 text-center">Hitung Estimasi Cicilan</h3>
                    
                    <div class="space-y-6">
                        {{-- Input Harga Barang --}}
                        <div>
                            <label for="harga_barang" class="sr-only">Harga Barang</label>
                            <input type="number" id="harga_barang" x-model.number="hargaBarang" @input="cicilanPerBulan = 0" placeholder="Harga Barang" min="0" 
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-150 p-3.5">
                        </div>

                        {{-- Input Uang Muka --}}
                        <div>
                            <label for="uang_muka" class="sr-only">Jumlah Uang Muka</label>
                            <input type="number" id="uang_muka" x-model.number="uangMuka" @input="cicilanPerBulan = 0" placeholder="Jumlah Uang Muka (DP)" min="0" 
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-150 p-3.5">
                        </div>

                        {{-- Pilihan Tenor (Lama Cicilan) --}}
                        <div class="pt-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Tenor (bulan)</label>
                            <div class="flex space-x-3">
                                @foreach([3, 6, 12] as $tenor)
                                    <button @click="lamaCicilan = {{ $tenor }}; cicilanPerBulan = 0;"
                                        :class="{ 'bg-indigo-500 text-white border-indigo-500': lamaCicilan === {{ $tenor }}, 'bg-white text-gray-700 border-gray-300 hover:border-indigo-500': lamaCicilan !== {{ $tenor }} }"
                                        class="px-5 py-2 border-2 rounded-lg font-semibold transition duration-200">
                                        {{ $tenor }}
                                    </button>
                                @endforeach
                            </div>
                            <p class="mt-4 text-sm font-medium text-gray-500">Tenor: <span x-text="lamaCicilan"></span> bulan (Bunga flat 10%)</p>
                        </div>
                    </div>
                    
                    {{-- Tombol Hitung --}}
                    <div class="mt-8">
                        <button @click="hitungCicilan()" type="button" 
                            class="w-full inline-flex items-center justify-center px-4 py-3 border border-transparent text-lg font-semibold rounded-lg shadow-sm text-white bg-indigo-500 hover:bg-indigo-600 focus:outline-none focus:ring-4 focus:ring-red-300 transition duration-300">
                            Hitung Sekarang
                        </button>
                    </div>
                </div>

                {{-- KANAN: Hasil Perhitungan --}}
                <div class="p-8 md:p-10 bg-gray-100 flex flex-col justify-between">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 mb-6 text-center">Hasil Perhitungan</h3>
                        
                        <div class="text-center mb-6">
                            <p class="text-md text-gray-600">Cicilan mulai dari</p>
                            {{-- Tampilan Cicilan Utama --}}
                            <p class="text-4xl md:text-5xl font-extrabold text-indigo-500 mt-1" x-text="formatRupiah(cicilanPerBulan)"></p>
                        </div>

                        <p class="text-xs text-gray-500 text-center mb-6">
                            Perhitungan ini hanya estimasi (bunga 10%) dan sudah termasuk biaya admin serta biaya bulanan.
                        </p>
                        
                        {{-- Detail Perhitungan --}}
                        <div class="text-sm font-medium text-gray-700 space-y-2 border-t pt-4">
                            <div class="flex justify-between">
                                <span>Harga Barang</span>
                                <span x-text="formatNumber(hargaBarang)">Rp -</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Jumlah Uang Muka (DP)</span>
                                <span x-text="formatNumber(uangMuka)">Rp -</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Jumlah Tenor (Bulan)</span>
                                <span x-text="lamaCicilan"> - </span>
                            </div>
                        </div>
                    </div>

                    {{-- Tombol Ajukan Sekarang --}}
                    <div class="mt-8 pt-4 border-t border-gray-300">
                        <p class="text-sm text-gray-600 mb-3 text-center">
                            Mau tahu jumlah cicilan yang pasti? Lakukan pengajuan melalui akun Anda.
                        </p>
                        <a href="{{ route('register') }}" class="w-full inline-flex items-center justify-center px-4 py-3 border border-transparent text-lg font-semibold rounded-lg shadow-md text-gray-700 bg-gray-300 hover:bg-gray-400 transition duration-300 text-center">
                            Ajukan Sekarang
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>