<x-app-layout x-data="{ showProofModal: false, currentProofUrl: '' }">
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-indigo-400 leading-tight transition-colors duration-300">
                {{ __('Verifikasi Pembayaran') }} (Pending)
            </h2>
            
            <form action="{{ route('admin.payments.verify.index') }}" method="GET" class="flex w-full md:w-auto space-x-2">
                <input type="text" name="search" placeholder="Cari pemohon..."
                       class="flex-grow rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500 transition-colors duration-300"
                       value="{{ request('search') }}">
                <button type="submit" class="px-4 py-2 bg-indigo-600 dark:bg-indigo-500 text-white rounded-lg hover:bg-indigo-700 dark:hover:bg-indigo-600 transition duration-150 text-sm">
                    Cari
                </button>
            </form>
        </div>
    </x-slot>

    <div class="py-12 transition-colors duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 dark:bg-green-900/50 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-200 px-4 py-3 rounded relative mb-4">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 dark:bg-red-900/50 border border-red-400 dark:border-red-600 text-red-700 dark:text-red-200 px-4 py-3 rounded relative mb-4">{{ session('error') }}</div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 border border-gray-200 dark:border-gray-700 transition-colors duration-300">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Pemohon/Produk</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Periode</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Jumlah Dibayar</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Bukti</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($payments as $payment)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $payment->submission->user->name }}<br>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">{{ $payment->submission->product->name ?? 'N/A' }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 font-semibold">
                                        {{ $payment->period }} / {{ $payment->submission->tenor }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-indigo-600 dark:text-indigo-400">
                                        @currency($payment->amount_paid)
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <button @click="currentProofUrl = '{{ $payment->proof_url }}'; showProofModal = true"
                                                type="button" 
                                                class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 underline font-medium">
                                            Lihat Bukti
                                        </button>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        
                                        @php
                                            $paymentStatus = $payment->status;
                                            $isPendingAction = in_array($paymentStatus, ['pending', 'pending_payoff']);
                                            $actionType = $paymentStatus === 'pending_payoff' ? 'PELUNASAN PENUH' : 'Pembayaran Cicilan';
                                            
                                            $badgeClass = match($paymentStatus) {
                                                'verified' => 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200',
                                                'pending' => 'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200',
                                                'rejected' => 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200',
                                                'pending_payoff' => 'bg-indigo-100 dark:bg-indigo-900 text-indigo-800 dark:text-indigo-200',
                                                default => 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300',
                                            };
                                        @endphp
                                        
                                        @if ($isPendingAction)
                                            <p class="text-xs font-semibold mb-1 text-indigo-600 dark:text-indigo-400">{{ $actionType }}</p>

                                            <button 
                                                @click.prevent="$dispatch('open-confirmation-modal', {
                                                    url: '{{ route('admin.payments.verify.update', $payment) }}',
                                                    method: 'PATCH',
                                                    text: 'Setujui Pembayaran?',
                                                    color: 'bg-green-600 hover:bg-green-700',
                                                    confirmText: 'Ya, Setujui'
                                                })"
                                                type="button" class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300 mr-3 font-bold underline">Setujui</button>

                                            <button 
                                                @click.prevent="$dispatch('open-confirmation-modal', {
                                                    url: '{{ route('admin.payments.verify.update', $payment) }}',
                                                    method: 'PATCH',
                                                    text: 'Tolak Pembayaran?',
                                                    color: 'bg-red-600 hover:bg-red-700',
                                                    confirmText: 'Ya, Tolak'
                                                })"
                                                type="button" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 font-bold underline">Tolak</button>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badgeClass }}">
                                                {{ ucfirst(str_replace('_', ' ', $paymentStatus)) }}
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">Tidak ada pembayaran yang menunggu verifikasi.</td>
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
    
    @include('admin.partials.confirmation-modal')

</x-app-layout>