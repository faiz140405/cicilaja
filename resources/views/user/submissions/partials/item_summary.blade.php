@php
    // Variabel $submission harus tersedia di partial ini
    // Menggunakan accessor periods_left yang sudah ada
    $periodsCompleted = $submission->tenor - $submission->periods_left;
    $totalPeriods = $submission->tenor;
    $isFullyPaid = $submission->periods_left <= 0; // Kunci untuk LUNAS
    $progress = $totalPeriods > 0 ? ($periodsCompleted / $totalPeriods) * 100 : 0;
    
    // Perhitungan finansial
    // Asumsi: totalPaid dan sisaHutang sudah benar dari Controller/Model accessor
    $totalPaid = ($submission->monthly_installment * $periodsCompleted) + $submission->down_payment;
    $sisaHutang = $submission->payoff_amount; // Menggunakan Payoff Amount sebagai sisa hutang saat ini
    
    $statusClass = $isFullyPaid ? 'border-green-600' : 'border-yellow-600';
@endphp

<div class="mt-4 mb-6 p-4 rounded-lg bg-gray-50 border {{ $statusClass }} border-l-4 shadow-sm">
    <h5 class="text-lg font-bold text-gray-800 flex justify-between items-center">
        <span>Barang: {{ $submission->product->name ?? 'N/A' }}</span>
        
        {{-- BADGE STATUS --}}
        <span class="text-sm font-semibold px-3 py-1 rounded-full text-white 
            {{ $submission->periods_left > 0 ? 'bg-yellow-500' : 'bg-green-600' }}">
            {{ $submission->periods_left > 0 ? 'Aktif' : 'LUNAS' }}
        </span>
    </h5>
    
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-3 text-center border-b pb-3">
        
        {{-- Total Harga Kredit --}}
        <div>
            <p class="text-xs text-gray-500">Harga Kredit</p>
            <p class="font-bold text-sm text-indigo-600">@currency($submission->product->credit_price)</p>
        </div>

        {{-- DP --}}
        <div>
            <p class="text-xs text-gray-500">Uang Muka</p>
            <p class="font-bold text-sm">@currency($submission->down_payment)</p>
        </div>

        {{-- Sudah Dibayar --}}
        <div>
            <p class="text-xs text-gray-500">Total Dibayar</p>
            <p class="font-bold text-sm text-green-600">@currency($totalPaid)</p>
        </div>

        {{-- Sisa Hutang --}}
        <div>
            <p class="text-xs text-gray-500">Sisa Hutang</p>
            <p class="font-bold text-sm text-red-600">@currency($sisaHutang)</p>
        </div>
    </div>
    
    {{-- Progress Bar Individual --}}
    <div class="mt-3">
        <p class="text-sm font-semibold text-gray-800 mb-1">Progress: {{ round($progress, 1) }}% ({{ $periodsCompleted }} dari {{ $totalPeriods }} Periode)</p>
        <div class="w-full bg-gray-200 rounded-full h-2">
            <div class="bg-indigo-600 h-2 rounded-full transition-all duration-500" 
                 style="width: {{ $progress }}%">
            </div>
        </div>
    </div>
</div>