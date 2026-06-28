<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $wisata->nama_wisata }} - XPloreJogja</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .swiper-pagination-bullet { background: #ffffff !important; opacity: 0.7; }
        .swiper-pagination-bullet-active { background: #0891b2 !important; opacity: 1; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

@include('partials.navbar-dinamis')

@include('partials.mobile-search-bar')

    <main class="container mx-auto px-6 py-10 max-w-5xl">

        {{-- Slider Gambar --}}
        <section class="w-full mx-auto py-8 relative !max-w-[1080px]">
            <div class="swiper myHeroSwiper rounded-2xl overflow-hidden shadow-lg h-[220px] sm:h-[320px] md:h-[450px]">
                <div class="swiper-wrapper">
                    @foreach(['gambar1', 'gambar2', 'gambar3'] as $img)
                        @if($wisata->$img)
                        <div class="swiper-slide relative">
                            <img src="{{ asset('images/' . $wisata->$img) }}" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                        </div>
                        @endif
                    @endforeach
                </div>
                <div class="swiper-pagination !bottom-6"></div>
            </div>
        </section>

        <h1 class="text-2xl md:text-4xl font-bold text-gray-900 mb-6 md:mb-8">{{ $wisata->nama_wisata }}</h1>

        @if($wisata->deskripsi)
        <div class="bg-white p-5 md:p-10 rounded-3xl shadow-sm border border-gray-100 mb-8 md:mb-12">
            <p class="text-justify text-sm md:text-base leading-relaxed text-gray-600">
                {!! nl2br(e($wisata->deskripsi)) !!}
            </p>
        </div>
        @endif

        {{-- Harga & Lokasi --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 mb-16">
            <div class="border-l-4 border-cyan-100 pl-6">
                <h3 class="font-bold border-b-2 border-gray-800 w-fit mb-5 pb-1">{{ $labelHarga }}</h3>
                <div class="inline-block w-fit bg-cyan-600 text-white py-3 px-6 rounded-xl text-sm font-bold shadow-md">
                    {{ $wisata->harga_tiket }}
                </div>
            </div>

            <div class="border-l-4 border-cyan-100 pl-6">
                <h3 class="font-bold border-b-2 border-gray-800 w-fit mb-5 pb-1">Lokasi</h3>
                <div class="inline-flex w-fit max-w-full bg-cyan-600 text-white p-4 rounded-xl gap-3 text-sm items-start italic shadow-md">
                    <i class="fas fa-map-marker-alt mt-1 shrink-0"></i>
                    <p class="break-words min-w-0">{{ $wisata->alamat_lengkap }}</p>
                </div>
                <div class="flex justify-end mt-2">
                    <a href="{{ $wisata->link_gmaps }}" target="_blank" class="text-cyan-600 font-bold text-sm hover:underline flex items-center gap-2 group">
                        Navigasi <i class="fas fa-chevron-right text-xs group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- Fasilitas --}}
        @if($wisata->fasilitas)
        <div class="mb-16">
            <h3 class="text-2xl font-bold mb-8 flex items-center gap-3">
                <span class="w-8 h-1 bg-cyan-600 rounded-full"></span> Fasilitas
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-x-8 gap-y-10 text-sm border-t border-gray-100 pt-8">
                @foreach(explode(",", $wisata->fasilitas) as $fasil)
                    @if(trim($fasil))
                    <div class="space-y-3">
                        <p class="font-bold flex items-center gap-2 text-gray-800">
                            <i class="fas fa-check-circle text-cyan-600 text-lg"></i> {{ trim($fasil) }}
                        </p>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
        @endif

        {{-- Paket Open Trip (hanya Ojek Wisata, category_id 22) --}}
        @if($wisata->category_id == 22 && isset($pakets) && $pakets->isNotEmpty())
        <div class="mb-16">
            <h3 class="text-2xl font-bold mb-8 flex items-center gap-3">
                <span class="w-8 h-1 bg-cyan-600 rounded-full"></span> Paket Open Trip
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 border-t border-gray-100 pt-8">
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
                        @if($paket->harga)
                        <p class="text-cyan-600 font-bold text-sm mt-1">Rp{{ number_format($paket->harga, 0, ',', '.') }}/{{ $paket->satuan_harga ?? 'orang' }}</p>
                        @if($paket->keterangan_harga)
                        <p class="text-gray-400 text-xs italic mt-0.5">{{ $paket->keterangan_harga }}</p>
                        @endif
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            @if(isset($totalPaket) && $totalPaket > 3)
            <div class="mt-6 text-right">
                <a href="{{ route('paket.index', ['wisata' => $wisata->slug]) }}"
                   class="inline-flex items-center gap-2 text-cyan-600 font-bold text-sm hover:underline">
                    Lihat semua paket <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>
            @endif
        </div>
        @include('partials.paket-modal')
        @endif

        {{-- Sosial Media --}}
        @if($wisata->instagram || $wisata->whatsapp || $wisata->facebook || $wisata->twitter || $wisata->tiktok || $wisata->youtube)
        <div class="mb-16">
            <h3 class="text-2xl font-bold mb-8 flex items-center gap-3">
                <span class="w-8 h-1 bg-cyan-600 rounded-full"></span> Sosial Media
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 border-t border-gray-100 pt-8">
                @if($wisata->instagram)
                <div class="flex items-center gap-3 text-sm text-gray-600 bg-white p-4 rounded-2xl shadow-sm hover:shadow-md transition-shadow">
                    <i class="fab fa-instagram text-xl text-pink-500"></i>
                    <span class="font-medium">{{ $wisata->instagram }}</span>
                </div>
                @endif
                @if($wisata->whatsapp)
                <div class="flex items-center gap-3 text-sm text-gray-600 bg-white p-4 rounded-2xl shadow-sm hover:shadow-md transition-shadow">
                    <i class="fas fa-phone-alt text-lg text-green-500"></i>
                    <span class="font-medium">{{ $wisata->whatsapp }}</span>
                </div>
                @endif
                @if($wisata->facebook)
                <div class="flex items-center gap-3 text-sm text-gray-600 bg-white p-4 rounded-2xl shadow-sm hover:shadow-md transition-shadow">
                    <i class="fab fa-facebook text-xl text-blue-600"></i>
                    <span class="font-medium">{{ $wisata->facebook }}</span>
                </div>
                @endif
                @if($wisata->twitter)
                <div class="flex items-center gap-3 text-sm text-gray-600 bg-white p-4 rounded-2xl shadow-sm hover:shadow-md transition-shadow">
                    <i class="fab fa-twitter text-xl text-cyan-400"></i>
                    <span class="font-medium">{{ $wisata->twitter }}</span>
                </div>
                @endif
                @if($wisata->tiktok)
                <div class="flex items-center gap-3 text-sm text-gray-600 bg-white p-4 rounded-2xl shadow-sm hover:shadow-md transition-shadow">
                    <i class="fab fa-tiktok text-xl text-black"></i>
                    <span class="font-medium">{{ $wisata->tiktok }}</span>
                </div>
                @endif
                @if($wisata->youtube)
                <div class="flex items-center gap-3 text-sm text-gray-600 bg-white p-4 rounded-2xl shadow-sm hover:shadow-md transition-shadow">
                    <i class="fab fa-youtube text-xl text-red-600"></i>
                    <span class="font-medium">{{ $wisata->youtube }}</span>
                </div>
                @endif
            </div>
        </div>
        @endif

        {{-- SECTION ULASAN --}}
        <div class="mb-16">
            <h3 class="text-2xl font-bold mb-4 flex items-center gap-3">
                <span class="w-8 h-1 bg-cyan-600 rounded-full"></span> Ulasan
            </h3>

            @if($totalUlasan > 0)
            <div class="flex items-center gap-4 mb-6 bg-cyan-50 rounded-2xl p-4">
                <div class="text-center">
                    <div class="text-4xl font-bold text-cyan-800">{{ number_format($rataRating, 1) }}</div>
                    <div class="flex gap-1 justify-center mt-1">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= round($rataRating))
                                <i class="fas fa-star text-yellow-400 text-sm"></i>
                            @else
                                <i class="fas fa-star text-gray-300 text-sm"></i>
                            @endif
                        @endfor
                    </div>
                </div>
                <div class="w-px h-12 bg-cyan-200"></div>
                <div>
                    <div class="text-lg font-bold text-gray-800">{{ $totalUlasan }} ulasan</div>
                    <div class="text-xs text-gray-500">dari pengguna yang sudah berkunjung</div>
                </div>
            </div>
            @endif

            <div id="daftar-ulasan" class="flex flex-col gap-4 mb-4">
                @include('partials.ulasan-list', ['ulasans' => $ulasans])
            </div>

            @if($totalUlasan > 5)
            <button id="btn-load-more" onclick="loadMoreUlasan()"
                    class="w-full py-3 border border-cyan-500 text-cyan-700 rounded-xl text-sm font-bold hover:bg-cyan-50 transition mb-8">
                Lihat semua ulasan ({{ $totalUlasan }})
            </button>
            @endif

            @if(session('ulasan_success'))
            <div class="bg-green-50 border border-green-200 text-green-800 rounded-xl p-4 mb-6 text-sm">
                <i class="fas fa-check-circle mr-2"></i>{{ session('ulasan_success') }}
            </div>
            @endif

            <div class="border-t border-gray-100 pt-8">
                <h4 class="text-lg font-bold text-gray-800 mb-5">Tulis Ulasan</h4>
                <form action="{{ route('ulasan.store', $wisata->slug) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl p-4 mb-4 text-sm">
                        <ul class="list-disc ml-4">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="mb-4">
                        <label class="block text-sm text-gray-600 mb-2">Nama</label>
                        <input type="text" name="nama" value="{{ old('nama') }}"
                               class="w-full border border-gray-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-cyan-400"
                               placeholder="Nama kamu">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm text-gray-600 mb-2">Rating</label>
                        <div class="flex gap-2" id="star-container">
                            @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star text-3xl text-gray-300 cursor-pointer star-btn" data-val="{{ $i }}"></i>
                            @endfor
                        </div>
                        <input type="hidden" name="rating" id="rating-input" value="{{ old('rating') }}">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm text-gray-600 mb-2">Ulasan</label>
                        <textarea name="teks" rows="4"
                                  class="w-full border border-gray-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-cyan-400 resize-none"
                                  placeholder="Ceritakan pengalamanmu...">{{ old('teks') }}</textarea>
                    </div>

                    <div class='mb-6'>
                        <label class='block text-sm text-gray-600 mb-2'>Foto (opsional, maks 3 foto)</label>
                        <div class='flex gap-3'>
                            @foreach([1,2,3] as $n)
                            <div style='position: relative; width: 80px; height: 80px;'>
                                <label for='foto-input-{{ $n }}'
                                       style='width:80px; height:80px; border: 1px dashed #d1d5db; border-radius: 12px; display: flex; flex-direction: column; align-items: center; justify-content: center; cursor: pointer; overflow: hidden;'
                                       id='label-container-{{ $n }}'>
                                    <img id='preview-foto-{{ $n }}'
                                         src=''
                                         style='display:none; width:100%; height:100%; object-fit:cover; border-radius:12px;'>
                                    <div id='placeholder-foto-{{ $n }}' style='display:flex; flex-direction:column; align-items:center; justify-content:center; gap:4px;'>
                                        <i class='fas fa-plus text-gray-400 text-lg'></i>
                                        <span style='font-size:10px; color:#9ca3af;'>Foto {{ $n }}</span>
                                    </div>
                                </label>
                                <input type='file'
                                       id='foto-input-{{ $n }}'
                                       name='foto{{ $n }}'
                                       accept='image/jpeg,image/png,image/jpg,image/heic,image/heif,.heic,.heif'
                                       style='display:none;'
                                       onchange='previewFoto(this, {{ $n }})'>
                            </div>
                            @endforeach
                        </div>
                        <p style='font-size:11px; color:#9ca3af; margin-top:6px;'>Format: JPG, PNG, HEIC. Maks 10MB per foto.</p>
                    </div>

                    <button type="submit"
                            class="w-full bg-cyan-600 hover:bg-cyan-700 text-white font-bold py-3 rounded-xl text-sm transition">
                        Kirim Ulasan
                    </button>
                </form>
            </div>
        </div>

    </main>

@include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/heic2any@0.0.4/dist/heic2any.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        const swiper = new Swiper('.myHeroSwiper', {
            loop: true,
            autoplay: { delay: 5000 },
            pagination: { el: '.swiper-pagination', clickable: true },
        });
    </script>
    @include('partials.search-script')
    <script>
    var stars = document.querySelectorAll('.star-btn');
    var ratingInput = document.getElementById('rating-input');
    var currentRating = parseInt(ratingInput ? ratingInput.value : 0) || 0;

    function updateStars(val) {
        stars.forEach(function(s, idx) {
            s.style.color = idx < val ? '#fbbf24' : '#d1d5db';
        });
    }
    updateStars(currentRating);

    stars.forEach(function(s) {
        s.addEventListener('click', function() {
            currentRating = parseInt(this.getAttribute('data-val'));
            ratingInput.value = currentRating;
            updateStars(currentRating);
        });
        s.addEventListener('mouseover', function() {
            updateStars(parseInt(this.getAttribute('data-val')));
        });
        s.addEventListener('mouseout', function() {
            updateStars(currentRating);
        });
    });

    function previewFoto(input, n) {
        var file = input.files && input.files[0];
        if (!file) return;

        var ext  = file.name.split('.').pop().toLowerCase();
        var mime = file.type.toLowerCase();
        var isHeic = ext === 'heic' || ext === 'heif'
                  || mime === 'image/heic' || mime === 'image/heif';

        if (isHeic && typeof heic2any !== 'undefined') {
            var placeholder = document.getElementById('placeholder-foto-' + n);
            if (placeholder) {
                placeholder.innerHTML = '<span style="font-size:9px;color:#6b7280;text-align:center;line-height:1.3;">Mengonversi<br>HEIC...</span>';
            }
            heic2any({ blob: file, toType: 'image/jpeg', quality: 0.85 })
                .then(function(jpgBlob) {
                    var baseName = file.name.replace(/\.(heic|heif)$/i, '');
                    var jpgFile  = new File([jpgBlob], baseName + '.jpg', { type: 'image/jpeg' });
                    try {
                        var dt = new DataTransfer();
                        dt.items.add(jpgFile);
                        input.files = dt.files;
                    } catch (e) { /* DataTransfer tidak didukung, preview tetap jalan */ }
                    var reader = new FileReader();
                    reader.onload = function(ev) {
                        var preview = document.getElementById('preview-foto-' + n);
                        if (preview) { preview.src = ev.target.result; preview.style.display = 'block'; }
                        if (placeholder) { placeholder.style.display = 'none'; }
                    };
                    reader.readAsDataURL(jpgFile);
                })
                .catch(function() {
                    input.value = '';
                    var placeholder = document.getElementById('placeholder-foto-' + n);
                    if (placeholder) {
                        placeholder.innerHTML = '<i class="fas fa-plus text-gray-400 text-lg"></i>'
                            + '<span style="font-size:9px;color:#ef4444;text-align:center;">Gagal.<br>Coba JPG/PNG</span>';
                    }
                });
        } else {
            var reader = new FileReader();
            reader.onload = function(e) {
                var label = document.getElementById('preview-foto-' + n);
                var placeholder = document.getElementById('placeholder-foto-' + n);
                if (label) { label.src = e.target.result; label.style.display = 'block'; }
                if (placeholder) { placeholder.style.display = 'none'; }
            };
            reader.readAsDataURL(file);
        }
    }

    var currentOffset = 5;
    function loadMoreUlasan() {
        var btn = document.getElementById('btn-load-more');
        btn.textContent = 'Memuat...';
        btn.disabled = true;
        fetch('{{ route("ulasan.loadMore", $wisata->slug) }}?offset=' + currentOffset)
            .then(function(r) { return r.json(); })
            .then(function(data) {
                var container = document.getElementById('daftar-ulasan');
                container.insertAdjacentHTML('beforeend', data.html);
                currentOffset += 10;
                if (data.hasMore) {
                    btn.textContent = 'Lihat ulasan berikutnya';
                    btn.disabled = false;
                } else {
                    btn.style.display = 'none';
                }
            })
            .catch(function() {
                btn.textContent = 'Gagal memuat. Coba lagi';
                btn.disabled = false;
            });
    }
    </script>
</body>
</html>
