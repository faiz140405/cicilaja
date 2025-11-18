<x-app-layout>
    <x-slot name="header">
        {{-- Wrapper Flexbox untuk Judul dan Form Pencarian --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Verifikasi Pembayaran') }} (Pending)
            </h2>
            
            <form action="{{ route('admin.payments.verify.index') }}" method="GET" class="flex w-full md:w-auto space-x-2">
                <input type="text" name="search" placeholder="Cari pemohon, email, atau produk..."
                       class="flex-grow rounded-md border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500"
                       value="{{ request('search') }}">
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition duration-150 text-sm">
                    Cari
                </button>
            </form>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">{{ session('error') }}</div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pemohon/Produk</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Periode</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Dibayar</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bukti</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($payments as $payment)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $payment->submission->user->name }}<br>
                                        <span class="text-xs text-gray-500">{{ $payment->submission->product->name ?? 'N/A' }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-semibold">
                                        {{ $payment->period }} / {{ $payment->submission->tenor }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-indigo-600">
                                        @currency($payment->amount_paid)
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <button @click="currentProofUrl = '{{ $payment->proof_url }}'; showProofModal = true"
                                                type="button" 
                                                class="text-blue-600 hover:text-blue-800 underline">
                                            Lihat Bukti
                                        </button>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        
                                        @php
                                            // PERBAIKAN: Menggunakan $payment->status
                                            $paymentStatus = $payment->status;
                                            $isPendingAction = in_array($paymentStatus, ['pending', 'pending_payoff']);
                                            $actionType = $paymentStatus === 'pending_payoff' ? 'PELUNASAN PENUH' : 'Pembayaran Cicilan';
                                            
                                            $badgeClass = [
                                                'verified' => 'bg-green-100 text-green-800',
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                'rejected' => 'bg-red-100 text-red-800',
                                                'pending_payoff' => 'bg-indigo-100 text-indigo-800',
                                            ][$paymentStatus] ?? 'bg-gray-100 text-gray-800';
                                        @endphp
                                        
                                        @if ($isPendingAction)
                                            <p class="text-xs font-semibold mb-1 text-indigo-600">{{ $actionType }}</p>

                                            {{-- Tombol Setujui (Memicu Modal) --}}
                                            <button 
                                                @click.prevent="$dispatch('open-confirmation-modal', {
                                                    url: '{{ route('admin.payments.verify.update', $payment) }}',
                                                    method: 'PATCH',
                                                    text: 'Setujui Pembayaran',
                                                    color: 'bg-green-600 hover:bg-green-700',
                                                    confirmText: 'Ya, Setujui'
                                                })"
                                                type="button" class="text-green-600 hover:text-green-900 mr-3 font-bold underline">Setujui</button>

                                            {{-- Tombol Tolak (Memicu Modal) --}}
                                            <button 
                                                @click.prevent="$dispatch('open-confirmation-modal', {
                                                    url: '{{ route('admin.payments.verify.update', $payment) }}',
                                                    method: 'PATCH',
                                                    text: 'Tolak Pembayaran',
                                                    color: 'bg-red-600 hover:bg-red-700',
                                                    confirmText: 'Ya, Tolak'
                                                })"
                                                type="button" class="text-red-600 hover:text-red-900 font-bold underline">Tolak</button>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badgeClass }}">
                                                {{ ucfirst(str_replace('_', ' ', $paymentStatus)) }}
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">Tidak ada pembayaran yang menunggu verifikasi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $payments->links() }}
                </div>
            </div>
        </div>
    </div>
    
    {{-- SISIPKAN MODAL KONFIRMASI (Wajib ada) --}}
    @include('admin.partials.confirmation-modal')

</x-app-layout>