<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
            <h2 class="font-semibold text-xl text-indigo-800 dark:text-indigo-400 leading-tight transition-colors duration-300">
                {{ __('Pengajuan Kredit') }}
            </h2>
            
            {{-- 2. FORM PENCARIAN --}}
            <form action="{{ route('admin.submissions.index') }}" method="GET" class="flex w-full md:w-auto space-x-2">
                <input type="text" name="search" placeholder="Cari pemohon"
                       class="flex-grow rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500 transition-colors duration-300"
                       value="{{ request('search') }}">
                <button type="submit" class="px-4 py-2 bg-indigo-600 dark:bg-indigo-500 text-white rounded-md hover:bg-indigo-700 dark:hover:bg-indigo-600 transition duration-150 text-sm">
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
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Pemohon/Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Produk/Tenor</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Cicilan/DP</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($submissions as $submission)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $submission->user->name ?? 'N/A' }}<br>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">{{ $submission->user->email ?? 'N/A' }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $submission->product->name ?? 'N/A' }} ({{ $submission->tenor }} Bln)
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-indigo-600 dark:text-indigo-400">
                                        @currency($submission->monthly_installment)<br>
                                        <span class="text-xs font-normal text-gray-500 dark:text-gray-400">DP: @currency($submission->down_payment)</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @php
                                            $submissionStatus = $submission->status;
                                            $badgeClass = match ($submissionStatus) {
                                                'approved' => 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200',
                                                'pending' => 'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200',
                                                'rejected' => 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200',
                                                'pending_payoff' => 'bg-indigo-100 dark:bg-indigo-900 text-indigo-800 dark:text-indigo-200',
                                                'fully_paid' => 'bg-green-600 text-white', 
                                                default => 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300',
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
                                            <p class="text-xs font-semibold mb-1 text-indigo-600 dark:text-indigo-400">
                                                {{ $submission->status === 'pending_payoff' ? 'PELUNASAN PENUH' : 'Pengajuan Awal' }}
                                            </p>

                                            {{-- Tombol Setujui --}}
                                            <button 
                                                @click.prevent="$dispatch('open-confirmation-modal', {
                                                    url: '{{ route('admin.submissions.update', $submission) }}',
                                                    method: 'PATCH',
                                                    text: 'Setujui Pengajuan Kredit?',
                                                    color: 'bg-green-600 hover:bg-green-700',
                                                    confirmText: 'Ya, Setujui'
                                                })"
                                                type="button" class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300 mr-3 font-bold underline">Setujui</button>

                                            {{-- Tombol Tolak --}}
                                            <button 
                                                @click.prevent="$dispatch('open-confirmation-modal', {
                                                    url: '{{ route('admin.submissions.update', $submission) }}',
                                                    method: 'PATCH',
                                                    text: 'Tolak Pengajuan Kredit?',
                                                    color: 'bg-red-600 hover:bg-red-700',
                                                    confirmText: 'Ya, Tolak'
                                                })"
                                                type="button" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 font-bold underline">Tolak</button>
                                            
                                        @else
                                            <span class="text-gray-500 dark:text-gray-400 italic">Selesai</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">Tidak ada pengajuan kredit.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $submissions->links() }}
                </div>
            </div>
        </div>
    </div>
    @include('admin.partials.confirmation-modal')
</x-app-layout>