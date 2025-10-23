<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
            <h2 class="font-semibold text-xl text-indigo-800 leading-tight">
                {{ __('Pengajuan Kredit') }}
            </h2>
            
            {{-- 2. FORM PENCARIAN --}}
            <form action="{{ route('admin.submissions.index') }}" method="GET" class="flex w-full md:w-auto space-x-2">
                <input type="text" name="search" placeholder="Cari pemohon"
                       class="flex-grow rounded-md border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500"
                       value="{{ request('search') }}">
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition duration-150 text-sm">
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
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pemohon/Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk/Tenor</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cicilan/DP</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($submissions as $submission)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $submission->user->name ?? 'N/A' }}<br>
                                        <span class="text-xs text-gray-500">{{ $submission->user->email ?? 'N/A' }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $submission->product->name ?? 'N/A' }} ({{ $submission->tenor }} Bln)
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-indigo-600">
                                        @currency($submission->monthly_installment)<br>
                                        <span class="text-xs font-normal text-gray-500">DP: @currency($submission->down_payment)</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @php
                                            $submissionStatus = $submission->status;
                                            $badgeClass = match ($submissionStatus) {
                                                'approved' => 'bg-green-100 text-green-800',
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                'rejected' => 'bg-red-100 text-red-800',
                                                'pending_payoff' => 'bg-indigo-100 text-indigo-800',
                                                'fully_paid' => 'bg-green-500 text-white', // Jika Anda menambahkan status fully_paid di ENUM
                                                default => 'bg-gray-100 text-gray-800',
                                            };
                                            $displayText = ucfirst(str_replace('_', ' ', $submissionStatus));
                                        @endphp
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badgeClass }}">
                                            {{ $displayText }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        
                                        @if ($submission->status === 'pending' || $submission->status === 'pending_payoff') 
                                            
                                            {{-- Tampilkan jenis aksi --}}
                                            <p class="text-xs font-semibold mb-1 text-indigo-600">
                                                {{ $submission->status === 'pending_payoff' ? 'PELUNASAN PENUH' : 'Pengajuan Awal' }}
                                            </p>

                                            {{-- Form Verifikasi --}}
                                            <button 
                                                @click="$dispatch('open-confirmation-modal', {
                                                    url: '{{ route('admin.submissions.update', $submission) }}',
                                                    method: 'PATCH',
                                                    text: 'Setujui',
                                                    color: 'bg-green-600 hover:bg-green-700',
                                                    confirmText: 'Ya, Setujui Sekarang'
                                                })"
                                                type="button" class="text-green-600 hover:text-green-900 mr-3">Setujui</button>

                                            {{-- Form Tolak --}}
                                            <button 
                                                @click="$dispatch('open-confirmation-modal', {
                                                    url: '{{ route('admin.submissions.update', $submission) }}',
                                                    method: 'PATCH',
                                                    text: 'Tolak',
                                                    color: 'bg-red-600 hover:bg-red-700',
                                                    confirmText: 'Ya, Tolak'
                                                })"
                                                type="button" class="text-red-600 hover:text-red-900">Tolak</button>
                                        @else
                                            <span class="text-gray-500 italic">Selesai</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">Tidak ada pengajuan kredit.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $submissions->links() }}
            </div>
        </div>
    </div>
    @include('admin.partials.confirmation-modal')
</x-app-layout>