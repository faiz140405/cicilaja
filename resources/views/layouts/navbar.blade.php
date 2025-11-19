<nav x-data="{
    open: false,
    activeSection: 'beranda',
    darkMode: localStorage.getItem('darkMode') === 'true',
    navItems: [
        { name: 'Beranda', href: '{{ route('landing') }}', id: 'beranda' },
        { name: 'Produk', href: '#produk', id: 'produk' },
        { name: 'Simulasi Kredit', href: '#simulasi', id: 'simulasi' },
        { name: 'Tentang Kami', href: '#about', id: 'about' },
        { name: 'Kontak', href: '#kontak', id: 'kontak' },
    ],
    isRoute(name) {
        return name === 'Beranda' && '{{ Route::currentRouteName() }}' === 'landing';
    },
    toggleDarkMode() {
        this.darkMode = !this.darkMode;
        this.darkMode = !this.darkMode;
        localStorage.setItem('darkMode', this.darkMode);
        document.documentElement.classList.toggle('dark', this.darkMode);
    }
}" x-init="
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                activeSection = entry.target.id;
            }
        });
    }, { rootMargin: '-30% 0px -69% 0px' });

    document.querySelectorAll('section[id]').forEach(section => {
        observer.observe(section);
    });

    if (window.location.hash) {
        activeSection = window.location.hash.substring(1);
    }

    // Initialize dark mode on page load
    document.documentElement.classList.toggle('dark', darkMode);
" class="bg-white shadow-md sticky top-0 z-50 dark:bg-gray-800 dark:shadow-2xl dark:shadow-indigo-900/50 transition duration-300">
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    {{-- Logo link tidak memerlukan pengecekan role --}}
                    <a href="{{ Auth::check() && Auth::user()->role === 'admin' ? route('admin.dashboard') : route('landing') }}" 
                       class="text-2xl font-extrabold text-indigo-600 tracking-wider dark:text-indigo-400">
                        Cicil<span class="text-gray-900 dark:text-white">Aja</span>
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <template x-for="item in navItems" :key="item.id">
                        <a :href="item.href" 
                           :class="{ 
                               'border-indigo-500 text-indigo-600 dark:text-indigo-400 dark:border-indigo-400 font-semibold': activeSection === item.id, 
                               'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white': activeSection !== item.id 
                           }"
                           class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition duration-150 ease-in-out">
                            <span x-text="item.name"></span>
                        </a>
                    </template>
                </div>
            </div>

            {{-- TOMBOL AKSI & SETTINGS --}}
            <div class="hidden sm:ml-6 sm:flex sm:items-center space-x-2">
                
                {{-- DARK MODE TOGGLE (DESKTOP) - Diletakkan di luar @auth --}}
                <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode); document.documentElement.classList.toggle('dark', darkMode)" class="text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-white p-2 rounded-full transition duration-150 focus:outline-none">
                    <svg x-show="!darkMode" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    <svg x-show="darkMode" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                </button>
                {{-- END DARK MODE TOGGLE --}}

                @auth

                @if (Auth::user()->role === 'user')
                        <a href="{{ route('user.products.index') }}" 
                           class="inline-flex items-center justify-center px-3 py-2 border border-transparent 
                                  rounded-md shadow-sm text-sm font-medium text-white bg-green-600 
                                  hover:bg-green-800 transition duration-150 ease-in-out">
                            Lihat Produk
                        </a>
                    @endif

                    {{-- Tombol Dashboard Utama --}}
                    <a href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('user.dashboard') }}" 
                       class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-800 transition duration-150 ease-in-out">
                        Dashboard
                    </a>
                    
                    {{-- Settings Dropdown (UPDATED FIX DARK MODE) --}}
                    <div class="relative ml-3" x-data="{ open: false }" @click.away="open = false" @close.stop="open = false">
                        
                        <div @click="open = ! open">
                            <button class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none transition ease-in-out duration-150 cursor-pointer h-10">
                                <span class="mr-1">{{ Auth::user()->name }}</span>
                                <svg class="fill-current h-4 w-4 ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                
                        <div x-show="open"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 z-50 mt-2 w-48 rounded-md shadow-lg origin-top-right bg-white dark:bg-gray-700 ring-1 ring-black ring-opacity-5 py-1"
                             style="display: none;">
                            
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                                {{ __('Profile') }}
                            </a>
                
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); this.closest('form').submit();"
                                   class="block px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                                    {{ __('Log Out') }}
                                </a>
                            </form>
                        </div>
                    </div>
                    {{-- END UPDATED DROPDOWN --}}

                @else
                    {{-- Tampilkan Login/Register jika belum login --}}
                    <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:text-indigo-600 dark:text-gray-300 dark:hover:text-indigo-400 transition duration-150 ease-in-out px-3 py-2 rounded-md">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 transition duration-150 ease-in-out">
                        Register
                    </a>
                @endauth
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white dark:bg-gray-800 border-t dark:border-gray-700">
        
        {{-- Links Navigasi Landing Page --}}
        <div class="pt-2 pb-3 space-y-1 border-b dark:border-gray-700">
            
            @verbatim 
                <template x-for="item in navItems" :key="item.id">
                    <a :href="item.href" 
                       :class="{'bg-gray-100 text-indigo-700 border-indigo-400': activeSection === item.id, 'border-transparent text-gray-600 hover:text-gray-800': activeSection !== item.id}"
                       class="block w-full ps-3 pe-4 py-2 border-l-4 text-base font-medium focus:outline-none focus:text-indigo-800 focus:bg-indigo-100 focus:border-indigo-700 transition duration-150 ease-in-out">
                        <span x-text="item.name"></span>
                    </a>
                </template>
            @endverbatim
            
        </div>

        {{-- Responsive Links Dashboard (Hanya Muncul Jika Login) --}}
        @auth
            <div class="pt-2 pb-3 space-y-1 border-b dark:border-gray-700">
                @if (Auth::user()->role === 'admin')
                    {{-- ADMIN LINKS (Responsive) --}}
                    <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                        {{ __('Dashboard Admin') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.index')">
                        {{ __('Manajemen Kategori') }}
                    </x-responsive-nav-link>
                    
                    <x-responsive-nav-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.index')">
                        {{ __('Manajemen Produk') }}
                    </x-responsive-nav-link>
                    
                    <x-responsive-nav-link :href="route('admin.submissions.index')" :active="request()->routeIs('admin.submissions.index')">
                        {{ __('Pengajuan Kredit') }}
                    </x-responsive-nav-link>
                    
                    <x-responsive-nav-link :href="route('admin.payments.verify.index')" :active="request()->routeIs('admin.payments.verify.index')">
                        {{ __('Verifikasi Pembayaran') }}
                    </x-responsive-nav-link>
                
                @elseif (Auth::user()->role === 'user')
                    {{-- USER LINKS (Responsive) --}}
                    <x-responsive-nav-link :href="route('user.dashboard')" :active="request()->routeIs('user.dashboard')">
                        {{ __('Dashboard Pelanggan') }}
                    </x-responsive-nav-link>
                    
                    <x-responsive-nav-link :href="route('user.payments.index')" :active="request()->routeIs('user.payments.index')">
                        {{ __('Cicilan Saya') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('user.products.index')" :active="request()->routeIs('user.products.index')">
                        {{ __('Daftar Produk') }}
                    </x-responsive-nav-link>
                @endif
            </div>

            <div class="pt-4 pb-1 border-t border-gray-200">
                
                {{-- DARK MODE TOGGLE (MOBILE) --}}
                <div class="px-4 py-2 border-b border-gray-200 dark:border-gray-700">
                    <button @click="toggleDarkMode()" class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-white focus:outline-none transition duration-150">
                        <svg x-show="!darkMode" class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        <svg x-show="darkMode" class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" ><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                        <span x-text="darkMode ? 'Mode Terang' : 'Mode Gelap'"></span>
                    </button>
                </div>
                {{-- END DARK MODE TOGGLE --}}
                
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800 dark:text-white">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @else
            {{-- Tombol Login/Register jika belum login --}}
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('login')">
                    {{ __('Login') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('register')">
                    {{ __('Register') }}
                </x-responsive-nav-link>
            </div>
        @endauth
    </div>
</nav>