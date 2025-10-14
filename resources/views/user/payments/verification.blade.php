<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Verifikasi Pembayaran') }} (Pending)
        </h2>
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
                                        {{-- Bukti Path harus mengarah ke file yang sudah di-symlink --}}
                                        <a href="{{ asset($payment->proof_path) }}" target="_blank" class="text-blue-600 hover:text-blue-800">Lihat Bukti</a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        @if ($payment->status === 'pending')
                                            {{-- Form Verifikasi --}}
                                            <form action="{{ route('admin.payments.verify.update', $payment) }}" method="POST" class="inline" onsubmit="return confirm('Verifikasi pembayaran ini?');">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="verified">
                                                <button type="submit" class="text-green-600 hover:text-green-900 mr-3">Verifikasi</button>
                                            </form>

                                            {{-- Form Tolak --}}
                                            <form action="{{ route('admin.payments.verify.update', $payment) }}" method="POST" class="inline" onsubmit="return confirm('Tolak pembayaran ini?');">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="rejected">
                                                <button type="submit" class="text-red-600 hover:text-red-900">Tolak</button>
                                            </form>
                                        @else
                                            <span class="text-gray-500 italic">{{ ucfirst($payment->status) }}</span>
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
</x-app-layout>
