<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cicilan Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            {{-- Bagian alert box, summary cards, dan progress bar di sini --}}

            <h3 class="text-2xl font-bold text-gray-800">Daftar Cicilan Aktif ({{ count($installments) }} Pengajuan)</h3>

            @forelse ($installments as $data)
                <div class="bg-white shadow-lg sm:rounded-lg overflow-hidden border border-gray-200">
                    <div class="p-6 border-b bg-gray-50 flex justify-between items-center">
                        <div>
                            <p class="text-lg font-bold text-indigo-700">{{ $data['submission']->product->name }}</p>
                            <p class="text-sm text-gray-600">Total Tenor: {{ $data['submission']->tenor }} Bulan | Sisa: <span class="font-bold text-red-600">{{ $data['periods_left'] }} Bulan</span></p>
                        </div>
                        <span class="px-3 py-1 text-sm font-semibold rounded-full 
                            @if($data['submission']->status === 'fully_paid') bg-green-500 text-white 
                            @else bg-yellow-100 text-yellow-800 
                            @endif">
                            {{ ucfirst(str_replace('_', ' ', $data['submission']->status)) }}
                        </span>
                    </div>

                    <div class="p-6">
                        <h4 class="text-lg font-semibold mb-4">Detail Pembayaran (@currency($data['submission']->monthly_installment) / bulan)</h4>
                        
                        {{-- Tabel Cicilan --}}
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr class="bg-gray-50">
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Periode</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Pembayaran</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($data['periods'] as $period)
                                        <tr @if($period['status'] == 'verified') class="bg-green-50" @endif>
                                            <td class="px-6 py-3 whitespace-nowrap text-sm font-medium">{{ $period['period_number'] }}</td>
                                            <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-700">@currency($period['amount'])</td>
                                            <td class="px-6 py-3 whitespace-nowrap">
                                                @php
                                                    $statusText = [
                                                        'verified' => 'Lunas',
                                                        'pending' => 'Menunggu Verifikasi',
                                                        'rejected' => 'Ditolak',
                                                        'due' => 'Jatuh Tempo'
                                                    ][$period['status']];
                                                    $badgeClass = [
                                                        'verified' => 'bg-green-200 text-green-900',
                                                        'pending' => 'bg-yellow-200 text-yellow-900',
                                                        'rejected' => 'bg-red-200 text-red-900',
                                                        'due' => 'bg-gray-200 text-gray-900'
                                                    ][$period['status']];
                                                @endphp
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badgeClass }}">
                                                    {{ $statusText }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-3 whitespace-nowrap text-sm">
                                                @if ($period['status'] == 'due' || $period['status'] == 'rejected')
                                                    {{-- FORM UPLOAD BUKTI (Dirapikan) --}}
                                                    <form action="{{ route('user.payments.store', $data['submission']) }}" method="POST" enctype="multipart/form-data" class="flex flex-col space-y-1">
                                                        @csrf
                                                        <input type="hidden" name="period" value="{{ $period['period_number'] }}">
                                                        
                                                        <input type="file" name="proof" required class="block w-full text-sm text-gray-500 file:mr-2 file:py-1 file:px-2 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"/>
                                                        
                                                        <button type="submit" class="w-full text-xs bg-indigo-600 text-white px-2 py-1 rounded hover:bg-indigo-700 mt-1">Kirim Pembayaran</button>
                                                        
                                                        @error('proof')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                                    </form>
                                                @elseif ($period['status'] == 'pending')
                                                    <span class="text-sm text-yellow-700">Menunggu Verifikasi</span>
                                                @else
                                                    <a href="{{ asset($payment->proof_path ?? '#') }}" target="_blank" class="text-xs text-indigo-600 hover:text-indigo-800">Lihat Bukti</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-5 rounded relative">
                    Belum ada pengajuan kredit Anda yang disetujui.
                </div>
            @endforelse

        </div>
    </div>
</x-app-layout>
