<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $category->name }} - XPloreJogja</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-gray-50 text-gray-800">

@php
$parentRouteMap = [
    1  => ['url' => '/wisata-alam',    'label' => 'Wisata Alam'],
    8  => ['url' => '/hiburan-kel',    'label' => 'Hiburan Keluarga'],
    15 => ['url' => '/penginapan',     'label' => 'Penginapan'],
    19 => ['url' => '/transportasi',   'label' => 'Transportasi'],
    23 => ['url' => '/kuliner',        'label' => 'Kuliner'],
    27 => ['url' => '/blog-informasi', 'label' => 'Blog & Informasi'],
];
@endphp

@php
$parentCatSlugMap = [1 => 'wisata-alam', 8 => 'hiburan-kel', 15 => 'penginapan', 19 => 'transportasi', 23 => 'kuliner', 27 => 'blog-informasi'];
$activeCategorySlug = $parentCatSlugMap[$parentCategory->id] ?? null;
@endphp
@include('partials.navbar-static', ['activeCategory' => $activeCategorySlug])

{{-- Sub-category tab bar --}}
@if($siblings->count() > 1)
<div class="bg-white border-b shadow-sm">
    <div class="container mx-auto px-6 py-3 flex gap-2 overflow-x-auto">
        @foreach($siblings as $sib)
        <a href="{{ route('sub-kategori', $sib->id) }}"
           class="px-4 py-1.5 rounded-full text-sm font-medium whitespace-nowrap transition
                  {{ $sib->id == $category->id
                      ? 'bg-cyan-600 text-white'
                      : 'bg-gray-100 text-gray-600 hover:bg-cyan-50 hover:text-cyan-600' }}">
            {{ $sib->name }}
        </a>
        @endforeach
    </div>
</div>
@endif

<main class="container mx-auto px-6 py-10 min-h-screen">

    <div class="flex items-center gap-2 mb-2">
        <a href="{{ url($parentRouteMap[$parentCategory->id]['url'] ?? '#') }}"
           class="text-sm text-cyan-600 hover:underline">
            {{ $parentCategory->name }}
        </a>
        <i class="fas fa-chevron-right text-xs text-gray-400"></i>
        <span class="text-sm text-gray-500">{{ $category->name }}</span>
    </div>

    <div class="flex items-center gap-2 mb-8 border-b pb-4">
        <h2 class="text-2xl font-bold text-cyan-800">{{ $category->name }}</h2>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($wisatas as $w)
        @if($parentCategory->id == 27)
        <a href="{{ $w->link_sumber ?? '#' }}" target="_blank" rel="noopener noreferrer"
           class="block bg-white rounded-2xl overflow-hidden shadow-[0_8px_20px_-6px_rgba(0,0,0,0.2)] border border-gray-100 transition hover:-translate-y-1 group">
            <div class="h-44 relative">
                <img src="{{ asset('images/' . $w->gambar1) }}"
                     class="w-full h-full object-cover"
                     onerror="this.src='https://placehold.co/400x300?text=No+Image'"
                     alt="{{ $w->nama_wisata }}">
            </div>
            <div class="p-4 flex justify-between items-center bg-gray-50/50">
                <div class="flex-1">
                    <h4 class="text-sm font-bold group-hover:text-cyan-600 transition-colors line-clamp-2">{{ $w->nama_wisata }}</h4>
                    <p class="text-xs text-gray-500">{{ $w->alamat_lengkap ?? 'Yogyakarta' }}</p>
                </div>
                <i class="fas fa-external-link-alt text-orange-400 shrink-0 ml-2"></i>
            </div>
        </a>
        @else
        <a href="{{ route('wisata.detail', $w->slug) }}"
           class="block bg-white rounded-2xl overflow-hidden shadow-[0_8px_20px_-6px_rgba(0,0,0,0.2)] border border-gray-100 transition hover:-translate-y-1 group">
            <div class="h-44 relative">
                <img src="{{ asset('images/' . $w->gambar1) }}"
                     class="w-full h-full object-cover"
                     onerror="this.src='https://placehold.co/400x300?text=No+Image'"
                     alt="{{ $w->nama_wisata }}">
            </div>
            <div class="p-4 flex justify-between items-center bg-gray-50/50">
                <div class="flex-1">
                    <h4 class="text-sm font-bold group-hover:text-cyan-600 transition-colors line-clamp-2">{{ $w->nama_wisata }}</h4>
                    <p class="text-xs text-gray-500">{{ $w->alamat_lengkap ?? 'Yogyakarta' }}</p>
                </div>
                <i class="fas fa-info-circle text-orange-400 shrink-0 ml-2"></i>
            </div>
        </a>
        @endif
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
