<section class="py-20 bg-indigo-50 dark:bg-gray-900 overflow-hidden transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-extrabold text-indigo-600 dark:text-indigo-400 mb-4 transition-colors duration-300">
            <i class="fa-solid fa-comments"></i> Apa Kata Pelanggan Kami?
        </h2>
        <p class="text-lg text-gray-600 dark:text-gray-400 mb-10 transition-colors duration-300">
            Banyak orang sudah mewujudkan impiannya bersama CicilAja.
        </p>
    </div>
    
    @php
        // DATA TESTIMONI
        // Saya menghapus key 'bg' dari array PHP karena kita akan mengaturnya via class Tailwind agar responsif dark mode.
        $reviews = [
             ['quote' => "Sepeda motor baru impian saya langsung terwujud. Prosesnya simpel dan tidak ribet sama sekali. Mantap CicilAja!", 'author' => 'Adi P.', 'city' => 'Malang'],
             ['quote' => "Sistem denda transparan, dan notifikasi jatuh temponya sangat membantu. Benar-benar solusi kredit modern.", 'author' => 'Lina H.', 'city' => 'Yogyakarta'],
             ['quote' => "Saya melunasi sisa cicilan lebih awal, dan perhitungannya cepat. Layanan pelunasan dipercepat sangat memuaskan.", 'author' => 'Faiz Nizar N.', 'city' => 'Bd Lampung'],
             ['quote' => "Admin sangat ramah dan membantu saat saya kesulitan upload berkas. Verifikasi cuma butuh 1 jam!", 'author' => 'Rina S.', 'city' => 'Surabaya'],
             ['quote' => "Awalnya ragu kredit online, tapi CicilAja punya kantor jelas dan simulasi yang transparan. Recommended!", 'author' => 'Budi Santoso', 'city' => 'Jakarta'],
        ];
    @endphp

    {{-- MARQUEE WRAPPER --}}
    <div class="relative w-full overflow-hidden [mask-image:linear-gradient(to_right,transparent,white_5%,white_95%,transparent)]">
        
        {{-- INNER SCROLLER --}}
        {{-- Menambahkan class 'group' untuk handling hover pause --}}
        <div class="animate-marquee flex flex-nowrap w-max space-x-6 hover:[animation-play-state:paused]">
            
            {{-- REPEAT 3X agar looping lebih mulus di layar lebar --}}
            @foreach (array_merge($reviews, $reviews, $reviews) as $review) 
                <div class="flex-shrink-0 w-80 md:w-96 p-4">
                    
                    {{-- CARD STYLING --}}
                    {{-- Light: Putih | Dark: Abu-abu agak terang (Gray-800) --}}
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg dark:shadow-gray-900/50 border border-indigo-100 dark:border-gray-700 h-full flex flex-col justify-between transition-all duration-300 hover:scale-105">
                        
                        {{-- Icon Kutip Dekorasi --}}
                        <div class="mb-2 text-indigo-200 dark:text-gray-600 text-3xl">
                            <i class="fa-solid fa-quote-left"></i>
                        </div>

                        <blockquote class="text-gray-700 dark:text-gray-300 italic mb-4 text-left text-sm md:text-base leading-relaxed">
                            "{{ $review['quote'] }}"
                        </blockquote>
                        
                        <div class="border-t border-gray-100 dark:border-gray-700 pt-4 mt-auto">
                            <div class="text-sm font-bold text-indigo-600 dark:text-indigo-400 text-right">
                                — {{ $review['author'] }}
                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-500 text-right">
                                {{ $review['city'] }}
                            </div>
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
        100% { transform: translateX(-33.33%); } /* Bergerak 1/3 karena data di-triple */
    }

    .animate-marquee {
        animation: marquee 60s linear infinite;
        display: flex;
    }
    
    /* Optional: Agar animasi lebih smooth di HP */
    @media (max-width: 768px) {
        .animate-marquee {
            animation-duration: 40s;
        }
    }
</style>