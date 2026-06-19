<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $parentCategory->name }} - Admin XPloreJogja</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { background: #f4f6f9; font-family: 'Poppins', sans-serif; }
        .page-header {
            background: #ffffff;
            border-bottom: 1px solid #e5e7eb;
            padding: 0.65rem 1.25rem;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .page-header h5 { color: #0e7490; font-weight: 700; }
        .page-header .fas.fa-map-marked-alt { color: #0e7490; }
        .subtab-panel { display: none; }
        .subtab-panel.active { display: block; }

        .btn-toggle-populer {
            background: none; border: none;
            padding: 2px 4px; cursor: pointer; line-height: 1;
        }
        .btn-toggle-populer:hover { opacity: 0.75; }
        .btn-toggle-populer:disabled { opacity: 0.4; cursor: default; }

        tr.wisata-row.is-populer { background: #fffdf0; }

        .btn-primary  { background: #0891b2 !important; border-color: #0891b2 !important; color: #fff !important; }
        .btn-primary:hover  { background: #0e7490 !important; border-color: #0e7490 !important; }
        .btn-warning  { background: #fbbf24 !important; border-color: #fbbf24 !important; color: #78350f !important; }
        .btn-warning:hover  { background: #f59e0b !important; color: #78350f !important; }
        .btn-danger   { background: #ef4444 !important; border-color: #ef4444 !important; color: #fff !important; }
        .btn-danger:hover   { background: #dc2626 !important; }
        .btn-secondary { background: #fff !important; border: 1px solid #d1d5db !important; color: #4b5563 !important; }
        .btn-secondary:hover { background: #f9fafb !important; color: #374151 !important; }
        .card { border-radius: 12px !important; border: 1px solid #e5e7eb !important; }
        .table thead th { background: #f9fafb; color: #4b5563; font-size: 13px; font-weight: 600; }
        .table-hover tbody tr:hover td { background: #ecfeff !important; }
        .nav-tabs .nav-link { color: #4b5563; font-size: 0.87rem; }
        .nav-tabs .nav-link.active { color: #0e7490 !important; border-color: #e5e7eb #e5e7eb #fff !important; font-weight: 600; }
        .nav-tabs .nav-link:hover { color: #0e7490; background: #ecfeff; }
        .alert-success { background: #f0fdf4 !important; border-color: #bbf7d0 !important; color: #166534 !important; }
        .alert-danger  { background: #fef2f2 !important; border-color: #fecaca !important; color: #991b1b !important; }
        .sortable-ghost { opacity: 0.4; background: #e0f2fe !important; }
        .drag-handle { cursor: grab; }
        .drag-handle:active { cursor: grabbing; }
    </style>
</head>
<body>

{{-- HEADER --}}
<nav style="background: #0e7490; padding: 14px 24px; display: flex; justify-content: space-between; align-items: center;">
    <span style="color: white; font-weight: 700; font-size: 16px; display: flex; align-items: center; gap: 8px;">
        <i class="fas fa-map-marked-alt"></i> XPloreJogja
    </span>
    <div style="display: flex; gap: 8px;">
        <a href="{{ route('wisata.create') }}" style="background: white; color: #0e7490; border: none; border-radius: 8px; padding: 6px 16px; font-size: 13px; font-weight: 600; text-decoration: none; display: flex; align-items: center; gap: 6px;">
            <i class="fas fa-plus"></i> Tambah Wisata
        </a>
        <a href="{{ route('admin') }}?tab=wisata" style="background: white; color: #0e7490; border: none; border-radius: 8px; padding: 6px 16px; font-size: 13px; font-weight: 600; text-decoration: none; display: flex; align-items: center; gap: 6px;">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>
</nav>

{{-- FLASH MESSAGES --}}
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mb-0 rounded-0 border-start-0 border-end-0 border-top-0" role="alert">
    <div class="container-fluid px-4">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
</div>
@endif
@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show mb-0 rounded-0 border-start-0 border-end-0 border-top-0" role="alert">
    <div class="container-fluid px-4">
        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
</div>
@endif

<div class="container-fluid py-4 px-4">

    @if($subKategoris->isEmpty())
    <div class="text-center py-5 text-muted">
        <i class="fas fa-folder-open fa-3x mb-3 d-block text-secondary"></i>
        Belum ada sub kategori di {{ $parentCategory->name }}.
    </div>
    @else

    {{-- HORIZONTAL TABS --}}
    <ul class="nav nav-tabs mb-0" id="subKategoriTabs">
        @foreach($subKategoris as $idx => $sub)
        <li class="nav-item">
            <button class="nav-link {{ $idx === 0 ? 'active' : '' }}"
                type="button"
                data-subtab="{{ $sub->id }}">
                {{ $sub->name }}
                <span class="badge bg-secondary ms-1">{{ $sub->wisatas->count() }}</span>
            </button>
        </li>
        @endforeach
    </ul>

    <div id="order-notif" style="display:none;" class="alert alert-success py-2 mb-0 rounded-0 border-start-0 border-end-0 border-top-0">
        <i class="fas fa-check-circle me-1"></i> Urutan berhasil disimpan
    </div>

    <div class="card border-0 shadow-sm rounded-top-0">
        @foreach($subKategoris as $idx => $sub)
        @php
            $populerWisatas = $sub->wisatas->where('is_populer', true)->sortBy('urutan_populer')->values();
            $biasaWisatas   = $sub->wisatas->where('is_populer', false)->sortBy('nama_wisata')->values();
            $rowNo          = 1;
        @endphp
        <div id="subtab-{{ $sub->id }}" class="subtab-panel {{ $idx === 0 ? 'active' : '' }}">
            @if($sub->wisatas->isEmpty())
            <div class="text-center py-5 text-muted">
                <i class="fas fa-inbox fa-3x mb-3 d-block text-secondary"></i>
                Belum ada wisata di sub kategori ini.
            </div>
            @else
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 table-sm">
                    <thead class="table-light">
                        <tr>
                            <th width="30"></th>
                            <th width="40" class="text-center">No</th>
                            <th width="60">Foto</th>
                            <th>Nama Wisata</th>
                            <th>Harga</th>
                            <th>Jam Buka</th>
                            <th class="text-center" width="60">Populer</th>
                            <th class="text-center" width="110">Tampil Home</th>
                            <th width="90">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-{{ $sub->id }}" class="wisata-tbody">
                        {{-- POPULER ROWS --}}
                        @foreach($populerWisatas as $wisata)
                        <tr class="wisata-row is-populer" data-id="{{ $wisata->id }}" data-populer="1">
                            <td><i class="fas fa-grip-vertical drag-handle text-muted"></i></td>
                            <td class="text-center text-muted small row-no">{{ $rowNo++ }}</td>
                            <td>
                                @if($wisata->gambar1)
                                <img src="{{ asset('images/' . $wisata->gambar1) }}"
                                    style="width:40px; height:32px; object-fit:cover; border-radius:4px; border:1px solid #dee2e6;">
                                @else
                                <div style="width:40px; height:32px; background:#e9ecef; border-radius:4px;"></div>
                                @endif
                            </td>
                            <td class="fw-semibold small">{{ $wisata->nama_wisata }}</td>
                            <td class="small">{{ $wisata->harga_tiket ?? '-' }}</td>
                            <td class="small">{{ $wisata->jam_buka ?? '-' }}</td>
                            <td class="text-center">
                                <button type="button"
                                    class="btn-toggle-populer"
                                    data-id="{{ $wisata->id }}"
                                    data-url="{{ route('wisata.togglePopuler', $wisata->id) }}"
                                    title="Klik untuk hapus dari Destinasi Populer">
                                    <i class="fas fa-star text-warning" style="font-size:1.1rem;"></i>
                                </button>
                            </td>
                            <td class="text-center">
                                <div class="form-check d-flex justify-content-center mb-0">
                                    <input type="checkbox"
                                        class="form-check-input cb-tampil-home"
                                        style="cursor:pointer; width:1.2em; height:1.2em;"
                                        data-id="{{ $wisata->id }}"
                                        data-url="{{ route('wisata.toggleHome', $wisata->id) }}"
                                        {{ $wisata->tampil_home ? 'checked' : '' }}>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('wisata.edit', $wisata->id) }}"
                                        class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('wisata.destroy', $wisata->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin hapus wisata ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="redirect_to" value="{{ url()->current() }}">
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach

                        {{-- NON-POPULER ROWS --}}
                        @foreach($biasaWisatas as $wisata)
                        <tr class="wisata-row" data-id="{{ $wisata->id }}" data-populer="0">
                            <td><i class="fas fa-grip-vertical drag-handle text-muted"></i></td>
                            <td class="text-center text-muted small row-no">{{ $rowNo++ }}</td>
                            <td>
                                @if($wisata->gambar1)
                                <img src="{{ asset('images/' . $wisata->gambar1) }}"
                                    style="width:40px; height:32px; object-fit:cover; border-radius:4px; border:1px solid #dee2e6;">
                                @else
                                <div style="width:40px; height:32px; background:#e9ecef; border-radius:4px;"></div>
                                @endif
                            </td>
                            <td class="fw-semibold small">{{ $wisata->nama_wisata }}</td>
                            <td class="small">{{ $wisata->harga_tiket ?? '-' }}</td>
                            <td class="small">{{ $wisata->jam_buka ?? '-' }}</td>
                            <td class="text-center">
                                <button type="button"
                                    class="btn-toggle-populer"
                                    data-id="{{ $wisata->id }}"
                                    data-url="{{ route('wisata.togglePopuler', $wisata->id) }}"
                                    title="Klik untuk tambah ke Destinasi Populer">
                                    <i class="far fa-star text-secondary" style="font-size:1.1rem;"></i>
                                </button>
                            </td>
                            <td class="text-center">
                                <div class="form-check d-flex justify-content-center mb-0">
                                    <input type="checkbox"
                                        class="form-check-input cb-tampil-home"
                                        style="cursor:pointer; width:1.2em; height:1.2em;"
                                        data-id="{{ $wisata->id }}"
                                        data-url="{{ route('wisata.toggleHome', $wisata->id) }}"
                                        {{ $wisata->tampil_home ? 'checked' : '' }}>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('wisata.edit', $wisata->id) }}"
                                        class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('wisata.destroy', $wisata->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin hapus wisata ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="redirect_to" value="{{ url()->current() }}">
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
        @endforeach
    </div>

    @endif

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// ---- TAB SWITCHING ----
document.querySelectorAll('[data-subtab]').forEach(function(btn) {
    btn.addEventListener('click', function() {
        var subId = this.getAttribute('data-subtab');
        document.querySelectorAll('[data-subtab]').forEach(function(b) { b.classList.remove('active'); });
        document.querySelectorAll('.subtab-panel').forEach(function(p) { p.classList.remove('active'); });
        this.classList.add('active');
        var panel = document.getElementById('subtab-' + subId);
        if (panel) { panel.classList.add('active'); }
        try { localStorage.setItem('wisataKatTab_' + window.location.pathname, subId); } catch(e) {}
    });
});
// Restore tab aktif dari localStorage saat page load
document.addEventListener('DOMContentLoaded', function() {
    try {
        var savedSubId = localStorage.getItem('wisataKatTab_' + window.location.pathname);
        if (savedSubId) {
            var btn = document.querySelector('[data-subtab="' + savedSubId + '"]');
            var panel = document.getElementById('subtab-' + savedSubId);
            if (btn && panel) {
                document.querySelectorAll('[data-subtab]').forEach(function(b) { b.classList.remove('active'); });
                document.querySelectorAll('.subtab-panel').forEach(function(p) { p.classList.remove('active'); });
                btn.classList.add('active');
                panel.classList.add('active');
            }
        }
    } catch(e) {}
});

// ---- TOGGLE POPULER ----
document.addEventListener('click', function(e) {
    var btn = e.target.closest('.btn-toggle-populer');
    if (!btn) { return; }

    var url   = btn.getAttribute('data-url');
    var row   = btn.closest('tr.wisata-row');
    var tbody = row.closest('tbody');

    btn.disabled = true;

    fetch(url, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
        body: JSON.stringify({})
    })
    .then(function(res) { return res.json(); })
    .then(function(data) {
        if (!data.success) {
            alert(data.message);
            btn.disabled = false;
            return;
        }

        var icon = btn.querySelector('i');

        if (data.is_populer) {
            // Jadikan populer: isi bintang, latar kuning, pindah ke atas (sebelum separator)
            icon.className = 'fas fa-star text-warning';
            icon.style.fontSize = '1.1rem';
            btn.title = 'Klik untuk hapus dari Destinasi Populer';
            row.setAttribute('data-populer', '1');
            row.classList.add('is-populer');

            var sep = tbody.querySelector('tr.populer-separator');
            if (sep) {
                tbody.insertBefore(row, sep);
            } else {
                // Tidak ada separator — buat kalau ada biasa rows
                var firstBiasa = tbody.querySelector('tr[data-populer="0"]');
                if (firstBiasa) {
                    var newSep = makeSeparatorRow();
                    tbody.insertBefore(newSep, firstBiasa);
                    tbody.insertBefore(row, newSep);
                } else {
                    tbody.appendChild(row);
                }
            }
        } else {
            // Hapus dari populer: bintang kosong, pindah ke bawah separator
            icon.className = 'far fa-star text-secondary';
            icon.style.fontSize = '1.1rem';
            btn.title = 'Klik untuk tambah ke Destinasi Populer';
            row.setAttribute('data-populer', '0');
            row.classList.remove('is-populer');

            var sep = tbody.querySelector('tr.populer-separator');
            if (sep) {
                sep.after(row);
            } else {
                tbody.appendChild(row);
            }

            // Kalau tidak ada populer lagi, hapus separator
            var populerLeft = tbody.querySelectorAll('tr[data-populer="1"]');
            if (populerLeft.length === 0) {
                var existSep = tbody.querySelector('tr.populer-separator');
                if (existSep) { existSep.remove(); }
            }
        }

        renumberRows(tbody);
        btn.disabled = false;
    })
    .catch(function() {
        alert('Terjadi kesalahan jaringan.');
        btn.disabled = false;
    });
});

function makeSeparatorRow() {
    var tr = document.createElement('tr');
    tr.className = 'populer-separator';
    tr.innerHTML = '<td colspan="9" style="padding:0; border:none;"></td>';
    return tr;
}

function renumberRows(tbody) {
    var rows = tbody.querySelectorAll('tr.wisata-row');
    var num  = 1;
    rows.forEach(function(row) {
        var cell = row.querySelector('.row-no');
        if (cell) { cell.textContent = num++; }
    });
}

// ---- DRAG & DROP URUTAN SUBKATEGORI ----
document.querySelectorAll('.wisata-tbody').forEach(function(tbody) {
    Sortable.create(tbody, {
        animation: 150,
        handle: '.drag-handle',
        ghostClass: 'sortable-ghost',
        onEnd: function() {
            var rows = tbody.querySelectorAll('tr.wisata-row');
            var order = [];
            var num = 1;
            rows.forEach(function(row) {
                var noEl = row.querySelector('.row-no');
                if (noEl) { noEl.textContent = num++; }
                var id = row.getAttribute('data-id');
                if (id) { order.push(id); }
            });

            fetch('{{ route('wisata.updateSubkategoriOrder') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ order: order })
            })
            .then(function(r) { return r.json(); })
            .then(function(data) {
                if (data.success) {
                    var notif = document.getElementById('order-notif');
                    if (notif) {
                        notif.style.display = 'block';
                        setTimeout(function() { notif.style.display = 'none'; }, 2000);
                    }
                }
            });
        }
    });
});

// ---- TAMPIL HOME CHECKBOX ----
document.querySelectorAll('.cb-tampil-home').forEach(function(cb) {
    cb.addEventListener('change', function() {
        var cbEl       = this;
        var url        = cbEl.getAttribute('data-url');
        var wasChecked = cbEl.checked;
        cbEl.disabled  = true;

        fetch(url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
            body: JSON.stringify({})
        })
        .then(function(res) { return res.json(); })
        .then(function(data) {
            if (!data.success) {
                cbEl.checked = !wasChecked;
                alert(data.message);
            }
            cbEl.disabled = false;
        })
        .catch(function() {
            cbEl.checked  = !wasChecked;
            cbEl.disabled = false;
        });
    });
});
</script>
</body>
</html>
