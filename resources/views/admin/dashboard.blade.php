<x-app-layout>
    <div class="py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <h3 class="text-3xl font-bold text-indigo-600 mb-6">Ringkasan Sistem CicilAja</h3>
            
            {{-- AREA CHART --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-10">

                {{-- Kolom Kiri: Ringkasan Status Pengajuan (CHART) --}}
                {{-- Tambahkan height minimal untuk memastikan container tidak kolaps --}}
                <div class="lg:col-span-2 bg-white shadow-xl rounded-xl p-6 border border-gray-200" style="min-height: 400px;"> 
                    <h4 class="text-xl font-bold text-gray-500 mb-4">Status Pengajuan Kredit</h4>
                    
                    {{-- CONTAINER CHART DENGAN KETINGGIAN YANG PASTI --}}
                    <div class="relative h-72">
                        <canvas id="submissionStatusChart"></canvas>
                    </div>
                </div>
                
                {{-- Kolom Kanan: Metrik Kunci --}}
                {{-- Gunakan grid row span untuk mengisi sisa ruang --}}
                <div class="grid grid-cols-2 lg:grid-cols-1 gap-4"> 
                    
                    {{-- Total Pelanggan --}}
                    <div class="bg-white shadow-xl rounded-xl p-4 border-l-4 border-blue-500">
                        <p class="text-sm font-medium text-gray-500">Total Pelanggan</p>
                        <p class="text-2xl font-extrabold text-gray-900 mt-1">{{ $stats['total_users'] }}</p>
                    </div>

                    {{-- Pengajuan Pending --}}
                    <div class="bg-white shadow-xl rounded-xl p-4 border-l-4 border-yellow-500">
                        <p class="text-sm font-medium text-gray-500">Pengajuan Pending</p>
                        <p class="text-2xl font-extrabold text-yellow-600 mt-1">{{ $stats['pending_submissions'] }}</p>
                    </div>

                    {{-- Verifikasi Pembayaran --}}
                    <div class="bg-white shadow-xl rounded-xl p-4 border-l-4 border-red-500">
                        <p class="text-sm font-medium text-gray-500">Verifikasi Pembayaran</p>
                        <p class="text-2xl font-extrabold text-red-600 mt-1">{{ $stats['pending_payments'] }}</p>
                    </div>

                    {{-- Total Produk Aktif --}}
                    <div class="bg-white shadow-xl rounded-xl p-4 border-l-4 border-indigo-500">
                        <p class="text-sm font-medium text-gray-500">Total Produk Aktif</p>
                        <p class="text-2xl font-extrabold text-gray-900 mt-1">{{ $stats['total_products'] }}</p>
                    </div>
                </div>
            </div>

            {{-- TRANSAKSI TERBARU (Tetap sama) --}}
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h4 class="text-xl font-bold text-gray-500 mb-4">5 Pengajuan Terbaru</h4>
                
                <div class="overflow-x-auto">
                    {{-- ... (Tabel transaksi terbaru) ... --}}
                    @if (count($latestSubmissions) > 0)
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pemohon</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Diajukan</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($latestSubmissions as $submission)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $submission->user->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $submission->product->name ?? 'Produk Dihapus' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $badgeClass = [
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                'approved' => 'bg-green-100 text-green-800',
                                                'rejected' => 'bg-red-100 text-red-800',
                                                'pending_payoff' => 'bg-indigo-100 text-indigo-800',
                                            ][$submission->status] ?? 'bg-gray-100 text-gray-800';
                                        @endphp
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badgeClass }}">
                                            {{ ucfirst($submission->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $submission->created_at->diffForHumans() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                        <p class="text-center text-gray-500 py-4">Belum ada pengajuan terbaru.</p>
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
            
            // Ambil data dari PHP
            const chartData = @json($chartData);

            new Chart(ctx, {
                type: 'doughnut', 
                data: {
                    labels: chartData.labels,
                    datasets: [{
                        label: 'Jumlah Pengajuan',
                        data: chartData.data,
                        backgroundColor: chartData.colors,
                        hoverOffset: 10
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false, // <-- PENTING: Menonaktifkan rasio aspek bawaan chart
                    plugins: {
                        legend: {
                            position: 'right',
                        },
                        title: {
                            display: false,
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
