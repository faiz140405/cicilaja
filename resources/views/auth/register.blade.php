<x-guest-layout>
    
    <div class="mb-6 text-center">
        {{-- Menggunakan komponen logo yang sudah dimodifikasi --}}
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

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Nama Lengkap -->
        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" />
            <x-text-input 
                id="name" 
                class="block w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                type="text" 
                name="name" 
                :value="old('name')" 
                required 
                autofocus 
                autocomplete="name" 
            />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Alamat Email')" />
            <x-text-input 
                id="email" 
                class="block w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                type="email" 
                name="email" 
                :value="old('email')" 
                required 
                autocomplete="username" 
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="phone_number" :value="__('Nomor Telepon')" />
            <x-text-input id="phone_number" name="phone_number" type="text" 
                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                :value="old('phone_number')" required autocomplete="tel" />
            <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
        </div>
        
        <div class="mt-4">
            <x-input-label for="address" :value="__('Alamat Lengkap')" />
            <textarea id="address" name="address" required 
                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('address') }}</textarea>
            <x-input-error :messages="$errors->get('address')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            type="password"
                            name="password"
                            required 
                            autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />

            <x-text-input id="password_confirmation" class="block w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex flex-col space-y-3 pt-4">
            
            {{-- Tombol Register --}}
            <x-primary-button class="justify-center w-full bg-indigo-600 hover:bg-indigo-700 transition duration-150">
                {{ __('Daftar Akun') }}
            </x-primary-button>

            {{-- Tautan Login --}}
            <a class="w-full text-center py-2.5 border border-gray-300 text-sm font-semibold rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition duration-150 shadow-sm" href="{{ route('login') }}">
                Sudah punya akun? Masuk
            </a>
        </div>
    </form>
</x-guest-layout>
