<div x-data="{ 
    showModal: false, 
    actionUrl: '', 
    actionMethod: 'PATCH', 
    actionText: 'Setujui',
    actionColor: 'bg-green-600',
    actionConfirmText: 'Ya, Setujui',
    
    openConfirmationModal(url, method, text, color, confirmText) {
        this.actionUrl = url;
        this.actionMethod = method;
        this.actionText = text;
        this.actionColor = color;
        this.actionConfirmText = confirmText;
        this.showModal = true;
    }
}" 
x-on:open-confirmation-modal.window="openConfirmationModal($event.detail.url, $event.detail.method, $event.detail.text, $event.detail.color, $event.detail.confirmText)"
x-show="showModal" 
x-cloak class="fixed inset-0 z-[100] overflow-y-auto">

    <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" @click="showModal = false"></div>

    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-2xl max-w-sm w-full relative z-20"
             x-transition:enter="ease-out duration-300"
             x-transition:leave="ease-in duration-200">
            
            <form :action="actionUrl" method="POST" class="p-6">
                @csrf
                <input type="hidden" name="_method" :value="actionMethod">
                <input type="hidden" name="status" :value="actionMethod === 'PATCH' ? (actionText === 'Setujui' ? 'approved' : 'rejected') : 'delete'">
                
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">
                    Konfirmasi Aksi: <span x-text="actionText"></span>
                </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Apakah Anda yakin ingin melakukan aksi <span x-text="actionText"></span>? Aksi ini tidak dapat dibatalkan.
                </p>

                <div class="mt-6">
                    <label for="reason" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Catatan (Opsional)</label>
                    <textarea id="reason" name="reason" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" @click="showModal = false" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition duration-150">
                        Batal
                    </button>
                    
                    <button type="submit" 
                            :class="actionColor"
                            class="px-4 py-2 text-white rounded-lg transition duration-150">
                        <span x-text="actionConfirmText"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>