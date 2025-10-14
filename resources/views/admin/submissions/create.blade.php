<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Pengajuan Kredit Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
                
                <h3 class="text-2xl font-bold text-gray-800 mb-6">Pilih Produk & Pelanggan</h3>

                <p class="text-gray-600 mb-4">
                    **Perhatian:** Fitur ini tidak digunakan dalam alur verifikasi utama. Admin harusnya memproses pengajuan melalui halaman **Pengajuan Kredit** setelah User mengajukan melalui *landing page*.
                </p>

                <div class="p-4 bg-yellow-50 border border-yellow-300 rounded-lg text-yellow-800">
                    <p class="font-semibold">Fungsionalitas Belum Lengkap:</p>
                    <p class="text-sm">Untuk membuat pengajuan, silakan *login* sebagai **User** dan gunakan tombol **Ajukan Kredit** pada produk di *landing page* (`/`).</p>
                </div>
                
                {{-- Form Dummy --}}
                <form action="#" method="POST" class="mt-8 space-y-4">
                    
                    {{-- Input Pelanggan (Dummy) --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Pilih Pelanggan</label>
                        <select disabled class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm">
                            <option>User A (ID: 1) - Dummy</option>
                        </select>
                    </div>

                    {{-- Input Produk (Dummy) --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Pilih Produk</label>
                        <select disabled class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm">
                            <option>Laptop Acer (ID: 5) - Dummy</option>
                        </select>
                    </div>

                    <button disabled type="submit" class="bg-gray-400 text-white font-bold py-2 px-4 rounded cursor-not-allowed">
                        Buat Pengajuan (Non-Fungsional)
                    </button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>