<x-guest-layout>
    <div class="mb-6 text-center">
        {{-- Menggunakan komponen logo yang sudah dimodifikasi --}}
        <a href="{{ route('landing') }}" class="inline-block">
            <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
        </a>
        <h2 class="text-2xl font-bold text-gray-900 mt-3">
            Masuk ke Akun CicilAja
        </h2>
        <p class="text-sm text-gray-500">
            Akses dashboard Anda dan kelola pengajuan kredit.
        </p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')"/>
            <x-text-input 
                id="email" 
                class="block w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                type="email" 
                name="email" 
                :value="old('email')" 
                required 
                autofocus 
                autocomplete="username" 
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')"/>

            <x-text-input 
                id="password" 
                class="block w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                type="password"
                name="password"
                required 
                autocomplete="current-password" 
            />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-6">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Ingat Saya') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-indigo-600 transition duration-150" href="{{ route('password.request') }}">
                    {{ __('Lupa Password?') }}
                </a>
            @endif
        </div>

        <div class="flex flex-col space-y-3 mt-6">
            {{-- Tombol Login --}}
            <x-primary-button class="justify-center w-full bg-indigo-600 hover:bg-indigo-700 transition duration-150">
                {{ __('Masuk') }}
            </x-primary-button>
            
            {{-- Tombol Daftar / Register --}}
            <a href="{{ route('register') }}" class="w-full text-center py-2.5 border border-gray-300 text-sm font-semibold rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition duration-150 shadow-sm">
                Belum punya akun? Daftar Sekarang
            </a>
        </div>
    </form>
</x-guest-layout>