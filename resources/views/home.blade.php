<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XPloreJogja - Halaman Utama</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .active-category { background-color: #0891b2; color: white; }
        .group:hover .group-hover\:scale-110 { transform: none !important; }
        .card {
            width: 100%;
            
            max-width: 250px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            text-align: center;
        }
        .swiper-pagination-bullet {
            background: #ffffff !important;
             opacity: 0.7;
        }
        .swiper-pagination-bullet-active {
            background: #0891b2 !important; 
            opacity: 1;
}
    </style>
</head>
<body class="bg-gray-50">

@include('partials.navbar-static', ['activeCategory' => null])

@include('partials.mobile-search-bar')

@if($pamflets->isNotEmpty())
<section class="container mx-auto px-4 sm:px-6 py-6 sm:py-8 relative max-w-[1080px]">

    <div class="swiper myHeroSwiper rounded-2xl overflow-hidden shadow-lg
                h-[220px] sm:h-[300px] md:h-[400px] lg:h-[480px]">

        <div class="swiper-wrapper">
            @foreach($pamflets as $pamflet)
            <div class="swiper-slide relative h-full">
                <img src="{{ asset('images/' . $pamflet->gambar) }}" class="w-full h-full object-cover object-center">
                <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
            </div>
            @endforeach
        </div>

        <div class="swiper-pagination !bottom-3 sm:!bottom-5"></div>

    </div>

</section>
@else
<section class="container mx-auto px-4 sm:px-6 py-6 sm:py-8 max-w-[1080px]">
    <div class="flex flex-col items-center justify-center bg-gray-50 border-2 border-dashed border-gray-300 rounded-2xl h-[220px] sm:h-[300px] md:h-[400px] lg:h-[480px]">
        <i class="fas fa-image text-gray-400 text-5xl mb-4"></i>
        <p class="text-gray-500 italic">Banner belum tersedia</p>
        <p class="text-gray-400 text-xs mt-1">Admin belum mengupload banner promosi</p>
    </div>
</section>
@endif

@if($wisataPopuler->isNotEmpty())
<section class="container mx-auto px-6 py-10">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-cyan-800">Destinasi Populer</h1>
    </div>

    @php $showArrows = $wisataPopuler->count() > 4; @endphp
    <div class="relative {{ $showArrows ? 'px-16' : '' }}">
        <div class="nature-swiper swiper overflow-hidden">
            <div class="swiper-wrapper py-8">
                @foreach($wisataPopuler as $wp)
                <div class="swiper-slide flex justify-center">
                    <a href="{{ route('wisata.detail', $wp->slug) }}"
                       class="block card rounded-2xl overflow-hidden border border-gray-100 transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                        <div class="h-36 overflow-hidden">
                            <img src="{{ asset('images/' . $wp->gambar1) }}"
                                 class="w-full h-full object-cover object-center">
                        </div>
                        <div class="p-2 text-center bg-white">
                            <p class="text-xs font-bold text-cyan-700 truncate px-1">{{ $wp->nama_wisata }}</p>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>

        @if($showArrows)
        <div class="nature-swiper-button-prev absolute left-0 top-1/2 -translate-y-1/2 z-30 cursor-pointer text-white bg-cyan-600 shadow-2xl rounded-full w-12 h-12 flex items-center justify-center hover:bg-cyan-700 transition-all border-2 border-white select-none">
            <span class="text-5xl font-family mb-1 leading-none mr-0.5">‹</span>
        </div>

        <div class="nature-swiper-button-next absolute right-0 top-1/2 -translate-y-1/2 z-30 cursor-pointer text-white bg-cyan-600 shadow-2xl rounded-full w-12 h-12 flex items-center justify-center hover:bg-cyan-700 transition-all border-2 border-white select-none">
            <span class="text-5xl font-family mb-1 leading-none ml-0.5">›</span>
        </div>
        @endif
    </div>
</section>
@else
<section class="container mx-auto px-6 py-10">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-cyan-800">Destinasi Populer</h1>
    </div>
    <div class="flex flex-col items-center justify-center bg-gray-50 border-2 border-dashed border-gray-300 rounded-2xl py-12 px-6">
        <i class="fas fa-star text-gray-400 text-4xl mb-4"></i>
        <p class="text-gray-500 italic">Destinasi populer belum tersedia</p>
        <p class="text-gray-400 text-xs mt-1">Belum ada destinasi yang ditandai sebagai populer</p>
    </div>
</section>
@endif

    <section class="container mx-auto px-4 md:px-6 py-12 flex flex-col md:flex-row gap-8 lg:gap-12 items-center">
    <div class="w-full md:w-1/3">
        <img src="{{ $deskripsiKota && $deskripsiKota->gambar ? asset('images/' . $deskripsiKota->gambar) : asset('img/GambarTugu.jpg') }}"
             class="w-full h-auto rounded-2xl shadow-lg border-4 md:border-8 border-white object-cover"
             onerror="this.src='{{ asset('img/GambarTugu.jpg') }}'">
    </div>
    <div class="w-full md:w-2/3 bg-white p-6 md:p-10 rounded-3xl shadow-sm border border-gray-100">
        <p class="text-justify text-sm md:text-base leading-relaxed text-gray-600">
            {{ $deskripsiKota ? $deskripsiKota->teks : 'Deskripsi kota belum tersedia.' }}
        </p>
    </div>
</section>

<section class="container mx-auto px-6 py-10">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-xl font-bold text-cyan-800">Wisata Alam</h3>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @if($wisataAlam->isNotEmpty())
            @foreach($wisataAlam as $wisata)
            <a href="{{ route('wisata.detail', $wisata->slug) }}" class="block bg-white rounded-2xl overflow-hidden transition-all duration-300 hover:-translate-y-2 shadow-[0_10px_25px_-5px_rgba(0,0,0,0.1),0_8px_10px_-6px_rgba(0,0,0,0.1)] hover:shadow-[0_20px_25px_-5px_rgba(0,0,0,0.2),0_10px_10px_-5px_rgba(0,0,0,0.1)] group border border-gray-50">
                <div class="h-36 sm:h-44 overflow-hidden">
                    <img src="{{ asset('images/' . $wisata->gambar1) }}" class="w-full h-full object-cover object-center transition duration-300">
                </div>
                <div class="p-4 text-center bg-white">
                    <h4 class="text-sm font-bold text-cyan-600 group-hover:text-cyan-800 transition-colors">{{ $wisata->nama_wisata }}</h4>
                </div>
            </a>
            @endforeach
        @else
            <div class="col-span-full flex flex-col items-center justify-center bg-gray-50 border-2 border-dashed border-gray-300 rounded-2xl py-12">
                <i class="fas fa-image text-gray-400 text-4xl mb-4"></i>
                <p class="text-gray-500 italic">Belum ada data di kategori ini</p>
            </div>
        @endif
    </div>
    <div class="flex justify-end mt-6">
        <button onclick="window.location.href='{{ url('/wisata-alam') }}'" class="bg-cyan-600 hover:bg-cyan-700 text-white px-6 py-2 rounded-lg text-xs font-bold shadow-md transition-all active:scale-95">
            Selengkapnya
        </button>
    </div>
</section>

<section class="container mx-auto px-6 py-10">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-xl font-bold text-cyan-800">Hiburan Keluarga</h3>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @if($hiburanKel->isNotEmpty())
            @foreach($hiburanKel as $wisata)
            <a href="{{ route('wisata.detail', $wisata->slug) }}" class="block bg-white rounded-2xl overflow-hidden transition-all duration-300 hover:-translate-y-2 shadow-[0_10px_25px_-5px_rgba(0,0,0,0.1),0_8px_10px_-6px_rgba(0,0,0,0.1)] hover:shadow-[0_20px_25px_-5px_rgba(0,0,0,0.2),0_10px_10px_-5px_rgba(0,0,0,0.1)] group border border-gray-50">
                <div class="h-36 sm:h-44 overflow-hidden">
                    <img src="{{ asset('images/' . $wisata->gambar1) }}" class="w-full h-full object-cover object-center transition duration-300">
                </div>
                <div class="p-4 text-center bg-white">
                    <h4 class="text-sm font-bold text-cyan-600 group-hover:text-cyan-800 transition-colors">{{ $wisata->nama_wisata }}</h4>
                </div>
            </a>
            @endforeach
        @else
            <div class="col-span-full flex flex-col items-center justify-center bg-gray-50 border-2 border-dashed border-gray-300 rounded-2xl py-12">
                <i class="fas fa-image text-gray-400 text-4xl mb-4"></i>
                <p class="text-gray-500 italic">Belum ada data di kategori ini</p>
            </div>
        @endif
    </div>
    <div class="flex justify-end mt-6">
        <button onclick="window.location.href='{{ url('/hiburan-kel') }}'" class="bg-cyan-600 hover:bg-cyan-700 text-white px-6 py-2 rounded-lg text-xs font-bold shadow-md transition-all active:scale-95">
            Selengkapnya
        </button>
    </div>
</section>

<section class="container mx-auto px-6 py-10">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-xl font-bold text-cyan-800">Penginapan</h3>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @if($penginapan->isNotEmpty())
            @foreach($penginapan as $wisata)
            <a href="{{ route('wisata.detail', $wisata->slug) }}" class="block bg-white rounded-2xl overflow-hidden transition-all duration-300 hover:-translate-y-2 shadow-[0_10px_25px_-5px_rgba(0,0,0,0.1),0_8px_10px_-6px_rgba(0,0,0,0.1)] hover:shadow-[0_20px_25px_-5px_rgba(0,0,0,0.2),0_10px_10px_-5px_rgba(0,0,0,0.1)] group border border-gray-50">
                <div class="h-36 sm:h-44 overflow-hidden">
                    <img src="{{ asset('images/' . $wisata->gambar1) }}" class="w-full h-full object-cover object-center transition duration-300">
                </div>
                <div class="p-4 text-center bg-white">
                    <h4 class="text-sm font-bold text-cyan-600 group-hover:text-cyan-800 transition-colors">{{ $wisata->nama_wisata }}</h4>
                </div>
            </a>
            @endforeach
        @else
            <div class="col-span-full flex flex-col items-center justify-center bg-gray-50 border-2 border-dashed border-gray-300 rounded-2xl py-12">
                <i class="fas fa-image text-gray-400 text-4xl mb-4"></i>
                <p class="text-gray-500 italic">Belum ada data di kategori ini</p>
            </div>
        @endif
    </div>
    <div class="flex justify-end mt-6">
        <button onclick="window.location.href='{{ url('/penginapan') }}'" class="bg-cyan-600 hover:bg-cyan-700 text-white px-6 py-2 rounded-lg text-xs font-bold shadow-md transition-all active:scale-95">
            Selengkapnya
        </button>
    </div>
</section>

<section class="container mx-auto px-6 py-10">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-xl font-bold text-cyan-800">Transportasi</h3>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @if($transportasi->isNotEmpty())
            @foreach($transportasi as $wisata)
            <a href="{{ route('wisata.detail', $wisata->slug) }}" class="block bg-white rounded-2xl overflow-hidden transition-all duration-300 hover:-translate-y-2 shadow-[0_10px_25px_-5px_rgba(0,0,0,0.1),0_8px_10px_-6px_rgba(0,0,0,0.1)] hover:shadow-[0_20px_25px_-5px_rgba(0,0,0,0.2),0_10px_10px_-5px_rgba(0,0,0,0.1)] group border border-gray-50">
                <div class="h-36 sm:h-44 overflow-hidden">
                    <img src="{{ asset('images/' . $wisata->gambar1) }}" class="w-full h-full object-cover object-center transition duration-300">
                </div>
                <div class="p-4 text-center bg-white">
                    <h4 class="text-sm font-bold text-cyan-600 group-hover:text-cyan-800 transition-colors">{{ $wisata->nama_wisata }}</h4>
                </div>
            </a>
            @endforeach
        @else
            <div class="col-span-full flex flex-col items-center justify-center bg-gray-50 border-2 border-dashed border-gray-300 rounded-2xl py-12">
                <i class="fas fa-image text-gray-400 text-4xl mb-4"></i>
                <p class="text-gray-500 italic">Belum ada data di kategori ini</p>
            </div>
        @endif
    </div>
    <div class="flex justify-end mt-6">
        <button onclick="window.location.href='{{ url('/transportasi') }}'" class="bg-cyan-600 hover:bg-cyan-700 text-white px-6 py-2 rounded-lg text-xs font-bold shadow-md transition-all active:scale-95">
            Selengkapnya
        </button>
    </div>
</section>

<section class="container mx-auto px-6 py-10">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-xl font-bold text-cyan-800">Kuliner</h3>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @if($kuliner->isNotEmpty())
            @foreach($kuliner as $wisata)
            <a href="{{ route('wisata.detail', $wisata->slug) }}" class="block bg-white rounded-2xl overflow-hidden transition-all duration-300 hover:-translate-y-2 shadow-[0_10px_25px_-5px_rgba(0,0,0,0.1),0_8px_10px_-6px_rgba(0,0,0,0.1)] hover:shadow-[0_20px_25px_-5px_rgba(0,0,0,0.2),0_10px_10px_-5px_rgba(0,0,0,0.1)] group border border-gray-50">
                <div class="h-36 sm:h-44 overflow-hidden">
                    <img src="{{ asset('images/' . $wisata->gambar1) }}" class="w-full h-full object-cover object-center transition duration-300">
                </div>
                <div class="p-4 text-center bg-white">
                    <h4 class="text-sm font-bold text-cyan-600 group-hover:text-cyan-800 transition-colors">{{ $wisata->nama_wisata }}</h4>
                </div>
            </a>
            @endforeach
        @else
            <div class="col-span-full flex flex-col items-center justify-center bg-gray-50 border-2 border-dashed border-gray-300 rounded-2xl py-12">
                <i class="fas fa-image text-gray-400 text-4xl mb-4"></i>
                <p class="text-gray-500 italic">Belum ada data di kategori ini</p>
            </div>
        @endif
    </div>
    <div class="flex justify-end mt-6">
        <button onclick="window.location.href='{{ url('/kuliner') }}'" class="bg-cyan-600 hover:bg-cyan-700 text-white px-6 py-2 rounded-lg text-xs font-bold shadow-md transition-all active:scale-95">
            Selengkapnya
        </button>
    </div>
</section>

<section class="container mx-auto px-6 py-10">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-xl font-bold text-cyan-800">Blog & Informasi</h3>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @if($blogInformasi->isNotEmpty())
            @foreach($blogInformasi as $wisata)
            @php
                $blogHref = $wisata->link_navigasi;
                if ($blogHref && strpos($blogHref, 'http') !== 0) {
                    $blogHref = 'https://' . $blogHref;
                }
                $hasLink = !empty($blogHref);
            @endphp
            @if($hasLink)
            <a href="{{ $blogHref }}" target="_blank" rel="noopener noreferrer" class="block bg-white rounded-2xl overflow-hidden transition-all duration-300 hover:-translate-y-2 shadow-[0_10px_25px_-5px_rgba(0,0,0,0.1),0_8px_10px_-6px_rgba(0,0,0,0.1)] hover:shadow-[0_20px_25px_-5px_rgba(0,0,0,0.2),0_10px_10px_-5px_rgba(0,0,0,0.1)] group border border-gray-50">
                <div class="h-36 sm:h-44 overflow-hidden">
                    <img src="{{ asset('images/' . $wisata->gambar1) }}" class="w-full h-full object-cover object-center transition duration-300">
                </div>
                <div class="p-4 text-center bg-white">
                    <h4 class="text-sm font-bold text-cyan-600 group-hover:text-cyan-800 transition-colors">{{ $wisata->nama_wisata }}</h4>
                </div>
            </a>
            @else
            <div class="block bg-white rounded-2xl overflow-hidden border border-gray-50 opacity-60 cursor-not-allowed shadow-[0_10px_25px_-5px_rgba(0,0,0,0.1),0_8px_10px_-6px_rgba(0,0,0,0.1)]">
                <div class="h-36 sm:h-44 overflow-hidden">
                    <img src="{{ asset('images/' . $wisata->gambar1) }}" class="w-full h-full object-cover object-center">
                </div>
                <div class="p-4 text-center bg-white">
                    <h4 class="text-sm font-bold text-gray-400">{{ $wisata->nama_wisata }}</h4>
                    <p class="text-xs text-gray-300 mt-1">Link belum tersedia</p>
                </div>
            </div>
            @endif
            @endforeach
        @else
            <div class="col-span-full flex flex-col items-center justify-center bg-gray-50 border-2 border-dashed border-gray-300 rounded-2xl py-12">
                <i class="fas fa-image text-gray-400 text-4xl mb-4"></i>
                <p class="text-gray-500 italic">Belum ada data di kategori ini</p>
            </div>
        @endif
    </div>
    <div class="flex justify-end mt-6">
        <button onclick="window.location.href='{{ url('/blog-informasi') }}'" class="bg-cyan-600 hover:bg-cyan-700 text-white px-6 py-2 rounded-lg text-xs font-bold shadow-md transition-all active:scale-95">
            Selengkapnya
        </button>
    </div>
</section>

@include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
    const swiper = new Swiper('.myHeroSwiper', {
        loop: true,
        autoplay: {
            delay: 5000, 
            disableOnInteraction: false, 
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true, 
        },
        speed: 800, 
    });
</script>
<script>
    const populerCount = {{ $wisataPopuler->count() }};
    const natureSwiper = new Swiper('.nature-swiper', {
        slidesPerView: 4,
        spaceBetween: 20,
        navigation: populerCount > 4 ? {
            nextEl: '.nature-swiper-button-next',
            prevEl: '.nature-swiper-button-prev',
        } : false,
        breakpoints: {
            320: { slidesPerView: 1 },
            768: { slidesPerView: 2 },
            1024: { slidesPerView: 4 }
        }
    });
</script>
@include('partials.search-script')
</body>
</html>