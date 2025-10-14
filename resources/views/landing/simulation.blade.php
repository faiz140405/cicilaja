<style>
    .wave-container {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 200px;
        overflow: hidden;
        z-index: 0;
        pointer-events: none;
    }

    .wave {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 200%;
        height: 100%;
        background-repeat: repeat-x;
        background-size: 1440px 100%;
        transform: translate3d(0, 0, 0);
    }

    .wave.wave-1 {
        background-image: url('data:image/svg+xml;utf8,<svg viewBox="0 0 1440 320" xmlns="http://www.w3.org/2000/svg"><path fill="%23e0e7ff" fill-opacity="1" d="M0,192L48,202.7C96,213,192,235,288,218.7C384,203,480,149,576,149.3C672,149,768,203,864,213.3C960,224,1056,192,1152,186.7C1248,181,1344,203,1392,213.3L1440,224L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>'); /* blue-100 */
        animation: wave-animation-1 35s linear infinite;
        opacity: 0.8;
        z-index: 3;
        height: 100%;
    }

    .wave.wave-2 {
        background-image: url('data:image/svg+xml;utf8,<svg viewBox="0 0 1440 320" xmlns="http://www.w3.org/2000/svg"><path fill="%23c7d2fe" fill-opacity="1" d="M0,160L48,170.7C96,181,192,203,288,192C384,181,480,139,576,133.3C672,128,768,160,864,181.3C960,203,1056,213,1152,208C1248,203,1344,181,1392,170.7L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>'); /* blue-200 */
        animation: wave-animation-2 25s linear infinite;
        opacity: 0.6;
        z-index: 2;
        height: 100%;
        bottom: -20px;
    }

    .wave.wave-3 {
        background-image: url('data:image/svg+xml;utf8,<svg viewBox="0 0 1440 320" xmlns="http://www.w3.org/2000/svg"><path fill="%23a5b4fc" fill-opacity="1" d="M0,128L48,144C96,160,192,192,288,192C384,192,480,160,576,160C672,160,768,192,864,192C960,192,1056,160,1152,149.3C1248,139,1344,149,1392,154.7L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>'); /* blue-300 */
        animation: wave-animation-3 18s linear infinite;
        opacity: 0.4;
        z-index: 1;
        height: 100%;
        bottom: -40px;
    }

    @keyframes wave-animation-1 {
        0% {
            background-position-x: 0;
        }
        100% {
            background-position-x: 1440px;
        }
    }

    @keyframes wave-animation-2 {
        0% {
            background-position-x: 0;
        }
        100% {
            background-position-x: -1440px; /* Arah berlawanan */
        }
    }

    @keyframes wave-animation-3 {
        0% {
            background-position-x: 0;
        }
        100% {
            background-position-x: 1440px;
        }
    }
</style>

<section id="simulasi" class="relative bg-white dark:bg-gray-900 transition duration-300 py-16">
    {{-- Container Gelombang --}}
    <div class="wave-container">
        <div class="wave wave-1"></div>
        <div class="wave wave-2"></div>
        <div class="wave wave-3"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-extrabold text-indigo-600 dark:text-white">Kalkulator Simulasi Pembayaran</h2>
            <p class="mt-4 text-lg text-gray-600 dark:text-gray-400">Belanja jadi lebih nyaman dengan cek jumlah cicilan per bulan terlebih dahulu.</p>
        </div>

        <div x-data="calculator()" class="bg-white dark:bg-gray-800 shadow-xl rounded-lg p-8 grid grid-cols-1 lg:grid-cols-2 gap-8 border border-indigo-200 dark:border-indigo-700">
            {{-- KOLOM KIRI: Hitung Estimasi --}}
            <div>
                <h3 class="text-2xl font-bold text-indigo-800 dark:text-white mb-6">Hitung Estimasi Cicilan</h3>
                
                <div class="mb-6">
                    <label for="hargaBarang" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Harga Barang</label>
                    <input type="number" id="hargaBarang" x-model.number="hargaBarang" @input="calculate" placeholder="0"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                </div>

                <div class="mb-6">
                    <label for="uangMuka" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Jumlah Uang Muka (DP)</label>
                    <input type="number" id="uangMuka" x-model.number="uangMuka" @input="calculate" placeholder="0"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tenor (bulan)</label>
                    <div class="flex space-x-3">
                        <template x-for="t in [3, 6, 12]" :key="t">
                            <button @click="tenor = t; calculate()" :class="{ 'bg-indigo-600 text-white': tenor === t, 'bg-gray-200 text-gray-700 hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600': tenor !== t }"
                                    class="px-5 py-2 rounded-lg font-medium transition duration-200">
                                <span x-text="t"></span>
                            </button>
                        </template>
                    </div>
                    <p class="text-xs text-gray-500 mt-2 dark:text-gray-400">Tenor: <span x-text="tenor"></span> bulan (Bunga flat 10%)</p>
                </div>

                <button @click="calculate()" class="w-full bg-indigo-600 text-white py-3 rounded-lg font-bold hover:bg-indigo-700 transition duration-300 shadow-lg">
                    Hitung Sekarang
                </button>
            </div>

            {{-- KOLOM KANAN: Hasil Perhitungan --}}
            <div class="bg-indigo-100 dark:bg-gray-900 p-6 rounded-lg border border-gray-200 dark:border-gray-700 flex flex-col justify-between">
                <div>
                    <h3 class="text-2xl font-bold text-indigo-800 dark:text-white mb-4">Hasil Perhitungan</h3>
                    <p class="text-gray-600 dark:text-gray-300 text-sm">Cicilan mulai dari</p>
                    <p class="text-4xl font-extrabold text-indigo-600 dark:text-indigo-400 mt-2" x-text="formatCurrency(cicilanPerBulan)"></p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Perhitungan ini hanya estimasi (bunga 10%) dan sudah termasuk biaya admin serta biaya bulanan.</p>
                </div>

                <div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between items-center text-gray-700 dark:text-gray-300 mb-2">
                        <span>Harga Barang</span>
                        <span class="font-semibold" x-text="formatCurrency(hargaBarang)"></span>
                    </div>
                    <div class="flex justify-between items-center text-gray-700 dark:text-gray-300 mb-2">
                        <span>Jumlah Uang Muka (DP)</span>
                        <span class="font-semibold" x-text="formatCurrency(uangMuka)"></span>
                    </div>
                    <div class="flex justify-between items-center text-gray-700 dark:text-gray-300">
                        <span>Jumlah Tenor (Bulan)</span>
                        <span class="font-semibold" x-text="tenor"></span>
                    </div>
                </div>

                <div class="mt-8 text-center">
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">Mau tahu jumlah cicilan yang pasti? Lakukan pengajuan melalui akun Anda.</p>
                    <a href="{{ route('register') }}" class="w-full inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-indigo-700 bg-indigo-100 hover:bg-indigo-200 dark:bg-indigo-800 dark:text-indigo-100 dark:hover:bg-indigo-700 transition duration-300 shadow-md">
                        Daftar / Masuk Sekarang
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Alpine.js untuk Kalkulator --}}
<script>
    function calculator() {
        return {
            hargaBarang: 0,
            uangMuka: 0,
            tenor: 3, // Default tenor
            cicilanPerBulan: 0,
            bunga: 0.10, // 10% flat
            biayaAdmin: 50000, // Contoh biaya admin
            biayaBulanan: 10000, // Contoh biaya bulanan

            calculate() {
                const sisaPokok = this.hargaBarang - this.uangMuka;
                if (sisaPokok <= 0 || this.tenor === 0) {
                    this.cicilanPerBulan = 0;
                    return;
                }

                const bungaPerBulan = (sisaPokok * this.bunga) / this.tenor; // Bunga flat per bulan
                this.cicilanPerBulan = (sisaPokok / this.tenor) + bungaPerBulan + (this.biayaAdmin / this.tenor) + this.biayaBulanan;
                this.cicilanPerBulan = Math.round(this.cicilanPerBulan / 100) * 100; // Pembulatan ke ratusan terdekat
            },

            formatCurrency(value) {
                if (value === 0 || value === null || isNaN(value)) {
                    return 'Rp -';
                }
                return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
            }
        }
    }
</script>