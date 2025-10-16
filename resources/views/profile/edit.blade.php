<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-indigo-600 leading-tight">
            {{ __('Pengaturan Profil') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-10xl mx-auto sm:px-6 lg:px-8 space-y-6 p-4">
            
            {{-- BAGIAN ATAS: GRID DUA KOLOM --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- KOLOM ATAS KIRI: Update Informasi Profil --}}
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow-xl rounded-xl border-t-4 border-indigo-500">
                    <div class="max-w-xl">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Informasi Akun</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
                            Perbarui informasi profil dan alamat email akun Anda.
                        </p>
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                {{-- KOLOM ATAS KANAN: Update Password --}}
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow-xl rounded-xl border-t-4 border-indigo-500">
                    <div class="max-w-xl">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Perbarui Kata Sandi</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
                            Pastikan akun Anda menggunakan kata sandi yang panjang dan acak agar tetap aman.
                        </p>
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

            </div> {{-- END GRID 2 KOLOM --}}

            {{-- BAGIAN BAWAH: Hapus Akun (1 Kolom Penuh) --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow-xl rounded-xl border-t-4 border-red-600">
                <div class="max-w-xl">
                    <h3 class="text-xl font-bold text-red-600 mb-2">Hapus Akun</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
                        Setelah akun Anda dihapus, semua sumber daya dan data akan dihapus secara permanen.
                    </p>
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>