<x-app-layout x-data="{ openPaymentModal: false, openPayoffModal: false }">
    <x-slot name="header">
        {{-- Wrapper Flexbox untuk Menyejajarkan Header dan Tombol --}}
        <div class="flex justify-between items-center relative z-20">
            <h2 class="font-semibold text-xl text-indigo-600 leading-tight">
                Dashboard Pelanggan
            </h2>
            
            {{-- TOMBOL PEMICU MODAL --}}
            <button @click="openPaymentModal = true" 
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-bold rounded-lg shadow-md text-white bg-indigo-600 hover:bg-indigo-700 transition duration-300 z-10">
                Lihat Metode Pembayaran
            </button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            {{-- Peringatan Pembayaran (Alert Box Biru - COLLAPSIBLE) --}}
            <div x-data="{ isPaymentAlertOpen: false }" class="bg-indigo-50 border-l-4 border-indigo-500 rounded-lg overflow-hidden">
                
                <div class="p-4 flex justify-between items-center cursor-pointer" @click="isPaymentAlertOpen = !isPaymentAlertOpen">
                    <p class="font-bold text-indigo-700">
                        ⚠️ Perhatian! Metode Pembayaran Cicilan
                    </p>
                    <svg :class="{'rotate-180': isPaymentAlertOpen}" class="w-5 h-5 text-indigo-600 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>

                <div x-show="isPaymentAlertOpen" x-collapse>
                    <div class="px-4 pb-4 pt-0 text-sm text-indigo-700">
                        Untuk pembayaran cicilan, silakan transfer ke salah satu rekening berikut (Jatuh Tempo tgl {{ $dueDate->day }} setiap bulan):
                        <ul class="list-disc list-inside mt-2">
                            @forelse ($paymentMethods as $method)
                                <li>
                                    <a class="font-bold">{{ $method->name }}</a> {{ $method->account_number }} (a/n {{ $method->holder_name ?? 'PT CicilAja' }})
                                </li>
                            @empty
                                <li>Metode pembayaran belum diatur oleh Admin.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Peringatan Denda dan Keterlambatan (Alert Box Merah - DISMISSABLE) --}}
            @if ($isLate && $data['total_periods_left'] > 0)
                <div x-data="{ isPenaltyAlertVisible: true }" x-show="isPenaltyAlertVisible" x-transition class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    <button @click="isPenaltyAlertVisible = false" class="absolute top-0 right-0 p-2 text-red-500 hover:text-red-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                    <p class="font-bold">🚨 Pembayaran Terlambat!</p>
                    <p class="text-sm">
                        Anda telah terlambat {{ $daysLate }} hari dari tanggal jatuh tempo (tgl 1).
                        Total Denda saat ini: <a class="font-bold">@currency($totalPenalty).</a>
                        Mohon segera lunasi cicilan bulan ini!
                    </p>
                </div>
            @endif
            
            {{-- VISUALISASI UTAMA: CHART PROGRESS & SUMMARY --}}
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

                {{-- Kolom Kiri (lg:span-2): CHART DOUGHNUT --}}
                <div class="lg:col-span-2 bg-white shadow-xl rounded-xl p-6 border border-gray-200">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Progres Pembayaran</h3>
                    <div class="relative h-64">
                        <canvas id="paymentProgressChart"></canvas>
                    </div>
                    <p class="text-center text-sm text-gray-600 mt-4">
                        Total Periode Cicilan: {{ $data['total_periods_completed'] + $data['total_periods_left'] }}
                    </p>
                </div>

                {{-- Kolom Kanan (lg:span-3): SUMMARY CARDS --}}
                <div class="lg:col-span-3 grid grid-cols-1 md:grid-cols-3 gap-6">
                    
                    {{-- Total Harga Barang --}}
                    <div class="bg-white shadow-lg rounded-lg p-6 border-l-4 border-indigo-600">
                        <p class="text-sm font-medium text-gray-500">Total Harga Barang</p>
                        <p class="text-xl font-extrabold text-gray-900 mt-1">@currency($data['total_items_price'])</p>
                    </div>

                    {{-- Total Cicilan Dibayar --}}
                    <div class="bg-white shadow-lg rounded-lg p-6 border-l-4 border-green-600">
                        <p class="text-sm font-medium text-gray-500">Total Sudah Dibayar</p>
                        <p class="text-xl font-extrabold text-green-700 mt-1">@currency($data['total_paid'])</p>
                    </div>

                    {{-- Sisa Cicilan --}}
                    <div class="bg-white shadow-lg rounded-lg p-6 border-l-4 border-red-600 relative z-10">
                        <p class="text-sm font-medium text-gray-500">Sisa Total Hutang</p>
                        <p class="text-xl font-extrabold text-red-700 mt-1">@currency($data['total_debt_remaining'])</p>
                        
                        @if ($data['total_debt_remaining'] > 0)
                        <div class="mt-3">
                            {{-- PASTIKAN INI ADALAH BUTTON DENGAN Z-INDEX TINGGI --}}
                            <button type="button" @click.prevent="openPayoffModal = true" 
                                    class="text-xs font-bold text-red-600 hover:text-red-800 underline transition duration-150 z-20"
                                    style="z-index: 999;"> {{-- Z-INDEX EKSPISIT JIKA TERHALANG --}}
                                Lunas Sekarang? (Lihat Total)
                            </button>
                        </div>
                        @endif
                    </div>

                    {{-- Progress Bar Visual --}}
                    <div class="lg:col-span-3 bg-indigo-50 shadow-inner rounded-lg p-6">
                        <p class="font-bold text-gray-800 mb-2">Progress Pembayaran: {{ $data['payment_progress'] }}% Selesai</p>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-indigo-600 h-2.5 rounded-full transition-all duration-500" 
                                style="width: {{ $data['payment_progress'] }}%">
                            </div>
                        </div>
                        <p class="text-sm text-gray-500 mt-2">{{ $data['total_periods_left'] }} periode tersisa.</p>
                    </div>
                </div>
            </div>

            {{-- Riwayat Pembayaran dan Upload Bukti --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h4 class="text-xl font-bold text-gray-800 mb-4">Riwayat Pengajuan Kredit & Pembayaran</h4>
                    
                    @include('user.submissions.partials.riwayat_tabel', ['submissions' => $submissions])
                </div>
            </div>
        </div>
    </div>
    
    {{-- MODAL METODE PEMBAYARAN --}}
    <div x-cloak x-show="openPaymentModal" class="fixed inset-0 z-[60] overflow-y-auto"> 
    
    {{-- 1. Overlay (z-10) --}}
    <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity z-10" @click="openPaymentModal = false"></div>

    {{-- 2. Modal Content Wrapper --}}
    <div class="flex items-start justify-center min-h-screen w-full pt-16 pb-16">
        
        {{-- Konten Modal (z-20) --}}
        <div class="bg-white rounded-lg shadow-2xl max-w-lg w-full mx-4 relative z-20 transform transition-all"
            @click.away="openPaymentModal = false"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            
            <div class="p-6">
                <h3 class="text-2xl font-bold text-indigo-600 mb-4">Metode Pembayaran Cicilan</h3>
                <p class="text-gray-700 mb-6">Silakan transfer jumlah cicilan bulanan Anda ke salah satu rekening berikut:</p>

                <div class="space-y-4">
                    @foreach ($paymentMethods as $method)
                        <div class="p-4 border border-gray-200 rounded-lg bg-gray-50">
                            <p class="font-semibold text-gray-900">{{ $method->name }}</p>
                            <p class="text-lg font-extrabold text-indigo-700 mt-1">{{ $method->account_number }}</p>
                            <p class="text-sm text-gray-600">A/N: {{ $method->holder_name ?? 'PT CicilAja' }}</p>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6 text-right">
                    <button @click.stop="openPaymentModal = false" {{-- PERBAIKAN KRITIS: MENAMBAHKAN @click.stop --}}
                            class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition duration-150">
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

                new Chart(ctx, {
                    type: 'doughnut', 
                    data: {
                        labels: ['Lunas (' + progressData.lunas + ' Periode)', 'Tersisa (' + progressData.tersisa + ' Periode)'],
                        datasets: [{
                            data: [progressData.lunas, progressData.tersisa],
                            backgroundColor: ['#10b981', '#6b7280'],
                            hoverOffset: 10
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { position: 'bottom' },
                            title: { display: false }
                        }
                    }
                });
            }
        });
    </script>
    @include('user.submissions.partials.payoff_modal', ['submissions' => $submissions])
</x-app-layout>