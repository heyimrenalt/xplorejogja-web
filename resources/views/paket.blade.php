<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $wisata ? 'Paket Trip dari ' . $wisata->nama_wisata : 'Semua Paket Trip' }} - XPloreJogja</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

@include('partials.navbar-dinamis')
@include('partials.mobile-search-bar')

<main class="container mx-auto px-6 py-10 max-w-5xl">

    {{-- Back + Judul --}}
    <div class="mb-8">
        <a href="{{ route('home') }}"
           class="inline-flex items-center gap-2 text-cyan-600 font-semibold text-sm hover:underline mb-4">
            <i class="fas fa-arrow-left text-xs"></i> Kembali ke Beranda
        </a>
        <h1 class="text-2xl md:text-3xl font-bold text-gray-900">
            @if($wisata)
                Paket Trip dari <span class="text-cyan-600">{{ $wisata->nama_wisata }}</span>
            @else
                Semua Paket Trip
            @endif
        </h1>
        <p class="text-gray-500 text-sm mt-1">
            <span class="font-semibold text-gray-700">{{ $pakets->count() }}</span> paket tersedia
        </p>
    </div>

    @if($pakets->isEmpty())
    <div class="text-center py-20">
        <i class="fas fa-map-signs text-5xl text-gray-300 mb-4"></i>
        <p class="text-gray-400 text-lg">Belum ada paket tersedia.</p>
        <a href="{{ route('home') }}" class="mt-4 inline-flex items-center gap-2 text-cyan-600 font-semibold text-sm hover:underline">
            <i class="fas fa-arrow-left text-xs"></i> Kembali ke Beranda
        </a>
    </div>
    @else
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
       @foreach($pakets as $paket)
@php
$_paketImages = [asset('images/' . $paket->gambar)];
foreach ($paket->images as $_img) { $_paketImages[] = asset('images/' . $_img->path_gambar); }
$paketData = json_encode([
    'gambar'             => asset('images/' . $paket->gambar),
    'nama_paket'         => $paket->nama_paket,
    'lokasi'             => $paket->lokasi,
    'durasi'             => $paket->durasi,
    'transport'          => $paket->transport,
    'makan'              => $paket->makan,
    'harga'              => $paket->harga,
    'satuan_harga'       => $paket->satuan_harga ?? 'orang',
    'keterangan_harga'   => $paket->keterangan_harga,
    'destinasi_kunjungi' => $paket->destinasi_kunjungi,
    'termasuk'           => $paket->termasuk,
    'images'             => $_paketImages,
], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
@endphp
<div class="rounded-2xl shadow-md hover:shadow-lg transition-shadow overflow-hidden cursor-pointer bg-white"
data-paket='{!! $paketData !!}'
onclick="openPaketModal(JSON.parse(this.dataset.paket))">
            <div style="aspect-ratio:4/3; overflow:hidden;">
                <img src="{{ asset('images/' . $paket->gambar) }}"
                     alt="{{ $paket->nama_paket }}"
                     class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
            </div>
            <div class="p-4">
                <p class="font-semibold text-gray-800 text-sm leading-snug">{{ $paket->nama_paket }}</p>
                @if(!$wisata && $paket->wisata)
                <p class="text-xs text-gray-400 mt-0.5">{{ $paket->wisata->nama_wisata }}</p>
                @endif
                @if($paket->harga)
                <p class="text-cyan-600 font-bold text-sm mt-1">Rp{{ number_format($paket->harga, 0, ',', '.') }}/{{ $paket->satuan_harga ?? 'orang' }}</p>
                @if($paket->keterangan_harga)
                <p class="text-gray-400 text-xs italic mt-0.5">{{ $paket->keterangan_harga }}</p>
                @endif
                @endif
                <div class="flex flex-wrap gap-2 mt-2">
                    @if($paket->durasi)
                    <span class="text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full">
                        <i class="fas fa-clock text-cyan-500 mr-1"></i>{{ $paket->durasi }}
                    </span>
                    @endif
                    @if($paket->transport)
                    <span class="text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full">
                        <i class="fas fa-car-side text-cyan-500 mr-1"></i>{{ $paket->transport }}
                    </span>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

</main>

@include('partials.paket-modal')
@include('partials.footer')
@include('partials.search-script')

</body>
</html>
