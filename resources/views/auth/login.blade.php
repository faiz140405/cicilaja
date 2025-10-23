<x-guest-layout>
    <div class="mb-6 text-center">
        <a href="{{ route('landing') }}" class="inline-block">
            <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
        </a>
        <h2 class="text-2xl font-bold text-indigo-800 mt-3">
            Masuk ke Akun CicilAja
        </h2>
        <p class="text-sm text-gray-500">
            Akses dashboard Anda dan kelola pengajuan kredit.
        </p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        {{-- EMAIL --}}
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

        {{-- PASSWORD --}}
        <div class="mt-4 relative">
            <x-input-label for="password" :value="__('Password')"/>

            <div class="relative">
                <input 
                    id="password" 
                    class="block w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 pr-10"
                    type="password"
                    name="password"
                    required 
                    autocomplete="current-password" 
                />

                {{-- Tombol Toggle Icon --}}
                <button 
                    type="button" 
                    id="togglePassword"
                    class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 hover:text-gray-700 focus:outline-none"
                    tabindex="-1"
                >
                    <i id="eyeIcon" class="fa fa-eye-slash"></i>
                </button>
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        {{-- REMEMBER + LUPA PASSWORD --}}
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

        {{-- BUTTON --}}
        <div class="flex flex-col space-y-3 mt-6">
            <x-primary-button class="justify-center w-full bg-indigo-600 hover:bg-indigo-700 transition duration-150">
                {{ __('Masuk') }}
            </x-primary-button>
            
            <a href="{{ route('register') }}" class="w-full text-center py-2.5 border border-gray-300 text-sm font-semibold rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition duration-150 shadow-sm">
                Belum punya akun? Daftar Sekarang
            </a>
        </div>
    </form>

    {{-- SCRIPT TOGGLE PASSWORD --}}
    <script>
        const passwordInput = document.getElementById('password');
        const toggleButton = document.getElementById('togglePassword');
        const eyeIcon = document.getElementById('eyeIcon');

        toggleButton.addEventListener('click', () => {
            const isHidden = passwordInput.type === 'password';
            passwordInput.type = isHidden ? 'text' : 'password';
            
            // Ganti icon
            if (isHidden) {
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-solid', 'fa-eye');
            } else {
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa', 'fa-eye-slash');
            }
        });
    </script>
</x-guest-layout>
