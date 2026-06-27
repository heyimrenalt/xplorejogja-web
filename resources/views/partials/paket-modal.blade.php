{{-- Reusable paket modal. Include once per page, open via openPaketModal(dataObj). --}}

<div id="paket-modal-overlay"
     onclick="closePaketModalOverlay(event)"
     style="display:none; position:fixed; inset:0; z-index:9999; align-items:center; justify-content:center; background:rgba(0,0,0,0.6); padding:16px;">
    <div id="paket-modal-box"
         class="bg-white rounded-2xl w-full max-h-[90vh] overflow-y-auto relative"
         style="max-width:672px;">

        {{-- Hero image --}}
        <div class="relative">
            <img id="modal-gambar" src="" alt=""
                 class="w-full object-cover rounded-t-2xl"
                 style="aspect-ratio:16/9;">
            <button onclick="closePaketModalBtn()"
                    class="absolute top-3 right-3 flex items-center justify-center text-white transition"
                    style="background:rgba(0,0,0,0.5); border-radius:50%; width:32px; height:32px;">
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
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                        </svg>
                    </div>
                    <div class="text-xs text-gray-500 mb-0.5">Transport</div>
                    <div id="modal-transport" class="text-sm font-semibold text-gray-800"></div>
                </div>
                <div id="modal-makan-wrap" class="bg-gray-50 rounded-xl p-3 text-center">
                    <div class="text-cyan-600 mb-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <div class="text-xs text-gray-500 mb-0.5">Makan</div>
                    <div id="modal-makan" class="text-sm font-semibold text-gray-800"></div>
                </div>
            </div>

            {{-- Box Harga --}}
            <div id="modal-harga-wrap" class="bg-cyan-50 border border-cyan-100 rounded-xl p-4 mb-5">
                <div class="text-xs text-cyan-700 mb-1">Harga mulai dari</div>
                <div id="modal-harga" class="text-2xl font-bold text-cyan-700"></div>
                <div class="text-xs text-cyan-600">/orang</div>
            </div>

            {{-- Destinasi yang dikunjungi --}}
            <div id="modal-destinasi-wrap" class="mb-5">
                <h4 class="font-semibold text-gray-800 mb-3">Destinasi yang dikunjungi</h4>
                <div id="modal-destinasi" class="flex flex-wrap gap-2"></div>
            </div>

            {{-- Termasuk & Tidak Termasuk --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div id="modal-termasuk-wrap">
                    <h4 class="font-semibold text-gray-800 mb-3 flex items-center gap-2">
                        <span class="w-3 h-3 bg-green-500 rounded-full inline-block"></span> Termasuk
                    </h4>
                    <ul id="modal-termasuk" class="space-y-2 text-sm"></ul>
                </div>
                <div id="modal-tidak-termasuk-wrap">
                    <h4 class="font-semibold text-gray-800 mb-3 flex items-center gap-2">
                        <span class="w-3 h-3 bg-red-400 rounded-full inline-block"></span> Tidak Termasuk
                    </h4>
                    <ul id="modal-tidak-termasuk" class="space-y-2 text-sm"></ul>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
function openPaketModal(data) {
    var overlay = document.getElementById('paket-modal-overlay');

    document.getElementById('modal-gambar').src  = data.gambar || '';
    document.getElementById('modal-nama').textContent = data.nama_paket || '';

    var lokasiWrap = document.getElementById('modal-lokasi-wrap');
    document.getElementById('modal-lokasi').textContent = data.lokasi || '';
    lokasiWrap.style.display = data.lokasi ? '' : 'none';

    _pmSetInfoCol('modal-durasi-wrap',   'modal-durasi',   data.durasi);
    _pmSetInfoCol('modal-transport-wrap','modal-transport', data.transport);
    _pmSetInfoCol('modal-makan-wrap',    'modal-makan',     data.makan);

    var hargaWrap = document.getElementById('modal-harga-wrap');
    if (data.harga) {
        document.getElementById('modal-harga').textContent = 'Rp' + _pmFormatRibuan(data.harga);
        hargaWrap.style.display = '';
    } else {
        hargaWrap.style.display = 'none';
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

    _pmSetChecklist('modal-termasuk-wrap',       'modal-termasuk',       data.termasuk,       'text-green-500', '✓');
    _pmSetChecklist('modal-tidak-termasuk-wrap', 'modal-tidak-termasuk', data.tidak_termasuk, 'text-red-400',   '✗');

    overlay.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function _pmSetInfoCol(wrapId, valId, val) {
    document.getElementById(valId).textContent = val || '';
    document.getElementById(wrapId).style.display = val ? '' : 'none';
}

function _pmSetChecklist(wrapId, listId, text, colorClass, symbol) {
    var wrap = document.getElementById(wrapId);
    var list = document.getElementById(listId);
    if (text) {
        var items = text.split('\n').filter(function(s) { return s.trim(); });
        list.innerHTML = items.map(function(item) {
            return '<li class="flex items-start gap-2"><span class="' + colorClass + ' font-bold shrink-0">'
                + symbol + '</span><span class="text-gray-600">' + _pmEscape(item.trim()) + '</span></li>';
        }).join('');
        wrap.style.display = items.length ? '' : 'none';
    } else {
        wrap.style.display = 'none';
    }
}

function closePaketModalOverlay(event) {
    if (event.target === document.getElementById('paket-modal-overlay')) {
        closePaketModalBtn();
    }
}

function closePaketModalBtn() {
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

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') { closePaketModalBtn(); }
});
</script>
