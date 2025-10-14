@php
    // Inisialisasi Carbon dan window pembayaran
    use Carbon\Carbon;
    $today = Carbon::now();
    $paymentWindowStartDay = 20; // Tanggal mulai jendela pembayaran
@endphp

@forelse ($submissions as $submission)
    
    {{-- 1. Tampilkan Summary Card per Barang --}}
    @include('user.submissions.partials.item_summary', ['submission' => $submission])

    {{-- 2. Rincian Tabel Cicilan --}}
    <h6 class="text-lg font-semibold text-gray-700 mt-6 mb-3">Rincian Pembayaran per Periode</h6>
    
    <div class="overflow-x-auto mb-10 border rounded-lg shadow-md">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Periode</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jatuh Tempo</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Denda</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                
                @for ($i = 1; $i <= $submission->tenor; $i++)
                    @php
                        // Hitung tanggal jatuh tempo spesifik untuk periode $i
                        $firstDueDate = Carbon::parse($submission->created_at)
                            ->addMonth()
                            ->day(1)
                            ->startOfDay();
                        
                        $periodDueDate = $firstDueDate->copy()->addMonths($i - 1);
                        
                        // Cek apakah ada pembayaran untuk periode ini
                        $payment = $submission->payments->firstWhere('period', $i);
                        $status = 'upcoming'; 
                        $penaltyAmount = 0; // Inisialisasi Denda
                        $daysLate = 0;

                        if ($payment) {
                            $status = $payment->status;
                        } elseif ($today->greaterThan($periodDueDate)) {
                            // 1. TERLAMBAT
                            $status = 'late';
                            $daysLate = $today->diffInDays($periodDueDate);
                            $penaltyAmount = $daysLate * 5000; // Hitung Denda
                        } elseif ($today->greaterThanOrEqualTo($periodDueDate->copy()->subMonth()->day($paymentWindowStartDay)) && $today->lessThan($periodDueDate)) {
                            // 2. JATUH TEMPO (DUE/REMINDER)
                            $status = 'due';
                        }
                        
                        // Set badge berdasarkan status
                        $badge = match ($status) {
                            'verified' => ['text-green-800', 'bg-green-100', 'LUNAS'],
                            'pending' => ['text-yellow-800', 'bg-yellow-100', 'PENDING'],
                            'rejected' => ['text-red-800', 'bg-red-100', 'DITOLAK'],
                            'late' => ['text-white', 'bg-red-600', 'TERLAMBAT'], 
                            'due' => ['text-orange-800', 'bg-orange-100', 'JATUH TEMPO'],
                            'upcoming' => ['text-blue-800', 'bg-blue-100', 'AKAN DATANG'],
                            default => ['text-gray-800', 'bg-gray-100', 'AKAN DATANG'], 
                        };
                        
                        $reminderMessage = ($status === 'due') ? "Sisa: " . $today->diffInDays($periodDueDate, false) . " hari" : '';
                        
                        // Form hanya aktif untuk status: late, due, rejected
                        $isFormActive = in_array($status, ['late', 'due', 'rejected']);
                    @endphp

                    <tr @if($status === 'verified') class="bg-green-50" @endif>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Periode {{ $i }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-600">{{ $periodDueDate->format('d M Y') }}</td>
                        
                        {{-- Kolom Denda --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold @if($penaltyAmount > 0) text-red-600 @else text-gray-900 @endif">
                            @currency($penaltyAmount) {{-- Tampilkan Denda yang dihitung --}}
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badge[1] }} {{ $badge[0] }}">
                                {{ $badge[2] }}
                            </span>
                            @if ($reminderMessage)
                                <p class="text-xs text-orange-500 mt-1 font-semibold">Segera bayar. {{ $reminderMessage }}</p>
                            @endif
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @if ($status === 'verified')
                                <span class="text-green-600 font-semibold">Selesai</span>
                            @elseif ($status === 'pending')
                                <span class="text-yellow-600 italic">Menunggu Verifikasi</span>
                            @elseif ($isFormActive)
                                {{-- FORM UPLOAD BUKTI (Aktif hanya jika late, due, rejected) --}}
                                <form action="{{ route('user.payments.store', $submission) }}" method="POST" enctype="multipart/form-data" class="space-y-1">
                                    @csrf
                                    <input type="hidden" name="period" value="{{ $i }}">
                                    
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
                @endfor
            </tbody>
        </table>
    </div>
    
@empty
    <div class="px-6 py-4 text-center text-gray-500 border rounded-lg">
        Anda belum memiliki riwayat pengajuan kredit yang disetujui.
    </div>
@endforelse