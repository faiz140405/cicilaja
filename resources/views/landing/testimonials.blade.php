<section class="py-20 bg-indigo-50 dark:bg-gray-800 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-4">Apa Kata Pelanggan Kami?</h2>
        <p class="text-lg text-gray-600 dark:text-gray-400 mb-10">Banyak orangsudah mewujudkan impiannya bersama CicilAja.</p>
    </div>
    
    @php
        // HARDCODED TESTIMONI DATA
        $reviews = [
            // ['quote' => "Prosesnya super cepat! Saya mengajukan laptop, besoknya sudah disetujui. Cicilannya pun ringan. Sangat direkomendasikan!", 'author' => 'Risa M.', 'city' => 'Jakarta', 'bg' => 'bg-white'],
            // ['quote' => "Awalnya ragu, tapi pelayanan Admin sangat responsif. Bukti pembayaran langsung diverifikasi. Transaksi jadi aman dan nyaman.", 'author' => 'Budi S.', 'city' => 'Surabaya', 'bg' => 'bg-white'],
            // ['quote' => "Dapat diskon 10% untuk kulkas baru! Perhitungannya jelas di awal, tidak ada biaya tersembunyi. Terbaik!", 'author' => 'Siti A.', 'city' => 'Bandung', 'bg' => 'bg-white'],
            ['quote' => "Sepeda motor baru impian saya langsung terwujud. Prosesnya simpel dan tidak ribet sama sekali. Mantap CicilAja!", 'author' => 'Adi P.', 'city' => 'Malang', 'bg' => 'bg-white'],
            ['quote' => "Sistem denda transparan, dan notifikasi jatuh temponya sangat membantu. Benar-benar solusi kredit modern.", 'author' => 'Lina H.', 'city' => 'Yogyakarta', 'bg' => 'bg-white'],
            ['quote' => "Saya melunasi sisa cicilan lebih awal, dan perhitungannya cepat. Layanan pelunasan dipercepat sangat memuaskan.", 'author' => 'Faiz Nizar N.', 'city' => 'Bd Lampung', 'bg' => 'bg-white'],
        ];
    @endphp

    {{-- MARQUEE WRAPPER --}}
    {{-- 'overflow-hidden' pada section utama dan 'w-full' pada wrapper luar --}}
    <div class="relative w-full overflow-hidden [mask-image:linear-gradient(to_right,transparent,white_8%,white_92%,transparent)]">
        
        {{-- INNER SCROLLER: Mengandung dua set data identik --}}
        {{-- Gunakan w-max dan flex-nowrap agar semua card berada dalam satu baris --}}
        <div class="animate-marquee flex flex-nowrap w-max space-x-6">
            
            {{-- REPEAT 2X untuk efek looping tanpa jeda --}}
            @foreach (array_merge($reviews, $reviews) as $review) 
                <div class="flex-shrink-0 w-80 md:w-96 p-4">
                    <div class="{{ $review['bg'] }} p-6 rounded-xl shadow-xl border border-indigo-200 h-full flex flex-col justify-between">
                        <blockquote class="text-gray-700 italic mb-4 h-24 text-left">
                            "{{ $review['quote'] }}"
                        </blockquote>
                        <div class="text-sm font-semibold text-indigo-600 text-right mt-auto">
                            — {{ $review['author'] }}, {{ $review['city'] }}
                        </div>
                    </div>
                </div>
            @endforeach
            
        </div>
    </div>
</section>
<style>
    @keyframes marquee {
    0% { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}

.animate-marquee {
    animation: marquee 60s linear infinite;
    display: flex;
}
</style>