<nav x-data="{ open: false, darkMode: localStorage.getItem('darkMode') === 'true' }" x-init="document.documentElement.classList.toggle('dark', darkMode)" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    {{-- Logo mengarah ke dashboard sesuai role --}}
                    <a href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('user.dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-indigo-800" />
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex border-b dark:border-gray-700">
                    @auth
                        @if (Auth::user()->role === 'admin')
                            {{-- ADMIN ACTIONS (COMPACT ICON LINKS) --}}
                            <x-nav-link  :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                                <i class="fas fa-home mr-2"></i> {{ __('Dashboard') }}
                            </x-nav-link>

                            <x-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.index')">
                                <i class="fas fa-folder mr-2"></i> {{ __('Kategori') }}
                            </x-nav-link>

                            <x-nav-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.index')">
                                <i class="fas fa-box-open mr-2"></i> {{ __('Produk') }}
                            </x-nav-link>

                            <x-nav-link :href="route('admin.submissions.index')" :active="request()->routeIs('admin.submissions.index')">
                                <i class="fas fa-file-contract mr-2"></i> {{ __('Kredit') }}
                            </x-nav-link>

                            <x-nav-link :href="route('admin.payments.verify.index')" :active="request()->routeIs('admin.payments.verify.index')">
                                <i class="fas fa-shield-alt mr-2"></i> {{ __('Verifikasi') }}
                            </x-nav-link>

                            <x-nav-link :href="route('admin.reports.index')" :active="request()->routeIs('admin.reports.index')">
                                <i class="fas fa-chart-line mr-2"></i> {{ __('Laporan') }}
                            </x-nav-link>

                        @elseif (Auth::user()->role === 'user')
                            {{-- USER LINKS --}}
                            <x-nav-link :href="route('user.dashboard')" :active="request()->routeIs('user.dashboard')">
                                <i class="fas fa-home mr-2"></i>{{ __('Dashboard Pelanggan') }}
                            </x-nav-link>

                            {{-- TAUTAN BARU: Cicilan Saya --}}
                            <x-nav-link :href="route('user.payments.index')" :active="request()->routeIs('user.payments.index')">
                                <i class="fas fa-chart-line mr-2"></i>{{ __('Cicilan Saya') }}
                            </x-nav-link>

                            <x-nav-link :href="route('products.index')" :active="request()->routeIs('products.index')">
                                <i class="fa-brands fa-product-hunt mr-2"></i>{{ __('Semua Produk') }}
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <!-- Dark Mode Toggle Button for Mobile -->
                <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode); document.documentElement.classList.toggle('dark', darkMode)" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out dark:hover:bg-gray-700">
                    <i :class="darkMode ? 'fas fa-sun' : 'fas fa-moon'" class="h-6 w-6"></i>
                </button>

                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out dark:hover:bg-gray-700">
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
                       :class="{'bg-gray-100 dark:bg-gray-700 text-indigo-700 border-indigo-400': activeSection === item.id, 'border-transparent text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-gray-100': activeSection !== item.id}"
                       class="block w-full ps-3 pe-4 py-2 border-l-4 text-base font-medium focus:outline-none focus:text-indigo-800 focus:bg-indigo-100 focus:border-indigo-700 transition duration-150 ease-in-out">
                        <span x-text="item.name"></span>
                    </a>
                </template>
            @endverbatim

        </div>

        {{-- Responsive Links Dashboard (Hanya Muncul Jika Login) --}}
        @auth
            <div class="pt-2 pb-3 space-y-1 border-b dark:border-gray-700"> {{-- WRAPPER UNTUK ADMIN/USER LINKS --}}
                @if (Auth::user()->role === 'admin')
                    {{-- ADMIN LINKS (RESPONSIVE) --}}
                    <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                        <i class="fas fa-home mr-3"></i> {{ __('Dashboard Admin') }}
                    </x-responsive-nav-link>
                    
                    <x-responsive-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.index')">
                        <i class="fas fa-folder mr-3"></i> {{ __('Manajemen Kategori') }}
                    </x-responsive-nav-link>
                    
                    <x-responsive-nav-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.index')">
                        <i class="fas fa-box-open mr-3"></i> {{ __('Manajemen Produk') }}
                    </x-responsive-nav-link>
                    
                    <x-responsive-nav-link :href="route('admin.submissions.index')" :active="request()->routeIs('admin.submissions.index')">
                        <i class="fas fa-file-contract mr-3"></i> {{ __('Pengajuan Kredit') }}
                    </x-responsive-nav-link>
                    
                    <x-responsive-nav-link :href="route('admin.payments.verify.index')" :active="request()->routeIs('admin.payments.verify.index')">
                        <i class="fas fa-shield-alt mr-3"></i> {{ __('Verifikasi Pembayaran') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('admin.reports.index')" :active="request()->routeIs('admin.reports.index')">
                        <i class="fas fa-chart-line mr-3"></i> {{ __('Laporan Transaksi') }}
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

            <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
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