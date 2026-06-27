{{-- Reusable paket modal. Include once per page, open via openPaketModal(dataObj). --}}
<style>
.pmModalSwiper .swiper-pagination-bullet { background: #fff !important; opacity: 0.7; }
.pmModalSwiper .swiper-pagination-bullet-active { background: #0891b2 !important; opacity: 1; }
</style>

<div id="paket-modal-overlay"
     onclick="closePaketModalOverlay(event)"
     style="display:none; position:fixed; inset:0; z-index:9999; align-items:center; justify-content:center; background:rgba(0,0,0,0.6); padding:16px;">
    <div id="paket-modal-box"
         class="bg-white rounded-2xl w-full max-h-[90vh] overflow-y-auto relative"
         style="max-width:672px;">

        {{-- Hero image / slider (populated by JS) --}}
        <div class="relative">
            <div id="modal-hero-content"></div>
            <button onclick="closePaketModalBtn()"
                    class="absolute top-3 right-3 z-10 flex items-center justify-content text-white transition"
                    style="background:rgba(0,0,0,0.5); border-radius:50%; width:32px; height:32px; display:flex; align-items:center; justify-content:center;">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <div class="p-6">

            {{-- Nama Paket --}}
            <h2 id="modal-nama" class="text-xl font-bold text-gray-900 mb-2"></h2>

            {{-- Lokasi --}}
            <p id="modal-lokasi-wrap" class="flex items-start gap-2 text-sm text-gray-500 mb-5">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-cyan-600 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd" d="M11.54 22.351l.07.04.028.016a.76.76 0 00.723 0l.028-.015.071-.041a16.975 16.975 0 001.144-.742 19.58 19.58 0 002.683-2.282c1.944-2.003 3.5-4.697 3.5-8.327a8 8 0 10-16 0c0 3.63 1.556 6.326 3.5 8.327a19.583 19.583 0 002.682 2.282 16.975 16.975 0 001.145.742zM12 13.5a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
                </svg>
                <span id="modal-lokasi"></span>
            </p>

            {{-- 3 kolom info --}}
            <div class="grid grid-cols-3 gap-3 mb-5">
                <div id="modal-durasi-wrap" class="bg-gray-50 rounded-xl p-3 text-center">
                    <div class="text-cyan-600 mb-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2m6-2a10 10 0 11-20 0 10 10 0 0120 0z"/>
                        </svg>
                    </div>
                    <div class="text-xs text-gray-500 mb-0.5">Durasi</div>
                    <div id="modal-durasi" class="text-sm font-semibold text-gray-800"></div>
                </div>
                <div id="modal-transport-wrap" class="bg-gray-50 rounded-xl p-3 text-center">
                    <div class="text-cyan-600 mb-1">
                        <i class="fas fa-car-side text-xl"></i>
                    </div>
                    <div class="text-xs text-gray-500 mb-0.5">Transport</div>
                    <div id="modal-transport" class="text-sm font-semibold text-gray-800"></div>
                </div>
                <div id="modal-makan-wrap" class="bg-gray-50 rounded-xl p-3 text-center">
                    <div class="text-cyan-600 mb-1">
                        <i class="fas fa-utensils text-xl"></i>
                    </div>
                    <div class="text-xs text-gray-500 mb-0.5">Makan</div>
                    <div id="modal-makan" class="text-sm font-semibold text-gray-800"></div>
                </div>
            </div>

            {{-- Box Harga --}}
            <div id="modal-harga-wrap" class="bg-cyan-50 border border-cyan-100 rounded-xl p-4 mb-5">
                <div class="text-xs text-cyan-700 mb-1">Harga mulai dari</div>
                <div class="flex items-baseline gap-1 flex-wrap">
                    <div id="modal-harga" class="text-2xl font-bold text-cyan-700"></div>
                    <div id="modal-satuan-harga" class="text-sm text-cyan-600"></div>
                </div>
                <div id="modal-keterangan-harga" class="text-xs text-gray-500 italic mt-1" style="display:none;"></div>
            </div>

            {{-- Destinasi yang dikunjungi --}}
            <div id="modal-destinasi-wrap" class="mb-5">
                <h4 class="font-semibold text-gray-800 mb-3">Destinasi yang dikunjungi</h4>
                <div id="modal-destinasi" class="flex flex-wrap gap-2"></div>
            </div>

            {{-- Fasilitas --}}
            <div id="modal-termasuk-wrap">
                <h4 class="font-semibold text-gray-800 mb-3 flex items-center gap-2">
                    <span class="w-3 h-3 bg-green-500 rounded-full inline-block"></span> Fasilitas
                </h4>
                <ul id="modal-termasuk" class="grid grid-cols-2 gap-x-4 gap-y-2 text-sm"></ul>
                <p class="text-xs text-gray-400 italic mt-3">Di luar yang tercantum di atas, dianggap tidak tersedia.</p>
            </div>

        </div>
    </div>
</div>

<script>
var _pmSwiperInstance = null;

function openPaketModal(data) {
    if (_pmSwiperInstance) {
        try { _pmSwiperInstance.destroy(true, true); } catch(e) {}
        _pmSwiperInstance = null;
    }

    var overlay = document.getElementById('paket-modal-overlay');

    var images = data.images || (data.gambar ? [data.gambar] : []);
    var heroContent = document.getElementById('modal-hero-content');

    if (images.length > 1) {
        var slidesHtml = images.map(function(url) {
            return '<div class="swiper-slide"><img src="' + url + '" class="w-full object-cover" style="aspect-ratio:16/9; display:block;"></div>';
        }).join('');
        heroContent.innerHTML = '<div class="swiper pmModalSwiper rounded-t-2xl overflow-hidden" style="aspect-ratio:16/9;">'
            + '<div class="swiper-wrapper">' + slidesHtml + '</div>'
            + '<div class="swiper-pagination" style="bottom:8px;"></div>'
            + '</div>';
        _pmEnsureSwiper(function() {
            setTimeout(function() {
                _pmSwiperInstance = new Swiper('.pmModalSwiper', {
                    loop: true,
                    autoplay: { delay: 4000, disableOnInteraction: false },
                    pagination: { el: '.pmModalSwiper .swiper-pagination', clickable: true },
                });
            }, 50);
        });
    } else {
        heroContent.innerHTML = '<img src="' + (images[0] || '') + '" alt="" class="w-full object-cover rounded-t-2xl" style="aspect-ratio:16/9;">';
    }

    document.getElementById('modal-nama').textContent = data.nama_paket || '';

    var lokasiWrap = document.getElementById('modal-lokasi-wrap');
    document.getElementById('modal-lokasi').textContent = data.lokasi || '';
    lokasiWrap.style.display = data.lokasi ? '' : 'none';

    _pmSetInfoCol('modal-durasi-wrap',    'modal-durasi',    data.durasi);
    _pmSetInfoCol('modal-transport-wrap', 'modal-transport', data.transport);
    _pmSetInfoCol('modal-makan-wrap',     'modal-makan',     data.makan);

    var hargaWrap = document.getElementById('modal-harga-wrap');
    if (data.harga) {
        document.getElementById('modal-harga').textContent = 'Rp' + _pmFormatRibuan(data.harga);
        document.getElementById('modal-satuan-harga').textContent = '/' + (data.satuan_harga || 'orang');
        hargaWrap.style.display = '';
    } else {
        hargaWrap.style.display = 'none';
    }

    var ketEl = document.getElementById('modal-keterangan-harga');
    if (data.keterangan_harga) {
        ketEl.textContent = data.keterangan_harga;
        ketEl.style.display = '';
    } else {
        ketEl.style.display = 'none';
    }

    var destWrap = document.getElementById('modal-destinasi-wrap');
    var destContainer = document.getElementById('modal-destinasi');
    if (data.destinasi_kunjungi) {
        var items = data.destinasi_kunjungi.split('\n').filter(function(s) { return s.trim(); });
        destContainer.innerHTML = items.map(function(item) {
            return '<span class="bg-cyan-50 text-cyan-800 border border-cyan-200 text-xs font-medium px-3 py-1 rounded-full">'
                + _pmEscape(item.trim()) + '</span>';
        }).join('');
        destWrap.style.display = items.length ? '' : 'none';
    } else {
        destWrap.style.display = 'none';
    }

    var fasilitasWrap = document.getElementById('modal-termasuk-wrap');
    var fasilitasList = document.getElementById('modal-termasuk');
    if (data.termasuk) {
        var fItems = data.termasuk.split('\n').filter(function(s) { return s.trim(); });
        fasilitasList.innerHTML = fItems.map(function(item) {
            return '<li class="flex items-start gap-2"><span class="text-green-500 font-bold shrink-0">✓</span><span class="text-gray-600">' + _pmEscape(item.trim()) + '</span></li>';
        }).join('');
        fasilitasWrap.style.display = fItems.length ? '' : 'none';
    } else {
        fasilitasWrap.style.display = 'none';
    }

    overlay.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function _pmSetInfoCol(wrapId, valId, val) {
    document.getElementById(valId).textContent = val || '';
    document.getElementById(wrapId).style.display = val ? '' : 'none';
}

function closePaketModalOverlay(event) {
    if (event.target === document.getElementById('paket-modal-overlay')) {
        closePaketModalBtn();
    }
}

function closePaketModalBtn() {
    if (_pmSwiperInstance) {
        try { _pmSwiperInstance.destroy(true, true); } catch(e) {}
        _pmSwiperInstance = null;
    }
    document.getElementById('paket-modal-overlay').style.display = 'none';
    document.body.style.overflow = '';
}

function _pmFormatRibuan(num) {
    return parseInt(num).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}

function _pmEscape(str) {
    var div = document.createElement('div');
    div.appendChild(document.createTextNode(str));
    return div.innerHTML;
}

function _pmEnsureSwiper(callback) {
    if (typeof Swiper !== 'undefined') { callback(); return; }
    if (!document.querySelector('link[href*="swiper-bundle.min.css"]')) {
        var link = document.createElement('link');
        link.rel = 'stylesheet';
        link.href = 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css';
        document.head.appendChild(link);
    }
    var script = document.createElement('script');
    script.src = 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js';
    script.onload = callback;
    document.head.appendChild(script);
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') { closePaketModalBtn(); }
});
</script>
