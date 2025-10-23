<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0">
            <h2 class="font-semibold text-xl text-indigo-800 leading-tight">
                {{ __('Verifikasi Pembayaran') }}
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
                                        Rp {{ number_format($payment->amount_paid, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <a href="{{ asset($payment->proof_path) }}" target="_blank" class="text-blue-600 hover:text-blue-800">Lihat Bukti</a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        
                                        @php
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

                                            {{-- Tombol Setujui --}}
                                            <form action="{{ route('admin.payments.verify.update', $payment) }}" method="POST" class="inline" onsubmit="return confirm('Verifikasi pembayaran ini?');">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="verified">
                                                <button type="submit" class="text-green-600 hover:text-green-900 mr-3">Setujui</button>
                                            </form>

                                            {{-- Tombol Tolak --}}
                                            <form action="{{ route('admin.payments.verify.update', $payment) }}" method="POST" class="inline" onsubmit="return confirm('Tolak pembayaran ini?');">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="rejected">
                                                <button type="submit" class="text-red-600 hover:text-red-900">Tolak</button>
                                            </form>
                                        @else
                                            {{-- Menampilkan Badge Status Akhir jika bukan pending --}}
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
    @include('admin.partials.confirmation-modal')
</x-app-layout>