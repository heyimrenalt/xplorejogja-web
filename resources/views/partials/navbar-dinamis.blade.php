<nav class="bg-cyan-700 shadow-sm sticky top-0 z-50 overflow-visible">
    <div class="container mx-auto px-6 py-4 flex justify-between items-center">
        <a href="{{ route('home') }}" class="text-2xl font-bold text-white">XPloreJogja</a>
        <div class="hidden md:block flex-1 max-w-xl mx-10">
            <div class="relative">
                <input type="text" id="inputSearch" placeholder="Cari Destinasi" class="w-full pl-4 pr-10 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500">
                <i class="fas fa-search absolute right-3 top-3 text-gray-400"></i>
                <div id="hasilSearch" class="absolute left-0 right-0 bg-white shadow-xl rounded-lg mt-2 hidden z-50 border border-gray-100 overflow-hidden"></div>
            </div>
        </div>
        <div class="relative" id="nav-kategori-wrapper-dinamis">
            <button id="btn-dropdown-dinamis" class="flex items-center gap-2 font-medium text-white hover:text-white/80">
                Kategori <i class="fas fa-chevron-down text-xs text-white ml-1" aria-hidden="true"></i>
            </button>
            <div id="dropdown-kategori-dinamis" class="absolute right-0 w-52 bg-white shadow-xl rounded-2xl py-2 hidden border border-gray-100 overflow-hidden">
                @php
                    $all_categories = [
                        'Wisata Alam' => [
                            2 => 'Wisata Pantai',
                            3 => 'Wisata Air Terjun',
                            4 => 'Wisata Sungai/Waduk',
                            5 => 'Wisata Hutan',
                            6 => 'Wisata Pegunungan/Bukit',
                            7 => 'Wisata Goa',
                        ],
                        'Hiburan Keluarga' => [
                            9  => 'Taman Bermain',
                            10 => 'Wahana Air',
                            11 => 'Kebun Binatang',
                        ],
                        'Penginapan' => [
                            16 => 'Hotel',
                            17 => 'Villa',
                            18 => 'Homestay',
                        ],
                        'Transportasi' => [
                            20 => 'Sewa Motor',
                            21 => 'Sewa Mobil',
                            22 => 'Ojek Wisata',
                        ],
                        'Kuliner' => [
                            24 => 'Cafe & Resto',
                            25 => 'Kuliner Tradisional',
                            26 => 'Street Food',
                        ],
                        'Blog & Informasi' => [
                            28 => 'Tips Wisata',
                            29 => 'Berita',
                            30 => 'Panduan',
                        ],
                    ];

                    $category_urls = [
                        'Wisata Alam'      => '/wisata-alam',
                        'Hiburan Keluarga' => '/hiburan-kel',
                        'Penginapan'       => '/penginapan',
                        'Transportasi'     => '/transportasi',
                        'Kuliner'          => '/kuliner',
                        'Blog & Informasi' => '/blog-informasi',
                    ];

                    $catId = (int) (optional($wisata ?? null)->category_id ?? 0);
                    $current_parent = 'Wisata Alam';
                    foreach ($all_categories as $parent => $subs) {
                        if (array_key_exists($catId, $subs)) {
                            $current_parent = $parent;
                            break;
                        }
                    }
                    $display_list = $all_categories[$current_parent];
                    $category_url = $category_urls[$current_parent] ?? '/wisata-alam';
                @endphp

                @foreach($display_list as $id => $name)
                    <a href="{{ route('sub-kategori', $id) }}"
                       class="block px-4 py-2 transition-colors duration-200
                       {{ optional($wisata ?? null)->category_id == $id
                          ? 'bg-cyan-600 text-white hover:bg-cyan-50 hover:text-cyan-600'
                          : 'hover:bg-cyan-50 hover:text-cyan-600 text-gray-700' }}">
                       {{ $name }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</nav>
<script>
(function() {
    var wrapper = document.getElementById('nav-kategori-wrapper-dinamis');
    var btn     = document.getElementById('btn-dropdown-dinamis');
    var menu    = document.getElementById('dropdown-kategori-dinamis');
    if (!wrapper || !btn || !menu) return;
    btn.addEventListener('click', function(e) {
        e.stopPropagation();
        menu.classList.toggle('hidden');
    });
    document.addEventListener('click', function() {
        menu.classList.add('hidden');
    });
    menu.addEventListener('click', function(e) { e.stopPropagation(); });
    wrapper.addEventListener('mouseenter', function() { menu.classList.remove('hidden'); });
    wrapper.addEventListener('mouseleave', function() { menu.classList.add('hidden'); });
})();
</script>
