<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center relative z-20">
            <h2 class="font-bold text-xl text-indigo-800 dark:text-indigo-400 leading-tight transition-colors duration-300">
                {{ __('Cicilan Saya') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 transition-colors duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            {{-- Notifikasi Sukses/Error (Dark Mode Compatible) --}}
            @if (session('success'))
                <div class="bg-green-100 dark:bg-green-900/50 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-200 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 dark:bg-red-900/50 border border-red-400 dark:border-red-600 text-red-700 dark:text-red-200 px-4 py-3 rounded relative">
                    {{ session('error') }}
                </div>
            @endif

            <h3 class="text-2xl font-bold text-gray-800 dark:text-white">Daftar Cicilan Aktif ({{ count($installments) }} Pengajuan)</h3>

            @forelse ($installments as $data)
                <div class="bg-white dark:bg-gray-800 shadow-lg sm:rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700 transition-colors duration-300">
                    
                    {{-- HEADER CARD --}}
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50 flex justify-between items-center">
                        <div>
                            <p class="text-lg font-bold text-indigo-700 dark:text-indigo-300">{{ $data['submission']->product->name }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Total Tenor: {{ $data['submission']->tenor }} Bulan | Sisa: <span class="font-bold text-red-600 dark:text-red-400">{{ $data['periods_left'] }} Bulan</span>
                            </p>
                        </div>
                        <span class="px-3 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                            ID: {{ $data['submission']->id }}
                        </span>
                    </div>

                    <div class="p-6">
                        <h4 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">
                            Rincian Pembayaran (@currency($data['submission']->monthly_installment) / bulan)
                        </h4>
                        
                        {{-- Tabel Cicilan --}}
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead>
                                    <tr class="bg-gray-50 dark:bg-gray-700">
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Periode</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Jatuh Tempo</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Denda</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach ($data['periods'] as $period)
                                        @php
                                            $status = $period['status'];
                                            $isFormActive = in_array($status, ['due', 'late', 'rejected']);
                                            
                                            // Update Logika Badge dengan Dark Mode Classes
                                            $badge = match ($status) {
                                                'verified' => ['text-green-800 dark:text-green-100', 'bg-green-100 dark:bg-green-900', 'LUNAS'],
                                                'pending' => ['text-yellow-800 dark:text-yellow-100', 'bg-yellow-100 dark:bg-yellow-900', 'PENDING'],
                                                'rejected' => ['text-red-800 dark:text-red-100', 'bg-red-100 dark:bg-red-900', 'DITOLAK'],
                                                'late' => ['text-white', 'bg-red-600 dark:bg-red-700', 'TERLAMBAT'], 
                                                'due' => ['text-orange-800 dark:text-orange-100', 'bg-orange-100 dark:bg-orange-900', 'JATUH TEMPO'],
                                                'upcoming' => ['text-blue-800 dark:text-blue-100', 'bg-blue-100 dark:bg-blue-900', 'AKAN DATANG'],
                                                default => ['text-gray-800 dark:text-gray-300', 'bg-gray-100 dark:bg-gray-700', 'N/A'],
                                            };
                                        @endphp
                                        
                                        {{-- Row Color Logic --}}
                                        <tr @if($status == 'verified') class="bg-green-50 dark:bg-green-900/20" @elseif($status == 'late') class="bg-red-50 dark:bg-red-900/20" @endif>
                                            
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-300">
                                                {{ $period['period_number'] }}
                                            </td>
                                            
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300 font-semibold">
                                                {{ $period['due_date']->format('d M Y') }}
                                            </td>
                                            
                                            {{-- Kolom Denda --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold @if($period['penalty'] > 0) text-red-600 dark:text-red-400 @else text-gray-900 dark:text-gray-400 @endif">
                                                @currency($period['penalty']) 
                                            </td>
                                            
                                            {{-- Kolom Status Badge --}}
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badge[1] }} {{ $badge[0] }}">
                                                    {{ $badge[2] }}
                                                </span>
                                                @if ($status == 'due')
                                                    <p class="text-xs text-orange-500 dark:text-orange-400 mt-1 font-medium">
                                                        Sisa {{ $period['due_date']->diffInDays(\Carbon\Carbon::now()) }} hari
                                                    </p>
                                                @endif
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                @if ($status === 'verified')
                                                    <span class="text-green-600 dark:text-green-400 font-semibold">Lunas</span>
                                                
                                                @elseif ($status === 'pending' || $status === 'pending_payoff')
                                                    <span class="text-yellow-600 dark:text-yellow-400 italic">Menunggu Verifikasi</span>
                                                
                                                @elseif ($isFormActive)
                                                    {{-- FORM UPLOAD BUKTI --}}
                                                    <form action="{{ route('user.payments.store', $data['submission']) }}" method="POST" enctype="multipart/form-data" class="space-y-1">
                                                        @csrf
                                                        <input type="hidden" name="period" value="{{ $period['period_number'] }}">
                                                        
                                                        {{-- Input File Custom Style --}}
                                                        <input type="file" name="proof" required 
                                                            class="block w-full text-sm text-gray-500 dark:text-gray-400 
                                                            file:mr-2 file:py-1 file:px-2 file:rounded-lg file:border-0 
                                                            file:text-xs file:font-semibold 
                                                            file:bg-indigo-50 dark:file:bg-indigo-900 
                                                            file:text-indigo-700 dark:file:text-indigo-200
                                                            hover:file:bg-indigo-100 dark:hover:file:bg-indigo-800"/>
                                                        
                                                        <button type="submit" class="text-xs bg-indigo-600 dark:bg-indigo-500 text-white px-3 py-1.5 rounded-lg hover:bg-indigo-700 dark:hover:bg-indigo-600 shadow-sm transition duration-150 w-full">
                                                            Kirim Pembayaran
                                                        </button>
                                                        @if ($status === 'rejected')
                                                            <p class="text-red-500 dark:text-red-400 text-xs mt-1 font-medium">Pembayaran ditolak, upload ulang.</p>
                                                        @endif
                                                    </form>
                                                    @error('proof')<p class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                                                @else
                                                    <span class="text-blue-600 dark:text-blue-400">Belum Aktif</span>
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
                <div class="bg-yellow-100 dark:bg-yellow-900/30 border border-yellow-400 dark:border-yellow-600 text-yellow-700 dark:text-yellow-200 px-4 py-5 rounded relative">
                    Belum ada pengajuan kredit Anda yang disetujui.
                </div>
            @endforelse

        </div>
    </div>
</x-app-layout>