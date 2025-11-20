<div class="space-y-8">
    @forelse ($submissions as $submission)
        {{-- CARD WRAPPER --}}
        <div class="border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden shadow-sm bg-white dark:bg-gray-800 transition-colors duration-300">
            
            {{-- HEADER CARD: INFO BARANG --}}
            <div class="p-6 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                <div class="flex justify-between items-start">
                    <div>
                        <h4 class="text-lg font-bold text-gray-900 dark:text-white">
                            Barang: <span class="text-indigo-600 dark:text-indigo-400">{{ $submission->product->name }}</span>
                        </h4>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">ID Pengajuan: {{ $submission->id }}</p>
                    </div>
                    
                    {{-- Badge Status Utama --}}
                    @php
                        $mainStatus = $submission->status;
                        $mainBadge = match($mainStatus) {
                            'approved' => 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200',
                            'pending' => 'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200',
                            'rejected' => 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200',
                            'fully_paid' => 'bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200',
                            default => 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300'
                        };
                    @endphp
                    <span class="px-3 py-1 text-xs font-bold rounded-full {{ $mainBadge }}">
                        {{ ucfirst(str_replace('_', ' ', $mainStatus)) }}
                    </span>
                </div>

                {{-- STATISTIK RINGKAS --}}
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6 text-center">
                    
                    {{-- 1. Harga Kredit --}}
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-semibold">Harga Kredit</p>
                        <p class="text-sm font-bold text-indigo-600 dark:text-indigo-400">
                            @currency($submission->product->credit_price)
                        </p>
                    </div>

                    {{-- 2. Uang Muka --}}
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-semibold">Uang Muka</p>
                        <p class="text-sm font-bold text-gray-800 dark:text-gray-200">
                            @currency($submission->down_payment)
                        </p>
                    </div>

                    {{-- 3. Total Dibayar --}}
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-semibold">Total Dibayar</p>
                        @php
                            // Hitung jumlah cicilan yang statusnya 'verified'
                            $totalInstallmentPaid = $submission->payments->where('status', 'verified')->sum('amount_paid');
                        @endphp
                        <p class="text-sm font-bold text-green-600 dark:text-green-400">
                            @currency($totalInstallmentPaid)
                        </p>
                    </div>

                    {{-- 4. Sisa Hutang (PERBAIKAN DISINI) --}}
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-semibold">Sisa Hutang</p>
                        @php
                            // Rumus: (Harga Kredit - DP) - (Total Cicilan yang sudah dibayar)
                            $totalDebt = $submission->product->credit_price - $submission->down_payment;
                            $remaining = $totalDebt - $totalInstallmentPaid;

                            // Jaga-jaga agar tidak minus
                            if($remaining < 0) $remaining = 0;
                        @endphp
                        <p class="text-sm font-bold text-red-600 dark:text-red-400">
                            @currency($remaining)
                        </p>
                    </div>
                </div>

                {{-- PROGRESS BAR --}}
                <div class="mt-6">
                    @php
                        $verifiedCount = $submission->payments->where('status', 'verified')->count();
                        $totalTenor = $submission->tenor;
                        $percent = ($totalTenor > 0) ? ($verifiedCount / $totalTenor) * 100 : 0;
                    @endphp
                    <div class="flex justify-between text-xs mb-1">
                        <span class="font-semibold text-gray-600 dark:text-gray-300">Progress: {{ round($percent) }}% ({{ $verifiedCount }} dari {{ $totalTenor }} Periode)</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2.5">
                        <div class="bg-indigo-600 dark:bg-indigo-500 h-2.5 rounded-full transition-all duration-500" style="width: {{ $percent }}%"></div>
                    </div>
                </div>
            </div>

            {{-- TABEL RINCIAN --}}
            <div class="p-6">
                <h5 class="text-sm font-bold text-gray-700 dark:text-gray-300 mb-4">Rincian Pembayaran per Periode</h5>
                
                <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Periode</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Jatuh Tempo</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Denda</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-200 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            {{-- 
                                LOGIKA LOOPING PERIODE 
                                Kita perlu meloop manual berdasarkan Tenor karena tabel payments mungkin belum ada recordnya jika belum dibayar 
                            --}}
                            @for ($i = 1; $i <= $submission->tenor; $i++)
                                @php
                                    // Cari record payment untuk periode ini
                                    $payment = $submission->payments->where('period', $i)->first();
                                    
                                    // Hitung tanggal jatuh tempo (Start date + i bulan)
                                    $dueDate = $submission->created_at->addMonths($i)->setDay(1); // Misal jatuh tempo tgl 5
                                    
                                    // Tentukan Status & Denda
                                    $status = $payment ? $payment->status : 'upcoming';
                                    $penalty = 0;

                                    // Logika sederhana status jika belum ada record payment
                                    if (!$payment) {
                                        if (now()->gt($dueDate)) {
                                            $status = 'late';
                                            $penalty = 50000; // Contoh denda hardcoded atau dari logic controller
                                        } elseif (now()->diffInDays($dueDate, false) <= 7 && now()->diffInDays($dueDate, false) >= 0) {
                                            $status = 'due'; // Mendekati jatuh tempo
                                        }
                                    } else {
                                        $penalty = $payment->penalty_amount ?? 0;
                                    }

                                    // Badge Color
                                    $badgeData = match($status) {
                                        'verified' => ['bg-green-100 dark:bg-green-900', 'text-green-800 dark:text-green-200', 'LUNAS'],
                                        'pending' => ['bg-yellow-100 dark:bg-yellow-900', 'text-yellow-800 dark:text-yellow-200', 'MENUNGGU'],
                                        'rejected' => ['bg-red-100 dark:bg-red-900', 'text-red-800 dark:text-red-200', 'DITOLAK'],
                                        'late' => ['bg-red-600', 'text-white', 'TERLAMBAT'],
                                        'due' => ['bg-orange-100 dark:bg-orange-900', 'text-orange-800 dark:text-orange-200', 'JATUH TEMPO'],
                                        'upcoming' => ['bg-blue-50 dark:bg-blue-900/40', 'text-blue-600 dark:text-blue-300', 'AKAN DATANG'],
                                        default => ['bg-gray-100', 'text-gray-800', 'N/A']
                                    };
                                @endphp

                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40 transition-colors duration-150 
                                    @if($status === 'verified') bg-green-50/50 dark:bg-green-900/10 @endif">
                                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                        Periode {{ $i }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                        {{ $dueDate->format('d M Y') }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm font-bold {{ $penalty > 0 ? 'text-red-600 dark:text-red-400' : 'text-gray-900 dark:text-gray-300' }}">
                                        @currency($penalty)
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badgeData[0] }} {{ $badgeData[1] }}">
                                            {{ $badgeData[2] }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm">
                                        @if ($status === 'verified')
                                            <div class="flex items-center text-green-600 dark:text-green-400 font-bold bg-green-50 dark:bg-green-900/30 py-1 px-3 rounded-full w-fit">
                                                <i class="fas fa-check-circle mr-2"></i> Selesai
                                            </div>
                                        @elseif ($status === 'pending')
                                            <div class="flex items-center text-yellow-600 dark:text-yellow-400 bg-yellow-50 dark:bg-yellow-900/30 py-1 px-3 rounded-full w-fit text-xs font-medium">
                                                <i class="fas fa-clock mr-2"></i> Verifikasi...
                                            </div>
                                        @else
                                            {{-- FORM UPLOAD YANG LEBIH RAPI --}}
                                            <form action="{{ route('user.payments.store', $submission->id) }}" method="POST" enctype="multipart/form-data" 
                                                class="flex items-center gap-2"> {{-- Gunakan Flexbox untuk sejajar --}}
                                                @csrf
                                                <input type="hidden" name="period" value="{{ $i }}">
                                                
                                                {{-- Input File Compact --}}
                                                <div class="relative group">
                                                    <input type="file" name="proof" required 
                                                        class="block w-48 text-xs text-gray-500 dark:text-gray-400
                                                        file:mr-2 file:py-1.5 file:px-3
                                                        file:rounded-full file:border-0
                                                        file:text-xs file:font-semibold
                                                        file:bg-indigo-50 dark:file:bg-indigo-900/50
                                                        file:text-indigo-700 dark:file:text-indigo-300
                                                        hover:file:bg-indigo-100 dark:hover:file:bg-indigo-800
                                                        cursor-pointer focus:outline-none"
                                                    />
                                                </div>
                                                
                                                {{-- Tombol Kirim (Icon Only) --}}
                                                <button type="submit" title="Kirim Pembayaran"
                                                    class="flex items-center justify-center w-8 h-8 bg-indigo-600 dark:bg-indigo-500 text-white rounded-full hover:bg-indigo-700 dark:hover:bg-indigo-600 shadow-md transition-all duration-200 transform hover:scale-110 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    <i class="fas fa-paper-plane text-xs"></i>
                                                </button>
                                            </form>

                                            {{-- Pesan Error / Penolakan (Muncul di bawah form) --}}
                                            @if ($status === 'rejected')
                                                <p class="text-red-500 dark:text-red-400 text-[10px] mt-1 font-medium flex items-center">
                                                    <i class="fas fa-exclamation-circle mr-1"></i> Ditolak, upload ulang.
                                                </p>
                                            @endif
                                            @error('proof')
                                                <p class="text-red-500 dark:text-red-400 text-[10px] mt-1">{{ $message }}</p>
                                            @enderror
                                        @endif
                                    </td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @empty
        <div class="p-6 text-center bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <p class="text-gray-500 dark:text-gray-400">Belum ada riwayat transaksi.</p>
        </div>
    @endforelse
</div>