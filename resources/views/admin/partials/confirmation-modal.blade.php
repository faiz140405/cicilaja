{{-- 
    Modal Konfirmasi Dinamis (Alpine.js)
    Dipicu oleh event: $dispatch('open-confirmation-modal', { ...data... })
--}}
<div x-data="{ 
        showModal: false, 
        actionUrl: '', 
        actionMethod: 'PATCH', 
        actionText: 'Konfirmasi',
        actionColor: 'bg-indigo-600',
        actionConfirmText: 'Ya, Lanjutkan',
        
        openConfirmationModal(detail) {
            this.actionUrl = detail.url;
            this.actionMethod = detail.method;
            this.actionText = detail.text;
            this.actionColor = detail.color;
            this.actionConfirmText = detail.confirmText;
            this.showModal = true;
        }
    }" 
    x-on:open-confirmation-modal.window="openConfirmationModal($event.detail)"
    x-show="showModal" 
    x-cloak 
    class="fixed inset-0 z-[100] overflow-y-auto" {{-- z-index sangat tinggi --}}
    x-transition:enter="ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0">

    {{-- Overlay (Pastikan ada z-index yang lebih rendah dari modal content) --}}
    <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" @click="showModal = false"></div>

    {{-- Modal Content --}}
    <div class="flex items-center justify-center min-h-screen p-4"> {{-- Container untuk centering vertikal --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-2xl max-w-sm w-full mx-auto relative z-20" {{-- max-w-sm untuk lebar, mx-auto untuk center --}}
            @click.away="showModal = false"
            x-show="showModal"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            
            <form :action="actionUrl" method="POST" class="p-6">
            @csrf
            <input type="hidden" name="_method" :value="actionMethod">
            
            {{-- PERBAIKAN LOGIKA STATUS DINAMIS --}}
            @php
                $statusLogic = "
                    if (actionMethod === 'DELETE') {
                        return 'delete';
                    }
                    if (actionMethod === 'PATCH') {
                        if (actionText.includes('Setujui Pengajuan')) { // Dari submissions/index
                            return 'approved';
                        }
                        if (actionText.includes('Setujui Pembayaran')) { // Dari payments/verification
                            return 'verified';
                        }
                        if (actionText.includes('Tolak')) { // Universal
                            return 'rejected';
                        }
                    }
                    return 'unknown'; // Fallback
                ";
            @endphp
            
            <input type="hidden" name="status" :value="(() => { {{ $statusLogic }} })()">
            
            <h2 class="text-xl font-bold text-gray-900 mb-2">
                Konfirmasi Aksi: <span x-text="actionText"></span>
            </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Apakah Anda yakin ingin melakukan aksi <span x-text="actionText"></span>? Aksi ini tidak dapat dibatalkan.
                </p>

                {{-- Input Catatan (opsional, bisa ditambahkan jika perlu) --}}
                {{-- <div class="mt-4">
                    <label for="reason" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Catatan (Opsional)</label>
                    <textarea id="reason" name="reason" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea>
                </div> --}}

                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" @click="showModal = false" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition duration-150">
                        Batal
                    </button>
                    
                    <button type="submit" 
                            :class="actionColor"
                            class="px-4 py-2 text-white rounded-lg transition duration-150 shadow-md">
                        <span x-text="actionConfirmText"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>