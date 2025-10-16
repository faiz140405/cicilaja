<section class="space-y-4">
    {{-- Tombol Pemicu Modal --}}
    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="bg-red-600 hover:bg-red-700 shadow-md transition duration-150"
    >{{ __('Hapus Akun') }}</x-danger-button>

    {{-- Modal Konfirmasi --}}
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                {{ __('Apakah Anda yakin ingin menghapus akun Anda?') }}
            </h2>

            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Setelah akun Anda dihapus, semua data akan dihapus permanen. Mohon masukkan kata sandi Anda untuk mengonfirmasi penghapusan akun secara permanen.') }}
            </p>

            {{-- Input Password --}}
            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Kata Sandi') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                    placeholder="{{ __('Kata Sandi') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            {{-- Tombol Aksi --}}
            <div class="mt-6 flex justify-end">
                
                {{-- Tombol Batal --}}
                <x-secondary-button x-on:click="$dispatch('close')" class="dark:bg-gray-600 dark:hover:bg-gray-500">
                    {{ __('Batal') }}
                </x-secondary-button>

                {{-- Tombol Hapus --}}
                <x-danger-button class="ms-3 bg-red-600 hover:bg-red-700">
                    {{ __('Hapus Akun') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>