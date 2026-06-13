<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $category->name ?? 'Penginapan' }} - XPloreJogja</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-gray-50 text-gray-800">

@include('partials.navbar-static', ['activeCategory' => 'penginapan'])

@include('partials.mobile-search-bar')

<main class="container mx-auto px-6 py-10 min-h-screen">

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-cyan-800">{{ $category->name ?? 'Penginapan' }}</h1>
        <p class="text-gray-500 text-sm mt-1">Temukan pilihan terbaik di Yogyakarta</p>
    </div>

    @if($subKategoris->count())
        @foreach($subKategoris as $sub)
        <section class="mb-12">
            <div class="flex items-center gap-2 mb-6 border-b pb-2">
                <a href="{{ route('sub-kategori', $sub->id) }}" class="flex items-center gap-2 group">
                    <h2 class="text-xl font-bold text-cyan-800 group-hover:text-cyan-600 transition-colors">{{ $sub->name }}</h2>
                    <i class="fas fa-chevron-right text-cyan-600 text-sm mt-1 group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @forelse($sub->wisatas->take(3) as $wisata)
                <a href="{{ route('wisata.detail', $wisata->slug) }}"
                   class="block bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 hover:-translate-y-1 transition group">
                    <div class="h-44">
                        <img src="{{ asset('images/' . $wisata->gambar1) }}" class="w-full h-full object-cover"
                             onerror="this.src='https://placehold.co/400x300?text=No+Image'">
                    </div>
                    <div class="p-4 flex justify-between items-center bg-gray-50/50">
                        <div>
                            <h4 class="text-sm font-bold group-hover:text-cyan-600 transition-colors">{{ $wisata->nama_wisata }}</h4>
                            <p class="text-xs text-gray-500">{{ $wisata->alamat_lengkap ?? 'Yogyakarta' }}</p>
                        </div>
                        <i class="fas fa-info-circle text-orange-400"></i>
                    </div>
                </a>
                @empty
                <div class="col-span-1 md:col-span-3 text-center py-8 text-gray-400">
                    <i class="fas fa-image fa-2x mb-2"></i>
                    <p class="text-sm">Belum ada data di kategori ini.</p>
                </div>
                @endforelse
            </div>
        </section>
        @endforeach

    @elseif($wisatas->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($wisatas as $wisata)
            <a href="{{ route('wisata.detail', $wisata->slug) }}"
               class="block bg-white rounded-2xl overflow-hidden shadow-[0_8px_20px_-6px_rgba(0,0,0,0.2)] border border-gray-100 transition hover:-translate-y-1 group">
                <div class="h-44">
                    <img src="{{ asset('images/' . $wisata->gambar1) }}" class="w-full h-full object-cover"
                         onerror="this.src='https://placehold.co/400x300?text=No+Image'">
                </div>
                <div class="p-4 flex justify-between items-center bg-gray-50/50">
                    <div>
                        <h4 class="text-sm font-bold group-hover:text-cyan-600 transition-colors">{{ $wisata->nama_wisata }}</h4>
                        <p class="text-xs text-gray-500">{{ $wisata->alamat_lengkap ?? 'Yogyakarta' }}</p>
                    </div>
                    <i class="fas fa-info-circle text-orange-400"></i>
                </div>
            </a>
            @endforeach
        </div>

    @else
        <div class="text-center py-20 text-gray-400">
            <i class="fas fa-search fa-3x mb-4"></i>
            <p>Belum ada data tersedia.</p>
        </div>
    @endif

</main>

@include('partials.footer')

@include('partials.search-script')
</body>
</html>
