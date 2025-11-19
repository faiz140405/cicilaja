<x-app-layout x-data="{ openPaymentModal: false, openPayoffModal: false }">
    <x-slot name="header">
        {{-- Wrapper Flexbox --}}
        <div class="flex justify-between items-center relative z-20">
            <h2 class="font-bold text-xl text-indigo-800 dark:text-indigo-400 leading-tight transition-colors duration-300">
                Dashboard Pelanggan
            </h2>
        </div>
    </x-slot>

    <div class="py-6 p-2 transition-colors duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            {{-- Peringatan Pembayaran (Alert Box Biru - COLLAPSIBLE) --}}
            <div x-data="{ isPaymentAlertOpen: false }" class="bg-indigo-50 dark:bg-indigo-900/30 border-l-4 border-indigo-500 dark:border-indigo-400 rounded-lg overflow-hidden transition-colors duration-300">
                
                <div class="p-6 flex justify-between items-center cursor-pointer hover:bg-indigo-100 dark:hover:bg-indigo-900/50 transition" @click="isPaymentAlertOpen = !isPaymentAlertOpen">
                    <p class="font-bold text-indigo-700 dark:text-indigo-300 flex items-center gap-2">
                        <i class="fas fa-info-circle"></i> Perhatian! Metode Pembayaran Cicilan
                    </p>
                    <svg :class="{'rotate-180': isPaymentAlertOpen}" class="w-5 h-5 text-indigo-600 dark:text-indigo-400 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>

                <div x-show="isPaymentAlertOpen" x-collapse>
                    <div class="px-6 pb-6 pt-0 text-sm text-indigo-700 dark:text-indigo-200">
                        Untuk pembayaran cicilan, silakan transfer ke salah satu rekening berikut (Jatuh Tempo tgl {{ $dueDate->day }} setiap bulan):
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            @forelse ($paymentMethods as $method)
                                <li>
                                    <span class="font-bold text-indigo-800 dark:text-indigo-100">{{ $method->name }}</span> : {{ $method->account_number }} (a/n {{ $method->holder_name ?? 'PT CicilAja' }})
                                </li>
                            @empty
                                <li>Metode pembayaran belum diatur oleh Admin.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Peringatan Denda (Alert Box Merah) --}}
            @if ($isLate && $data['total_periods_left'] > 0)
                <div x-data="{ isPenaltyAlertVisible: true }" x-show="isPenaltyAlertVisible" x-transition 
                     class="bg-red-100 dark:bg-red-900/40 border border-red-400 dark:border-red-600 text-red-700 dark:text-red-200 px-4 py-4 rounded-lg relative shadow-sm">
                    <button @click="isPenaltyAlertVisible = false" class="absolute top-2 right-2 p-2 text-red-500 dark:text-red-400 hover:text-red-700 dark:hover:text-white transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                    <div class="flex items-start gap-3">
                        <i class="fas fa-exclamation-triangle text-xl mt-1"></i>
                        <div>
                            <p class="font-bold text-lg">Pembayaran Terlambat!</p>
                            <p class="text-sm mt-1">
                                Anda terlambat <span class="font-bold">{{ $daysLate }} hari</span>. Total Denda: <span class="font-bold bg-red-200 dark:bg-red-800 px-1 rounded">@currency($totalPenalty)</span>.
                                <br>Mohon segera lunasi cicilan bulan ini agar tidak terkena akumulasi denda.
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            @php
                $realTotalItemsPrice = 0;
                $realTotalPaid = 0;
                $realTotalDebtRemaining = 0;
                $realPaymentProgress = 0;
                $totalPeriodCount = 0;
                $completedPeriodCount = 0;

                foreach ($submissions as $sub) {
                    // 1. Total Harga Barang
                    $realTotalItemsPrice += $sub->product->credit_price;

                    // 2. Total yang sudah dibayar (Cicilan Terverifikasi + DP)
                    $cicilanTerbayar = $sub->payments->where('status', 'verified')->sum('amount_paid');
                    $realTotalPaid += ($cicilanTerbayar + $sub->down_payment);

                    // 3. Sisa Hutang (Harga Kredit - DP - Cicilan Terverifikasi)
                    $hutangAwal = $sub->product->credit_price - $sub->down_payment;
                    $sisaHutangItem = $hutangAwal - $cicilanTerbayar;
                    if($sisaHutangItem < 0) $sisaHutangItem = 0;
                    
                    $realTotalDebtRemaining += $sisaHutangItem;

                    // 4. Progress
                    $totalPeriodCount += $sub->tenor;
                    $completedPeriodCount += $sub->payments->where('status', 'verified')->count();
                }

                // Hitung Persentase Global
                if ($totalPeriodCount > 0) {
                    $realPaymentProgress = round(($completedPeriodCount / $totalPeriodCount) * 100);
                }
            @endphp
            
            {{-- VISUALISASI UTAMA: CHART & SUMMARY --}}
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

                {{-- Kolom Kiri: CHART --}}
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6 border border-gray-200 dark:border-gray-700 transition-colors duration-300">
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-4 flex items-center gap-2">
                        <i class="fas fa-chart-pie text-indigo-500"></i> Progres Pembayaran
                    </h3>
                    <div class="relative h-64">
                        <canvas id="paymentProgressChart"></canvas>
                    </div>
                    <p class="text-center text-sm text-gray-600 dark:text-gray-400 mt-4">
                        Total Periode: {{ $data['total_periods_completed'] + $data['total_periods_left'] }} Bulan
                    </p>
                </div>

                {{-- Kolom Kanan: CARDS --}}
                <div class="lg:col-span-3 grid grid-cols-1 md:grid-cols-3 gap-6">
                    
                    {{-- Total Harga Barang --}}
                    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6 border-l-4 border-indigo-600 dark:border-indigo-500 transition-colors duration-300">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Harga Barang</p>
                        <p class="text-xl font-extrabold text-gray-900 dark:text-white mt-1">@currency($data['total_items_price'])</p>
                    </div>

                    {{-- Total Dibayar --}}
                    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6 border-l-4 border-green-600 dark:border-green-500 transition-colors duration-300">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Sudah Dibayar</p>
                        <p class="text-xl font-extrabold text-green-600 dark:text-green-400 mt-1">@currency($data['total_paid'])</p>
                    </div>

                    {{-- Sisa Total Hutang --}}
                    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6 border-l-4 border-red-600 dark:border-red-500 relative z-10 transition-colors duration-300">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Sisa Total Hutang</p>
                        
                        {{-- MENGGUNAKAN VARIABEL HASIL HITUNGAN VIEW --}}
                        <p class="text-xl font-extrabold text-red-600 dark:text-red-400 mt-1">
                            @currency($realTotalDebtRemaining)
                        </p>
                        
                        @if ($realTotalDebtRemaining > 0)
                        <div class="mt-3">
                            <button type="button" @click.prevent="openPayoffModal = true" 
                                    class="text-xs font-bold text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 underline transition duration-150 z-20 relative">
                                Lunas Sekarang? (Hitung Pelunasan)
                            </button>
                        </div>
                        @endif
                    </div>

                    {{-- Progress Bar Linear --}}
                    <div class="lg:col-span-3 bg-indigo-50 dark:bg-gray-700/50 shadow-inner rounded-xl p-6 border border-indigo-100 dark:border-gray-600">
                        <div class="flex justify-between items-end mb-2">
                            <p class="font-bold text-gray-800 dark:text-white">Status Kelancaran</p>
                            <span class="text-sm font-semibold text-indigo-600 dark:text-indigo-400">{{ $data['payment_progress'] }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-3 overflow-hidden">
                            <div class="bg-indigo-600 dark:bg-indigo-500 h-3 rounded-full transition-all duration-1000 ease-out" 
                                 style="width: {{ $data['payment_progress'] }}%">
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2 text-right">
                            {{ $data['total_periods_left'] }} periode tersisa.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Riwayat Pembayaran (Table Component) --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-xl border border-gray-100 dark:border-gray-700 transition-colors duration-300">
                <div class="p-6">
                    <h4 class="text-xl font-bold text-gray-800 dark:text-white mb-4 border-b dark:border-gray-700 pb-2">
                        Riwayat Transaksi
                    </h4>
                    
                    {{-- Pastikan file partial riwayat_tabel juga mendukung dark mode --}}
                    @include('user.submissions.partials.riwayat_tabel', ['submissions' => $submissions])
                </div>
            </div>
        </div>
    </div>
    
    {{-- MODAL METODE PEMBAYARAN (DARK MODE SUPPORT) --}}
    <div x-cloak x-show="openPaymentModal" class="fixed inset-0 z-[60] overflow-y-auto"> 
        <div class="fixed inset-0 bg-gray-900 bg-opacity-75 backdrop-blur-sm transition-opacity z-10" @click="openPaymentModal = false"></div>
        <div class="flex items-center justify-center min-h-screen w-full p-4">
            
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-lg w-full relative z-20 transform transition-all border border-gray-200 dark:border-gray-700"
                @click.away="openPaymentModal = false"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95">
                
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">Metode Pembayaran</h3>
                        <button @click="openPaymentModal = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-white">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                    
                    <p class="text-gray-600 dark:text-gray-300 mb-6">Silakan transfer cicilan ke salah satu rekening di bawah ini:</p>

                    <div class="space-y-4 max-h-60 overflow-y-auto pr-2">
                        @foreach ($paymentMethods as $method)
                            <div class="p-4 border border-gray-200 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-700/50 hover:border-indigo-300 dark:hover:border-indigo-500 transition">
                                <div class="flex items-center gap-3">
                                    <div class="bg-indigo-100 dark:bg-indigo-900 p-2 rounded-lg">
                                        <i class="fas fa-university text-indigo-600 dark:text-indigo-400"></i>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900 dark:text-white">{{ $method->name }}</p>
                                        <p class="text-lg font-bold text-indigo-700 dark:text-indigo-300 font-mono tracking-wide">{{ $method->account_number }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase">A/N: {{ $method->holder_name ?? 'PT CicilAja' }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-8 text-right">
                        <button @click.stop="openPaymentModal = false"
                                class="px-5 py-2.5 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition font-medium">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- END MODAL --}}
    
    {{-- SCRIPT CHART.JS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const progressData = @json($progressChartData);
            const totalPeriods = progressData.lunas + progressData.tersisa;

            if (totalPeriods > 0) {
                const ctx = document.getElementById('paymentProgressChart').getContext('2d');
                
                // Cek Dark Mode dari HTML class untuk warna chart awal (opsional, chart.js canvas transparan jd aman)
                const isDark = document.documentElement.classList.contains('dark');

                new Chart(ctx, {
                    type: 'doughnut', 
                    data: {
                        labels: ['Lunas (' + progressData.lunas + ')', 'Tersisa (' + progressData.tersisa + ')'],
                        datasets: [{
                            data: [progressData.lunas, progressData.tersisa],
                            // Warna Hijau Emerald & Abu-abu (cocok di dark/light)
                            backgroundColor: ['#10b981', isDark ? '#374151' : '#d1d5db'], 
                            borderWidth: 0,
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '75%', // Membuat donat lebih tipis elegan
                        plugins: {
                            legend: { 
                                position: 'bottom',
                                labels: {
                                    color: isDark ? '#d1d5db' : '#374151', // Warna text legend adaptif
                                    font: { family: "'Figtree', sans-serif", size: 12 }
                                }
                            },
                            tooltip: {
                                backgroundColor: isDark ? '#1f2937' : '#ffffff',
                                titleColor: isDark ? '#ffffff' : '#111827',
                                bodyColor: isDark ? '#d1d5db' : '#4b5563',
                                borderColor: isDark ? '#374151' : '#e5e7eb',
                                borderWidth: 1
                            }
                        }
                    }
                });
            }
        });
    </script>
    
    @include('user.submissions.partials.payoff_modal', ['submissions' => $submissions])
</x-app-layout>