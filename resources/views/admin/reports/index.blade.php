<x-app-layout>
    <div class="py-6 transition-colors duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h3 class="text-3xl font-bold text-indigo-800 dark:text-indigo-400 mb-6 transition-colors duration-300">
                Manajemen Laporan
            </h3>
            
            {{-- STATISTIK CARDS METRIK LAPORAN --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                
                {{-- Total Pengajuan --}}
                <div class="bg-white dark:bg-gray-800 shadow-xl rounded-xl p-6 border-l-4 border-indigo-500 transition-colors duration-300">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Pengajuan</p>
                    <p class="text-3xl font-extrabold text-gray-900 dark:text-white mt-1">{{ $metrics['total_submissions'] }}</p>
                </div>
                
                {{-- Total Disetujui --}}
                <div class="bg-white dark:bg-gray-800 shadow-xl rounded-xl p-6 border-l-4 border-green-500 transition-colors duration-300">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Pengajuan Disetujui</p>
                    <p class="text-3xl font-extrabold text-green-600 dark:text-green-400 mt-1">{{ $metrics['approved_submissions'] }}</p>
                </div>
                
                {{-- Total Nilai Kredit --}}
                <div class="bg-white dark:bg-gray-800 shadow-xl rounded-xl p-6 border-l-4 border-blue-500 transition-colors duration-300">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Nilai Kredit (Disetujui)</p>
                    <p class="text-2xl font-extrabold text-blue-600 dark:text-blue-400 mt-1">@currency($metrics['total_credit_value'])</p>
                </div>
                
                {{-- Jumlah Tunggakan --}}
                <div class="bg-white dark:bg-gray-800 shadow-xl rounded-xl p-6 border-l-4 border-red-500 transition-colors duration-300">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Jumlah Tunggakan (> 30 Hari)</p>
                    <p class="text-3xl font-extrabold text-red-600 dark:text-red-400 mt-1">{{ $metrics['overdue_count'] }}</p>
                </div>
            </div>

            {{-- AKSI EXPORT --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 transition-colors duration-300 border border-gray-200 dark:border-gray-700">
                <h4 class="text-xl font-bold text-gray-800 dark:text-white mb-4">Aksi Laporan</h4>
                
                <div class="flex flex-col sm:flex-row gap-4">
                    {{-- Export ke Excel --}}
                    <a href="{{ route('admin.reports.export', ['format' => 'xlsx']) }}" 
                       class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 dark:bg-green-500 dark:hover:bg-green-600 transition duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Export ke Excel (.xlsx)
                    </a>
                    
                    {{-- Export ke PDF --}}
                    <a href="{{ route('admin.reports.export', ['format' => 'pdf']) }}" 
                       class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md shadow-sm text-white bg-blue-800 hover:bg-blue-900 dark:bg-blue-600 dark:hover:bg-blue-700 transition duration-150">
                        <i class="fas fa-file-pdf mr-2"></i> Export ke PDF
                    </a>
                </div>
                <p class="mt-4 text-sm text-gray-500 dark:text-gray-400">
                    <i class="fas fa-info-circle mr-1"></i> Laporan akan mencakup semua data pengajuan kredit yang pernah masuk ke sistem.
                </p>
            </div>
        </div>
    </div>
    @include('admin.partials.confirmation-modal')
</x-app-layout>