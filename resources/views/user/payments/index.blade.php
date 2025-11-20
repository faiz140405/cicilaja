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
            
            {{-- Notifikasi Sukses/Error --}}
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
                {{-- CARD WRAPPER --}}
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
                        
                        {{-- TABEL CICILAN --}}
                        <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-100 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider w-24">Periode</th>
                                        <th class="px-4 py-3 text-center text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider w-32">Jatuh Tempo</th>
                                        <th class="px-4 py-3 text-center text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider w-32">Denda</th>
                                        <th class="px-4 py-3 text-center text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider w-32">Status</th>
                                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 dark:text-gray-200 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach ($data['periods'] as $period)
                                        @php
                                            $status = $period['status'];
                                            // Logic Form Aktif: Late, Due, Rejected, Upcoming
                                            $isFormActive = in_array($status, ['due', 'late', 'rejected', 'upcoming']);
                                            
                                            $badge = match ($status) {
                                                'verified' => ['text-green-800 dark:text-green-100', 'bg-green-100 dark:bg-green-900', 'LUNAS'],
                                                'pending' => ['text-yellow-800 dark:text-yellow-100', 'bg-yellow-100 dark:bg-yellow-900', 'PENDING'],
                                                'rejected' => ['text-red-800 dark:text-red-100', 'bg-red-100 dark:bg-red-900', 'DITOLAK'],
                                                'late' => ['text-white', 'bg-red-600 dark:bg-red-700', 'TERLAMBAT'], 
                                                'due' => ['text-orange-800 dark:text-orange-100', 'bg-orange-100 dark:bg-orange-900', 'JATUH TEMPO'],
                                                'upcoming' => ['text-blue-800 dark:text-blue-100', 'bg-blue-100 dark:bg-blue-900', 'AKAN DATANG'],
                                                default => ['text-gray-800 dark:text-gray-300', 'bg-gray-100 dark:bg-gray-700', 'N/A'],
                                            };

                                            // Pesan Reminder
                                            $reminderMessage = '';
                                            // if ($status == 'due') {
                                            //     $reminderMessage = "Sisa " . $period['due_date']->diffInDays(\Carbon\Carbon::now()) . " hari";
                                            // } elseif ($status == 'late') {
                                            //     // Hitung telat berapa hari (Logic sederhana)
                                            //     $daysLate = \Carbon\Carbon::now()->diffInDays($period['due_date']); 
                                            //     $reminderMessage = "Terlambat {$daysLate} hari";
                                            // }
                                        @endphp
                                        
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40 transition-colors duration-150 
                                                   @if($status == 'verified') bg-green-50/50 dark:bg-green-900/10 @elseif($status == 'late') bg-red-50/50 dark:bg-red-900/10 @endif">
                                            
                                            {{-- PERIODE --}}
                                            <td class="px-4 py-3 whitespace-nowrap text-sm font-bold text-gray-900 dark:text-white">
                                                Periode {{ $period['period_number'] }}
                                            </td>
                                            
                                            {{-- JATUH TEMPO (Center) --}}
                                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-600 dark:text-gray-300 text-center">
                                                {{ $period['due_date']->format('d M Y') }}
                                            </td>
                                            
                                            {{-- DENDA (Center) --}}
                                            <td class="px-4 py-3 whitespace-nowrap text-sm font-bold text-center @if($period['penalty'] > 0) text-red-600 dark:text-red-400 @else text-gray-900 dark:text-gray-400 @endif">
                                                @currency($period['penalty']) 
                                            </td>
                                            
                                            {{-- STATUS (Center) --}}
                                            <td class="px-4 py-3 whitespace-nowrap text-center">
                                                <div class="flex flex-col items-center justify-center">
                                                    <span class="px-3 py-1 inline-flex text-[10px] leading-4 font-bold uppercase tracking-wide rounded-full {{ $badge[1] }} {{ $badge[0] }}">
                                                        {{ $badge[2] }}
                                                    </span>
                                                    @if ($reminderMessage)
                                                        <span class="text-[10px] mt-1 font-bold {{ $status == 'late' ? 'text-red-500 dark:text-red-400' : 'text-orange-500 dark:text-orange-400' }}">
                                                            {{ $reminderMessage }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>

                                            {{-- AKSI (Full Width Form) --}}
                                            <td class="px-4 py-3 whitespace-nowrap text-sm">
                                                @if ($status === 'verified')
                                                    <div class="flex items-center text-green-600 dark:text-green-400 font-bold bg-green-50 dark:bg-green-900/20 py-1 px-3 rounded-full w-fit">
                                                        <i class="fas fa-check-circle mr-2 text-lg"></i> Selesai
                                                    </div>
                                                @elseif ($status === 'pending')
                                                    <div class="flex items-center text-yellow-600 dark:text-yellow-400 bg-yellow-50 dark:bg-yellow-900/20 py-1 px-3 rounded-full w-fit text-xs font-medium">
                                                        <i class="fas fa-clock mr-2"></i> Verifikasi...
                                                    </div>
                                                @elseif ($isFormActive)
                                                    {{-- FORM UPLOAD COMPACT --}}
                                                    <form action="{{ route('user.payments.store', $data['submission']) }}" method="POST" enctype="multipart/form-data" class="flex items-center gap-2 w-full">
                                                        @csrf
                                                        <input type="hidden" name="period" value="{{ $period['period_number'] }}">
                                                        
                                                        {{-- Input File (Flex Grow) --}}
                                                        <div class="relative flex-grow min-w-0">
                                                            <input type="file" name="proof" required 
                                                                class="block w-full text-sm text-gray-500 dark:text-gray-300
                                                                
                                                                {{-- Base Input Style --}}
                                                                bg-gray-50 dark:bg-gray-700 
                                                                border border-gray-300 dark:border-gray-600 
                                                                rounded-lg cursor-pointer
                                                                
                                                                {{-- Focus State --}}
                                                                focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent
                                                                
                                                                {{-- File Button Style --}}
                                                                file:mr-4 file:py-2 file:px-4
                                                                file:rounded-l-lg file:border-0
                                                                file:text-xs file:font-bold
                                                                file:bg-indigo-600 dark:file:bg-indigo-500
                                                                file:text-white
                                                                
                                                                {{-- Hover Effects --}}
                                                                hover:file:bg-indigo-700 dark:hover:file:bg-indigo-600
                                                                transition-all duration-200"
                                                            />
                                                        </div>
                                                        
                                                        {{-- Tombol Kirim (Icon Only) --}}
                                                        <button type="submit" title="Kirim Pembayaran"
                                                            class="flex-shrink-0 flex items-center justify-center w-8 h-8 bg-indigo-600 dark:bg-indigo-500 text-white rounded-full hover:bg-indigo-700 dark:hover:bg-indigo-600 shadow-md transition-all duration-200 transform hover:scale-110 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                            <i class="fas fa-paper-plane text-xs"></i>
                                                        </button>
                                                    </form>
                                                    
                                                    @if ($status === 'rejected')
                                                        <p class="text-red-500 dark:text-red-400 text-[10px] mt-1 font-bold flex items-center">
                                                            <i class="fas fa-exclamation-circle mr-1"></i> Ditolak, upload ulang.
                                                        </p>
                                                    @endif
                                                    @error('proof')<p class="text-red-500 dark:text-red-400 text-[10px] mt-1">{{ $message }}</p>@enderror
                                                @else
                                                    <span class="text-gray-400 dark:text-gray-600 text-xs font-medium flex items-center">
                                                        <i class="fas fa-lock mr-1"></i> Terkunci
                                                    </span>
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
                <div class="bg-yellow-100 dark:bg-yellow-900/30 border border-yellow-400 dark:border-yellow-600 text-yellow-700 dark:text-yellow-200 px-6 py-8 rounded-lg text-center shadow-sm">
                    <i class="fas fa-info-circle text-3xl mb-2 block opacity-50"></i>
                    <p class="text-lg font-semibold">Belum ada pengajuan kredit Anda yang disetujui.</p>
                    <p class="text-sm mt-1">Silakan ajukan kredit produk terlebih dahulu.</p>
                </div>
            @endforelse

        </div>
    </div>
</x-app-layout>