<x-guest-layout>
    <div class="mb-6 text-center">
        <a href="{{ route('landing') }}" class="inline-block">
            <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
        </a>
        <h2 class="text-2xl font-bold text-indigo-800 mt-3">
            Buat Akun Pelanggan Baru
        </h2>
        <p class="text-sm text-gray-500">
            Daftar sekarang untuk memulai pengajuan kredit Anda.
        </p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        {{-- BAGIAN 1: DATA UTAMA --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            {{-- Nama Lengkap --}}
            <div>
                <x-input-label for="name" :value="__('Nama Lengkap')" />
                <x-text-input 
                    id="name" name="name" type="text"
                    class="block w-full mt-1 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            {{-- Nomor Telepon --}}
            <div>
                <x-input-label for="phone_number" :value="__('Nomor Telepon')" />
                <x-text-input 
                    id="phone_number" name="phone_number" type="text"
                    class="block w-full mt-1 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    :value="old('phone_number')" required autocomplete="tel" />
                <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
            </div>

            {{-- Alamat Email --}}
            <div>
                <x-input-label for="email" :value="__('Alamat Email')" />
                <x-text-input 
                    id="email" name="email" type="email"
                    class="block w-full mt-1 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            {{-- Password --}}
            <div x-data="{ showPassword: false }">
                <x-input-label for="password" :value="__('Password')" />
                <div class="relative">
                    <input 
                        id="password" 
                        name="password" 
                        :type="showPassword ? 'text' : 'password'"
                        class="block w-full mt-1 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 pr-10"
                        required autocomplete="new-password" />

                    {{-- Tombol Toggle --}}
                    <button type="button" 
                        @click="showPassword = !showPassword"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-indigo-600 transition">
                        <i :class="showPassword ? 'fa fa-eye-slash' : 'fa-solid fa-eye'"></i>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

        </div> {{-- END GRID --}}

        {{-- Alamat Lengkap --}}
        <div>
            <x-input-label for="address" :value="__('Alamat Lengkap')" />
            <textarea id="address" name="address" required
                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('address') }}</textarea>
            <x-input-error :messages="$errors->get('address')" class="mt-2" />
        </div>

        {{-- Konfirmasi Password --}}
        <div class="mt-4 relative" x-data="{ showConfirm: false }">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
            <div class="relative">
                <input 
                    id="password_confirmation"
                    name="password_confirmation"
                    :type="showConfirm ? 'text' : 'password'"
                    class="block w-full mt-1 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 pr-10"
                    required autocomplete="new-password" />

                <button type="button"
                    @click="showConfirm = !showConfirm"
                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-indigo-600 transition">
                    <i :class="showConfirm ? 'fa fa-eye-slash' : 'fa-solid fa-eye'"></i>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        {{-- TOMBOL --}}
        <div class="flex flex-col space-y-3 pt-4">
            <x-primary-button class="justify-center w-full bg-indigo-600 hover:bg-indigo-700 transition duration-150">
                {{ __('Daftar Akun') }}
            </x-primary-button>

            <a href="{{ route('login') }}"
                class="w-full text-center py-2.5 border border-gray-300 text-sm font-semibold rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition duration-150 shadow-sm">
                Sudah punya akun? Masuk
            </a>
        </div>
    </form>
</x-guest-layout>
