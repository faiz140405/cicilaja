<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-indigo-800 dark:text-indigo-400 leading-tight transition-colors duration-300">
            {{ __('Tambah Produk Baru') }}
        </h2>
    </x-slot>

    <div class="py-12 transition-colors duration-300">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-8 border border-gray-200 dark:border-gray-700 transition-colors duration-300">
                
                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf {{-- Jangan lupa CSRF token --}}
                    
                    {{-- Pastikan file 'admin.products.form' nanti juga sudah support dark mode --}}
                    @include('admin.products.form')

                    <div class="mt-8 flex items-center">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded transition duration-300 shadow-md">
                            Simpan Produk
                        </button>
                        
                        <a href="{{ route('admin.products.index') }}" class="ml-4 text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition duration-300 font-medium">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>