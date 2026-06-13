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

        <div class="relative" id="nav-kategori-wrapper-static">
            <button id="btn-dropdown-static" class="flex items-center gap-2 font-medium text-white hover:text-white/80">
                Kategori <i class="fas fa-chevron-down text-xs text-white ml-1" aria-hidden="true"></i>
            </button>
            @php $cat = $activeCategory ?? null; @endphp
            <div id="dropdown-kategori-static" class="absolute right-0 w-48 bg-white shadow-xl rounded-xl py-2 hidden border border-gray-100 overflow-hidden">
                <a href="{{ url('/wisata-alam') }}"    class="block px-4 py-2 {{ $cat === 'wisata-alam'    ? 'bg-cyan-600 text-white' : 'hover:bg-cyan-50 hover:text-cyan-600' }}">Wisata Alam</a>
                <a href="{{ url('/hiburan-kel') }}"    class="block px-4 py-2 {{ $cat === 'hiburan-kel'    ? 'bg-cyan-600 text-white' : 'hover:bg-cyan-50 hover:text-cyan-600' }}">Hiburan Keluarga</a>
                <a href="{{ url('/penginapan') }}"     class="block px-4 py-2 {{ $cat === 'penginapan'     ? 'bg-cyan-600 text-white' : 'hover:bg-cyan-50 hover:text-cyan-600' }}">Penginapan</a>
                <a href="{{ url('/transportasi') }}"   class="block px-4 py-2 {{ $cat === 'transportasi'   ? 'bg-cyan-600 text-white' : 'hover:bg-cyan-50 hover:text-cyan-600' }}">Transportasi</a>
                <a href="{{ url('/kuliner') }}"        class="block px-4 py-2 {{ $cat === 'kuliner'        ? 'bg-cyan-600 text-white' : 'hover:bg-cyan-50 hover:text-cyan-600' }}">Kuliner</a>
                <a href="{{ url('/blog-informasi') }}" class="block px-4 py-2 {{ $cat === 'blog-informasi' ? 'bg-cyan-600 text-white' : 'hover:bg-cyan-50 hover:text-cyan-600' }}">Blog & Informasi</a>
            </div>
        </div>
    </div>
</nav>
<script>
(function() {
    var wrapper = document.getElementById('nav-kategori-wrapper-static');
    var btn     = document.getElementById('btn-dropdown-static');
    var menu    = document.getElementById('dropdown-kategori-static');
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
