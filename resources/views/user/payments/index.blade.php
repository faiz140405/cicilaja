<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center relative z-20">
            <h2 class="font-bold text-xl text-indigo-800 leading-tight">
                {{ __('Cicilan Saya') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            {{-- Notifikasi Sukses/Error --}}
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">{{ session('error') }}</div>
            @endif

            <h3 class="text-2xl font-bold text-gray-800">Daftar Cicilan Aktif ({{ count($installments) }} Pengajuan)</h3>

            @forelse ($installments as $data)
                <div class="bg-white shadow-lg sm:rounded-lg overflow-hidden border border-gray-200">
                    <div class="p-6 border-b bg-gray-50 flex justify-between items-center">
                        <div>
                            <p class="text-lg font-bold text-indigo-700">{{ $data['submission']->product->name }}</p>
                            <p class="text-sm text-gray-600">Total Tenor: {{ $data['submission']->tenor }} Bulan | Sisa: <span class="font-bold text-red-600">{{ $data['periods_left'] }} Bulan</span></p>
                        </div>
                        <span class="px-3 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-800">
                            ID Pengajuan: {{ $data['submission']->id }}
                        </span>
                    </div>

                    <div class="p-6">
                        <h4 class="text-lg font-semibold mb-4">Rincian Pembayaran (@currency($data['submission']->monthly_installment) / bulan)</h4>
                        
                        {{-- Tabel Cicilan --}}
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr class="bg-gray-50">
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Periode</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jatuh Tempo</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Denda</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($data['periods'] as $period)
                                        @php
                                            $status = $period['status'];
                                            $isFormActive = in_array($status, ['due', 'late', 'rejected']);
                                            
                                            $badge = match ($status) {
                                                'verified' => ['text-green-800', 'bg-green-100', 'LUNAS'],
                                                'pending' => ['text-yellow-800', 'bg-yellow-100', 'PENDING'],
                                                'rejected' => ['text-red-800', 'bg-red-100', 'DITOLAK'],
                                                'late' => ['text-white', 'bg-red-600', 'TERLAMBAT'], 
                                                'due' => ['text-orange-800', 'bg-orange-100', 'JATUH TEMPO'],
                                                'upcoming' => ['text-blue-800', 'bg-blue-100', 'AKAN DATANG'],
                                                default => ['text-gray-800', 'bg-gray-100', 'N/A'],
                                            };
                                        @endphp
                                        <tr @if($status == 'verified') class="bg-green-50" @elseif($status == 'late') class="bg-red-50" @endif>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">{{ $period['period_number'] }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 font-semibold">{{ $period['due_date']->format('d M Y') }}</td>
                                            
                                            {{-- Kolom Denda --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold @if($period['penalty'] > 0) text-red-600 @else text-gray-900 @endif">
                                                @currency($period['penalty']) 
                                            </td>
                                            
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badge[1] }} {{ $badge[0] }}">
                                                    {{ $badge[2] }}
                                                </span>
                                                @if ($status == 'due')
                                                    <p class="text-xs text-orange-500 mt-1 font-medium">Sisa {{ $period['due_date']->diffInDays(\Carbon\Carbon::now()) }} hari</p>
                                                @endif
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                @if ($status === 'verified')
                                                    <span class="text-green-600 font-semibold">Lunas</span>
                                                @elseif ($status === 'pending' || $status === 'pending_payoff')
                                                    <span class="text-yellow-600 italic">Menunggu Verifikasi</span>
                                                @elseif ($isFormActive)
                                                    {{-- FORM UPLOAD BUKTI --}}
                                                    <form action="{{ route('user.payments.store', $data['submission']) }}" method="POST" enctype="multipart/form-data" class="space-y-1">
                                                        @csrf
                                                        <input type="hidden" name="period" value="{{ $period['period_number'] }}">
                                                        
                                                        <input type="file" name="proof" required class="block w-full text-sm text-gray-500 file:mr-2 file:py-1 file:px-2 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"/>
                                                        
                                                        <button type="submit" class="text-xs bg-indigo-600 text-white px-3 py-1.5 rounded-lg hover:bg-indigo-700 shadow-sm transition duration-150 w-full">
                                                            Kirim Pembayaran
                                                        </button>
                                                        @if ($status === 'rejected')
                                                            <p class="text-red-500 text-xs mt-1 font-medium">Pembayaran ditolak, upload ulang.</p>
                                                        @endif
                                                    </form>
                                                    @error('proof')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                                @else
                                                    <span class="text-blue-600">Belum Aktif</span>
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