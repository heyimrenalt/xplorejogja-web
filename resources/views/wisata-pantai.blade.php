<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wisata Pantai - XPloreJogja</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .active-category { background-color: #0891b2; color: white; border-radius: 0.5rem; padding-left: 0.75rem; padding-right: 0.75rem; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

@include('partials.navbar-static', ['activeCategory' => 'wisata-alam'])

@include('partials.mobile-search-bar')

    <main class="container mx-auto px-6 py-10 min-h-screen">
    
    <div class="flex items-center gap-2 mb-8 border-b pb-4">
        <h2 class="text-2xl font-bold text-cyan-800">
            {{ isset($category) ? $category->name : 'Wisata Pantai' }}
        </h2>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

        @forelse($wisatas as $w)
        <a href="{{ route('wisata.detail', $w->slug) }}" class="block bg-white rounded-2xl overflow-hidden shadow-[0_8px_20px_-6px_rgba(0,0,0,0.2)] border border-gray-100 transition hover:-translate-y-1 group min-h-[320px] flex flex-col">
            <div class="h-44 relative">
                <img src="{{ asset('images/' . $w->gambar1) }}" class="w-full h-full object-cover" alt="{{ $w->nama_wisata }}" onerror="this.onerror=null;this.classList.add('hidden')">
            </div>
            <div class="p-4 flex justify-between items-center bg-gray-50/50 mt-auto">
                <div class="flex-1">
                    <h4 class="text-sm font-bold group-hover:text-cyan-600 transition-colors line-clamp-2">{{ $w->nama_wisata }}</h4>
                    <p class="text-xs text-gray-500">{{ $w->alamat_lengkap ?? 'Kab. Yogyakarta' }}</p>
                </div>
                <i class="fas fa-info-circle text-orange-400 shrink-0 ml-2"></i>
            </div>
        </a>
        @empty
        <div class="col-span-full text-center py-12 text-gray-400">
            <i class="fas fa-image fa-2x mb-2"></i>
            <p class="text-sm">Belum ada data di kategori ini.</p>
        </div>
        @endforelse

    </div>
</main>

@include('partials.footer')

@include('partials.search-script')
</body>
</html>