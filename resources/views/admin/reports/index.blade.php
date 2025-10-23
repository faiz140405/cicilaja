<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h3 class="text-3xl font-bold text-indigo-800 mb-6">Manajemen Laporan</h3>
            
            {{-- STATISTIK CARDS METRIK LAPORAN --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                
                {{-- Total Pengajuan --}}
                <div class="bg-white shadow-xl rounded-xl p-6 border-l-4 border-indigo-500">
                    <p class="text-sm font-medium text-gray-500">Total Pengajuan</p>
                    <p class="text-3xl font-extrabold text-gray-900 mt-1">{{ $metrics['total_submissions'] }}</p>
                </div>
                
                {{-- Total Disetujui --}}
                <div class="bg-white shadow-xl rounded-xl p-6 border-l-4 border-green-500">
                    <p class="text-sm font-medium text-gray-500">Pengajuan Disetujui</p>
                    <p class="text-3xl font-extrabold text-green-600 mt-1">{{ $metrics['approved_submissions'] }}</p>
                </div>
                
                {{-- Total Nilai Kredit --}}
                <div class="bg-white shadow-xl rounded-xl p-6 border-l-4 border-blue-500">
                    <p class="text-sm font-medium text-gray-500">Total Nilai Kredit (Disetujui)</p>
                    {{-- Menggunakan directive @currency yang sudah dibuat --}}
                    <p class="text-2xl font-extrabold text-blue-600 mt-1">@currency($metrics['total_credit_value'])</p>
                </div>
                
                {{-- Jumlah Tunggakan --}}
                <div class="bg-white shadow-xl rounded-xl p-6 border-l-4 border-red-500">
                    <p class="text-sm font-medium text-gray-500">Jumlah Tunggakan (Pending/Ditolak > 30 Hari)</p>
                    <p class="text-3xl font-extrabold text-red-600 mt-1">{{ $metrics['overdue_count'] }}</p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h4 class="text-xl font-bold text-gray-800 mb-4">Aksi Laporan</h4>
                
                <div class="flex space-x-4">
                    {{-- Export ke Excel --}}
                    <a href="{{ route('admin.reports.export', ['format' => 'xlsx']) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 transition duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Export ke Excel (.xlsx)
                    </a>
                    
                    {{-- Export ke PDF (Placeholder, butuh instalasi DomPDF/MPDF) --}}
                    <a href="{{ route('admin.reports.export', ['format' => 'pdf']) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-white bg-blue-800 hover:bg-blue-900 transition duration-150">
                        Export ke PDF
                    </a>
                </div>
                <p class="mt-4 text-sm text-gray-500">Laporan akan mencakup semua data pengajuan kredit yang pernah masuk.</p>
            </div>
        </div>
    </div>
</x-app-layout>