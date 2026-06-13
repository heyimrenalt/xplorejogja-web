<script>
(function () {
    const inputSearch  = document.getElementById('inputSearch');
    const hasilSearch  = document.getElementById('hasilSearch');
    if (!inputSearch || !hasilSearch) return;

    const detailBase   = "{{ route('wisata.detail', ['slug' => '__SLUG__']) }}";
    let   debounceTimer = null;

    function showLoading() {
        hasilSearch.innerHTML = `
            <div class="flex items-center gap-3 px-4 py-3 text-sm text-gray-400">
                <svg class="animate-spin h-4 w-4 text-cyan-500 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                </svg>
                Mencari...
            </div>`;
        hasilSearch.classList.remove('hidden');
    }

    function renderResults(items, keyword) {
        hasilSearch.innerHTML = '';
        if (items.length === 0) {
            hasilSearch.innerHTML = `<div class="px-4 py-3 text-sm text-gray-500 italic">Destinasi "${keyword}" tidak ditemukan...</div>`;
        } else {
            items.forEach(item => {
                const isBlog = item.parent_id == 27;
                const href   = isBlog && item.link_nav ? item.link_nav : detailBase.replace('__SLUG__', item.slug);
                const target = isBlog ? 'target="_blank" rel="noopener"' : '';
                const thumb  = item.gambar
                    ? `<img src="${item.gambar}" class="w-10 h-10 rounded-lg object-cover shrink-0" loading="lazy">`
                    : `<div class="w-10 h-10 rounded-lg bg-cyan-100 flex items-center justify-center shrink-0"><i class="fas fa-image text-cyan-300 text-xs"></i></div>`;

                const div = document.createElement('div');
                div.innerHTML = `
                    <a href="${href}" ${target} class="flex items-center gap-3 px-4 py-3 hover:bg-cyan-50 border-b last:border-0 transition-colors">
                        ${thumb}
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-cyan-800 truncate">${item.nama}</p>
                            <p class="text-xs text-gray-400">${item.kategori}</p>
                        </div>
                    </a>`;
                hasilSearch.appendChild(div);
            });
        }
        hasilSearch.classList.remove('hidden');
    }

    inputSearch.addEventListener('input', (e) => {
        const keyword = e.target.value.trim();
        clearTimeout(debounceTimer);

        if (keyword.length < 2) {
            hasilSearch.classList.add('hidden');
            hasilSearch.innerHTML = '';
            return;
        }

        showLoading();

        debounceTimer = setTimeout(() => {
            fetch(`/api/search?q=${encodeURIComponent(keyword)}`)
                .then(r => r.json())
                .then(data => renderResults(data, keyword))
                .catch(() => {
                    hasilSearch.innerHTML = `<div class="px-4 py-3 text-sm text-red-400 italic">Gagal memuat hasil. Coba lagi.</div>`;
                });
        }, 300);
    });

    document.addEventListener('click', (e) => {
        if (!inputSearch.contains(e.target) && !hasilSearch.contains(e.target)) {
            hasilSearch.classList.add('hidden');
        }
    });
})();

(function () {
    const inputSearchMobile = document.getElementById('inputSearchMobile');
    const hasilSearchMobile = document.getElementById('hasilSearchMobile');
    if (!inputSearchMobile || !hasilSearchMobile) return;

    const detailBase    = "{{ route('wisata.detail', ['slug' => '__SLUG__']) }}";
    let   debounceTimer = null;

    function showLoading() {
        hasilSearchMobile.innerHTML = `
            <div class="flex items-center gap-3 px-4 py-3 text-sm text-gray-400">
                <svg class="animate-spin h-4 w-4 text-cyan-500 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                </svg>
                Mencari...
            </div>`;
        hasilSearchMobile.classList.remove('hidden');
    }

    function renderResults(items, keyword) {
        hasilSearchMobile.innerHTML = '';
        if (items.length === 0) {
            hasilSearchMobile.innerHTML = `<div class="px-4 py-3 text-sm text-gray-500 italic">Destinasi "${keyword}" tidak ditemukan...</div>`;
        } else {
            items.forEach(item => {
                const isBlog = item.parent_id == 27;
                const href   = isBlog && item.link_nav ? item.link_nav : detailBase.replace('__SLUG__', item.slug);
                const target = isBlog ? 'target="_blank" rel="noopener"' : '';
                const thumb  = item.gambar
                    ? `<img src="${item.gambar}" class="w-10 h-10 rounded-lg object-cover shrink-0" loading="lazy">`
                    : `<div class="w-10 h-10 rounded-lg bg-cyan-100 flex items-center justify-center shrink-0"><i class="fas fa-image text-cyan-300 text-xs"></i></div>`;

                const div = document.createElement('div');
                div.innerHTML = `
                    <a href="${href}" ${target} class="flex items-center gap-3 px-4 py-3 hover:bg-cyan-50 border-b last:border-0 transition-colors">
                        ${thumb}
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-cyan-800 truncate">${item.nama}</p>
                            <p class="text-xs text-gray-400">${item.kategori}</p>
                        </div>
                    </a>`;
                hasilSearchMobile.appendChild(div);
            });
        }
        hasilSearchMobile.classList.remove('hidden');
    }

    inputSearchMobile.addEventListener('input', (e) => {
        const keyword = e.target.value.trim();
        clearTimeout(debounceTimer);

        if (keyword.length < 2) {
            hasilSearchMobile.classList.add('hidden');
            hasilSearchMobile.innerHTML = '';
            return;
        }

        showLoading();

        debounceTimer = setTimeout(() => {
            fetch(`/api/search?q=${encodeURIComponent(keyword)}`)
                .then(r => r.json())
                .then(data => renderResults(data, keyword))
                .catch(() => {
                    hasilSearchMobile.innerHTML = `<div class="px-4 py-3 text-sm text-red-400 italic">Gagal memuat hasil. Coba lagi.</div>`;
                });
        }, 300);
    });

    document.addEventListener('click', (e) => {
        if (!inputSearchMobile.contains(e.target) && !hasilSearchMobile.contains(e.target)) {
            hasilSearchMobile.classList.add('hidden');
        }
    });
})();
</script>
