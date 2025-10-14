{{-- Modal ini membutuhkan: $submissions (collection) dan state openPayoffModal --}}
<div x-cloak x-show="openPayoffModal" class="fixed inset-0 z-[70] overflow-y-auto"> 
    
    {{-- Overlay --}}
    <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity z-10" @click="openPayoffModal = false"></div>

    {{-- Modal Content Wrapper --}}
    <div class="flex items-center justify-center min-h-full w-full py-16">
        <div class="relative w-full max-w-2xl mx-4 my-8 z-20">
            
            {{-- Modal Content Card --}}
            <div class="bg-white rounded-lg shadow-2xl p-6 relative">
                
                <h3 class="text-2xl font-bold text-red-600 mb-4 border-b pb-2">
                    Pelunasan Dipercepat
                </h3>
                <p class="text-gray-700 mb-6">
                    Berikut adalah total sisa hutang Anda per barang yang disetujui. Jumlah ini sudah termasuk sisa pokok dan bunga yang belum dibayar.
                </p>

                @forelse ($submissions as $submission)
                    @if ($submission->periods_left > 0)
                        
                        {{-- FORM PELUNASAN PER ITEM --}}
                        <form action="{{ route('user.payments.accelerated', $submission) }}" method="POST" enctype="multipart/form-data" class="mb-6 p-4 border border-red-200 rounded-lg bg-red-50">
                            @csrf
                            
                            <h4 class="text-xl font-bold text-gray-900 mb-2">{{ $submission->product->name ?? 'N/A' }}</h4>
                            <p class="text-sm text-red-600 mb-4">Sisa Periode: {{ $submission->periods_left }} Bulan</p>
                            
                            {{-- Tampilkan Total Pelunasan --}}
                            <div class="flex justify-between items-center py-2 border-y border-red-200 mb-4">
                                <p class="text-lg font-bold text-red-800">TOTAL WAJIB TRANSFER:</p>
                                <p class="text-2xl font-extrabold text-red-800">@currency($submission->payoff_amount)</p>
                            </div>

                            {{-- Input Bukti Pembayaran --}}
                            <div>
                                <label for="proof_{{ $submission->id }}" class="block text-sm font-medium text-gray-700 mb-1">
                                    Upload Bukti Pembayaran Penuh (Max 5MB)
                                </label>
                                <input type="file" name="proof" id="proof_{{ $submission->id }}" required 
                                       class="block w-full text-sm text-gray-500 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-red-100 file:text-red-700 hover:file:bg-red-200 cursor-pointer"/>
                                
                                <input type="hidden" name="amount" value="{{ $submission->payoff_amount }}">
                                <input type="hidden" name="is_full_payoff" value="1">
                            </div>

                            {{-- Tombol Submit --}}
                            <button type="submit" 
                                    class="mt-4 w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-semibold transition duration-150 shadow-md">
                                Transfer Pelunasan Ini
                            </button>
                            
                            @error('proof')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </form>
                        
                    @endif
                @empty
                    <div class="p-4 text-center text-green-700 bg-green-50 rounded-lg">
                        Semua cicilan Anda sudah lunas!
                    </div>
                @endforelse
                
                <div class="mt-6 text-right">
                    <button @click="openPayoffModal = false" 
                            class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>