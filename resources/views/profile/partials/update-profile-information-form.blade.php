<section>
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-4">
        @csrf
        @method('patch')

        {{-- Input Nama --}}
        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" class="dark:text-gray-300" />
            <x-text-input 
                id="name" 
                name="name" 
                type="text" 
                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" 
                :value="old('name', $user->name)" 
                required 
                autofocus 
                autocomplete="name" 
            />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        {{-- Input Email --}}
        <div>
            <x-input-label for="email" :value="__('Alamat Email')" class="dark:text-gray-300" />
            <x-text-input 
                id="email" 
                name="email" 
                type="email" 
                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" 
                :value="old('email', $user->email)" 
                required 
                autocomplete="username" 
            />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2 text-sm text-gray-800 dark:text-gray-200">
                    <p>
                        {{ __('Alamat email Anda belum diverifikasi.') }}

                        <button form="send-verification" class="underline text-sm text-indigo-600 hover:text-indigo-800 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150">
                            {{ __('Klik di sini untuk mengirim ulang tautan verifikasi.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('Tautan verifikasi baru telah dikirimkan ke alamat email Anda.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <x-input-label for="phone_number" :value="__('Nomor Telepon')" class="dark:text-gray-300" />
            <x-text-input 
                id="phone_number" 
                name="phone_number" 
                type="text" 
                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" 
                :value="old('phone_number', $user->phone_number)" required autocomplete="tel" 
            />
            <x-input-error class="mt-2" :messages="$errors->get('phone_number')" />
        </div>
        
        {{-- === INPUT BARU: ALAMAT LENGKAP === --}}
        <div>
            <x-input-label for="address" :value="__('Alamat Lengkap')" class="dark:text-gray-300" />
            <textarea 
                id="address" 
                name="address" 
                required 
                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
            >{{ old('address', $user->address) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('address')" />
        </div>

        <div class="flex items-center gap-4 pt-4">
            {{-- Tombol Save dengan styling Indigo --}}
            <x-primary-button class="bg-indigo-600 hover:bg-indigo-700">
                {{ __('Simpan Perubahan') }}
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600"
                >{{ __('Berhasil disimpan.') }}</p>
            @endif
        </div>
    </form>
</section>