<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wisata Alam - XPloreJogja</title>
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

    @forelse($subKategoris as $sub)
    <section class="mb-12">
        <div class="flex items-center gap-2 mb-6 border-b pb-2">
            <a href="{{ route('sub-kategori', $sub->id) }}" class="flex items-center gap-2 group">
                <h2 class="text-xl font-bold text-cyan-800 group-hover:text-cyan-600 transition-colors">
                    {{ $sub->name }}
                </h2>
                <i class="fas fa-chevron-right text-cyan-600 text-sm mt-1"></i>
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($sub->wisatas as $wisata)
            <a href="{{ route('wisata.detail', $wisata->slug) }}"
               class="block bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 hover:-translate-y-1 transition group">
                <div class="h-44">
                    <img src="{{ asset('images/' . $wisata->gambar1) }}"
                         class="w-full h-full object-cover"
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
                <p class="text-sm">Belum ada wisata di kategori ini.</p>
            </div>
            @endforelse
        </div>
    </section>
    @empty
    <p class="text-center text-gray-400">Tidak ada kategori ditemukan.</p>
    @endforelse

</main>

@include('partials.footer')

    @include('partials.search-script')
</body>
</html>