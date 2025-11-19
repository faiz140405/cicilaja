<x-app-layout>
    <style>
        @keyframes marquee {
            0% { transform: translateX(100%); }
            100% { transform: translateX(-100%); }
        }
        .marquee-container {
            max-width: 150px;
            overflow: hidden;
            white-space: nowrap;
        }
        .marquee-text {
            display: inline-block;
            animation: marquee 20s linear infinite;
        }
    </style>
    
    <div class="py-12 px-4 sm:px-6 lg:px-8 transition-colors duration-300">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <h3 class="text-3xl font-bold text-indigo-600 dark:text-indigo-400 mb-6 transition-colors duration-300">
                Ringkasan Sistem CicilAja
            </h3>
            
            {{-- AREA CHART & METRICS --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-10">

                {{-- Kolom Kiri: STATUS PENGAJUAN (CHART) --}}
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 shadow-xl rounded-xl p-6 border border-gray-200 dark:border-gray-700 transition-colors duration-300" style="min-height: 400px;"> 
                    <h4 class="text-xl font-bold text-gray-500 dark:text-gray-300 mb-4">Status Pengajuan Kredit</h4>
                    
                    <div class="relative h-72">
                        <canvas id="submissionStatusChart"></canvas>
                    </div>
                </div>
                
                {{-- Kolom Kanan: METRIK KUNCI --}}
                <div class="grid grid-cols-2 lg:grid-cols-1 gap-4"> 
                    
                    {{-- Total Pelanggan --}}
                    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-xl p-4 border-l-4 border-blue-500 transition-colors duration-300">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Pelanggan</p>
                        <p class="text-2xl font-extrabold text-gray-900 dark:text-white mt-1">{{ $stats['total_users'] }}</p>
                    </div>

                    {{-- Pengajuan Pending --}}
                    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-xl p-4 border-l-4 border-yellow-500 transition-colors duration-300">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Pengajuan Pending</p>
                        <p class="text-2xl font-extrabold text-yellow-600 dark:text-yellow-400 mt-1">{{ $stats['pending_submissions'] }}</p>
                    </div>

                    {{-- Verifikasi Pembayaran --}}
                    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-xl p-4 border-l-4 border-red-500 transition-colors duration-300">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Verifikasi Pembayaran</p>
                        <p class="text-2xl font-extrabold text-red-600 dark:text-red-400 mt-1">{{ $stats['pending_payments'] }}</p>
                    </div>

                    {{-- Total Produk Aktif --}}
                    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-xl p-4 border-l-4 border-indigo-500 transition-colors duration-300">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Produk Aktif</p>
                        <p class="text-2xl font-extrabold text-gray-900 dark:text-white mt-1">{{ $stats['total_products'] }}</p>
                    </div>
                </div>
            </div>

            {{-- TRANSAKSI TERBARU --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 border border-gray-200 dark:border-gray-700 transition-colors duration-300">
                <h4 class="text-xl font-bold text-gray-800 dark:text-white mb-4">5 Pengajuan Terbaru</h4>
                
                <div class="overflow-x-auto">
                    @if (count($latestSubmissions) > 0)
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Pemohon</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider" style="min-width: 180px;">Kontak & Lokasi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Produk</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Diajukan</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($latestSubmissions as $submission)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $submission->user->name ?? 'N/A' }}<br>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">{{ $submission->user->email ?? 'N/A' }}</span>
                                    </td>
                                    
                                    {{-- KONTAK & LOKASI --}}
                                    <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300 align-top">
                                        <div class="mb-1">
                                            <i class="fas fa-phone-alt text-xs mr-1 text-green-600 dark:text-green-400"></i> 
                                            {{ $submission->user->phone_number ?? 'Tidak Ada' }}
                                        </div>
                                        
                                        <div class="flex items-start text-xs">
                                            <i class="fas fa-map-marker-alt text-xs flex-shrink-0 mr-1 mt-1 text-red-600 dark:text-red-400"></i>
                                            <div class="marquee-container text-indigo-500 dark:text-indigo-400">
                                                <span class="marquee-text">
                                                    {{ $submission->user->address ?? 'Belum Mengisi alamat lengkap' }}
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $submission->product->name ?? 'Produk Dihapus' }}</td>
                                    
                                    {{-- STATUS --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $submissionStatus = $submission->status;
                                            $badgeClass = match ($submissionStatus) {
                                                'approved' => 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200',
                                                'pending' => 'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200',
                                                'rejected' => 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200',
                                                'pending_payoff' => 'bg-indigo-100 dark:bg-indigo-900 text-indigo-800 dark:text-indigo-200',
                                                'fully_paid' => 'bg-green-600 text-white',
                                                default => 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300',
                                            };
                                            $displayText = ucfirst(str_replace('_', ' ', $submissionStatus));
                                        @endphp
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badgeClass }}">
                                            {{ $displayText }}
                                        </span>
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $submission->created_at->diffForHumans() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                        <p class="text-center text-gray-500 dark:text-gray-400 py-4">Belum ada pengajuan terbaru.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    {{-- SCRIPT CHART.JS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('submissionStatusChart');
            const chartData = @json($chartData);

            // Deteksi Dark Mode untuk warna teks chart
            const isDark = document.documentElement.classList.contains('dark');
            const textColor = isDark ? '#d1d5db' : '#4b5563'; // gray-300 vs gray-600

            new Chart(ctx, {
                type: 'doughnut', 
                data: {
                    labels: chartData.labels,
                    datasets: [{
                        label: 'Jumlah Pengajuan',
                        data: chartData.data,
                        backgroundColor: chartData.colors,
                        borderWidth: 0, // Hilangkan border putih default agar rapi di dark mode
                        hoverOffset: 10
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                color: textColor, // Warna label adaptif
                                font: { family: "'Figtree', sans-serif" }
                            }
                        },
                        title: { display: false }
                    }
                }
            });
        });
    </script>
</x-app-layout>