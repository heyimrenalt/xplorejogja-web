<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ulasan {{ $parentCategory->name }} - Admin XPloreJogja</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { background: #f4f6f9; font-family: 'Poppins', sans-serif; }
        .admin-header { background: #0e7490; padding: 0.65rem 1.25rem; }
        .logo-text { color: #fff; font-weight: 700; font-size: 1rem; }
        .btn-primary  { background: #0891b2 !important; border-color: #0891b2 !important; color: #fff !important; }
        .btn-primary:hover  { background: #0e7490 !important; border-color: #0e7490 !important; }
        .btn-warning  { background: #fbbf24 !important; border-color: #fbbf24 !important; color: #78350f !important; }
        .btn-danger   { background: #ef4444 !important; border-color: #ef4444 !important; color: #fff !important; }
        .btn-success  { background: #22c55e !important; border-color: #22c55e !important; color: #fff !important; }
        .btn-secondary { background: #fff !important; border: 1px solid #d1d5db !important; color: #4b5563 !important; }
        .btn-info     { background: #0891b2 !important; border-color: #0891b2 !important; color: #fff !important; }
        .btn-outline-secondary { border-color: #d1d5db !important; color: #4b5563 !important; }
        .btn-outline-primary { border-color: #0891b2 !important; color: #0891b2 !important; }
        .nav-tabs .nav-link { color: #4b5563; font-size: 0.87rem; }
        .nav-tabs .nav-link.active { color: #0e7490 !important; border-color: #e5e7eb #e5e7eb #fff !important; font-weight: 600; }
        .card { border-radius: 12px !important; border: 1px solid #e5e7eb !important; }
        .table thead th { background: #f9fafb; color: #4b5563; font-size: 13px; font-weight: 600; }
        .table-hover tbody tr:hover td { background: #ecfeff !important; }
        .sortable-ghost { opacity: 0.4; background: #e9ecef !important; }
        .cb-status { cursor: pointer; }
        #notif-saved { position: fixed; bottom: 20px; right: 20px; z-index: 9999; display: none; min-width: 220px; }
        .accordion-wisata-header {
            cursor: pointer;
            background: #f8fafc;
            border-bottom: 1px solid #e5e7eb;
            transition: background 0.15s;
        }
        .accordion-wisata-header:hover { background: #ecfeff; }
    </style>
</head>
<body>

<nav style="background: #0e7490; padding: 14px 24px; display: flex; justify-content: space-between; align-items: center;">
    <span style="color: white; font-weight: 700; font-size: 16px; display: flex; align-items: center; gap: 8px;">
        <i class="fas fa-map-marked-alt"></i> XPloreJogja
    </span>
    <div style="display: flex; gap: 8px;">
        <a href="{{ route('admin') }}?tab=ulasan" style="background: white; color: #0e7490; border: none; border-radius: 8px; padding: 6px 16px; font-size: 13px; font-weight: 600; text-decoration: none; display: flex; align-items: center; gap: 6px;">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>
</nav>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mb-0 rounded-0" role="alert">
    <div class="container-fluid px-4">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
</div>
@endif

<div class="container-fluid px-4 py-4">
    <div class="d-flex align-items-center gap-3 mb-4">
        <h5 class="fw-bold mb-0">
            <i class="fas fa-star me-2 text-warning"></i> Ulasan {{ $parentCategory->name }}
        </h5>
        @php
            $totalPending = 0;
            foreach ($ulasanPerWisata as $ulasanList) {
                foreach ($ulasanList as $u) {
                    if ($u->status === 'pending') { $totalPending++; }
                }
            }
        @endphp
        @if($totalPending > 0)
        <span class="badge bg-danger">{{ $totalPending }} pending</span>
        @endif
    </div>

    @if($subKategoris->isEmpty())
    <div class="text-center py-5 text-muted">
        <i class="fas fa-folder-open fa-3x mb-3 d-block text-secondary"></i>
        Belum ada sub kategori di kategori ini.
    </div>
    @else

    {{-- Tab sub kategori --}}
    <ul class="nav nav-tabs mb-4">
        @foreach($subKategoris as $idx => $sub)
        <li class="nav-item">
            <button class="nav-link {{ $idx === 0 ? 'active' : '' }}"
                    onclick="switchTab('tab-{{ $sub->id }}', this)">
                {{ $sub->name }}
                @php
                    $subPending = 0;
                    $subWisatas = $wisataPerSub->get($sub->id, collect())->pluck('id');
                    foreach ($subWisatas as $wid) {
                        if (isset($ulasanPerWisata[$wid])) {
                            foreach ($ulasanPerWisata[$wid] as $u) {
                                if ($u->status === 'pending') { $subPending++; }
                            }
                        }
                    }
                @endphp
                @if($subPending > 0)
                <span class="badge bg-danger ms-1" style="font-size: 10px;">{{ $subPending }}</span>
                @endif
            </button>
        </li>
        @endforeach
    </ul>

    {{-- Konten setiap tab --}}
    @foreach($subKategoris as $idx => $sub)
    <div id="tab-{{ $sub->id }}" class="tab-content-panel" style="{{ $idx !== 0 ? 'display:none;' : '' }}">

        @php
            $wisataList = $wisataPerSub->get($sub->id, collect());
        @endphp

        @forelse($wisataList as $wisata)
        @php
            $ulasans      = $ulasanPerWisata[$wisata->id] ?? collect();
            $ulasanCount  = $ulasans->count();
            $pendingCount = $ulasans->where('status', 'pending')->count();
        @endphp

        <div class="card mb-3" id="wisata-card-{{ $wisata->id }}">
            {{-- Accordion Header --}}
            <div class="accordion-wisata-header d-flex justify-content-between align-items-center p-3"
                 onclick="toggleAccordion({{ $wisata->id }})">
                <div class="d-flex align-items-center gap-3">
                    @if($wisata->gambar1)
                    <img src="{{ asset('images/' . $wisata->gambar1) }}"
                         style="width: 48px; height: 36px; object-fit: cover; border-radius: 6px; border: 1px solid #e5e7eb;">
                    @else
                    <div style="width: 48px; height: 36px; background: #e9ecef; border-radius: 6px;"></div>
                    @endif
                    <span class="fw-bold small">{{ $wisata->nama_wisata }}</span>
                    <span class="badge bg-secondary">{{ $ulasanCount }} ulasan</span>
                    @if($pendingCount > 0)
                    <span class="badge bg-warning text-dark">{{ $pendingCount }} pending</span>
                    @endif
                </div>
                <i class="fas fa-chevron-down text-muted" id="icon-{{ $wisata->id }}" style="transition: transform 0.2s;"></i>
            </div>

            {{-- Accordion Body --}}
            <div id="body-{{ $wisata->id }}" style="display: none;">
                @if($ulasanCount > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 table-sm" id="table-{{ $wisata->id }}">
                        <thead class="table-light">
                            <tr>
                                <th width="40"></th>
                                <th width="40">No</th>
                                <th>Nama Pengulas</th>
                                <th width="110">Rating</th>
                                <th>Ulasan</th>
                                <th width="80" class="text-center">Pending</th>
                                <th width="80" class="text-center">Approved</th>
                                <th width="80" class="text-center">Rejected</th>
                                <th width="110">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="sortable-ulasan-{{ $wisata->id }}">
                            @foreach($ulasans as $idx2 => $ulasan)
                            <tr id="ulasan-row-{{ $ulasan->id }}"
                                data-id="{{ $ulasan->id }}"
                                class="ulasan-item-{{ $wisata->id }}"
                                @if($idx2 >= 10) style="display:none;" @endif>
                                <td>
                                    <i class="fas fa-grip-vertical text-muted" style="cursor: grab;"></i>
                                </td>
                                <td class="text-muted small urutan-no">{{ $idx2 + 1 }}</td>
                                <td class="fw-semibold small">{{ $ulasan->nama }}</td>
                                <td>
                                    <div class="d-flex gap-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $ulasan->rating)
                                                <i class="fas fa-star text-warning" style="font-size: 11px;"></i>
                                            @else
                                                <i class="fas fa-star text-secondary" style="font-size: 11px; opacity: 0.3;"></i>
                                            @endif
                                        @endfor
                                    </div>
                                </td>
                                <td class="small text-muted" style="max-width: 200px;">
                                    <span title="{{ $ulasan->teks }}">
                                        {{ mb_strimwidth($ulasan->teks, 0, 50, '...') }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox"
                                           class="form-check-input status-checkbox cb-status cb-pending"
                                           data-id="{{ $ulasan->id }}"
                                           data-status="pending"
                                           {{ $ulasan->status === 'pending' ? 'checked' : '' }}
                                           onchange="updateStatus({{ $ulasan->id }}, 'pending')">
                                </td>
                                <td class="text-center">
                                    <input type="checkbox"
                                           class="form-check-input status-checkbox cb-status cb-approved"
                                           data-id="{{ $ulasan->id }}"
                                           data-status="approved"
                                           {{ $ulasan->status === 'approved' ? 'checked' : '' }}
                                           onchange="updateStatus({{ $ulasan->id }}, 'approved')">
                                </td>
                                <td class="text-center">
                                    <input type="checkbox"
                                           class="form-check-input status-checkbox cb-status cb-rejected"
                                           data-id="{{ $ulasan->id }}"
                                           data-status="rejected"
                                           {{ $ulasan->status === 'rejected' ? 'checked' : '' }}
                                           onchange="updateStatus({{ $ulasan->id }}, 'rejected')">
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('ulasan.show', $ulasan->id) }}"
                                           class="btn btn-sm btn-info text-white" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <form action="{{ route('ulasan.destroy', $ulasan->id) }}" method="POST"
                                              onsubmit="return confirm('Hapus ulasan ini?')">
                                            @csrf
                                            @method('DELETE')
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

                @if($ulasanCount > 10)
                <div class="d-flex justify-content-between align-items-center px-3 py-2 border-top bg-light">
                    <span class="text-muted small" id="info-{{ $wisata->id }}">
                        Menampilkan 1-10 dari {{ $ulasanCount }} ulasan
                    </span>
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-outline-secondary"
                                id="prev-{{ $wisata->id }}"
                                onclick="prevPage({{ $wisata->id }}, {{ $ulasanCount }})"
                                disabled>
                            <i class="fas fa-chevron-left"></i> Prev
                        </button>
                        <button class="btn btn-sm btn-outline-primary"
                                id="next-{{ $wisata->id }}"
                                onclick="nextPage({{ $wisata->id }}, {{ $ulasanCount }})">
                            Next <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
                @endif

                @else
                <div class="text-center py-4 text-muted">
                    <i class="fas fa-comment-slash fa-2x mb-2 d-block"></i>
                    Belum ada ulasan untuk destinasi ini.
                </div>
                @endif
            </div>
        </div>

        @empty
        <div class="text-center py-5 text-muted">
            <i class="fas fa-folder-open fa-3x mb-3 d-block text-secondary"></i>
            Belum ada wisata di sub kategori ini.
        </div>
        @endforelse
    </div>
    @endforeach

    @endif
</div>

<div id="notif-saved" class="alert alert-success shadow-sm py-2 px-3">
    <i class="fas fa-check-circle me-2"></i> Perubahan berhasil disimpan
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
var currentPage = {};

function showNotif() {
    var el = document.getElementById('notif-saved');
    el.style.display = 'block';
    setTimeout(function() { el.style.display = 'none'; }, 2000);
}

// ---- TAB SUB KATEGORI ----
function switchTab(tabId, btn) {
    document.querySelectorAll('.tab-content-panel').forEach(function(el) {
        el.style.display = 'none';
    });
    document.querySelectorAll('.nav-tabs .nav-link').forEach(function(el) {
        el.classList.remove('active');
    });
    document.getElementById(tabId).style.display = 'block';
    btn.classList.add('active');
    try { localStorage.setItem('ulasanKatTab_' + window.location.pathname, tabId); } catch(e) {}
}
// Restore tab aktif dari localStorage saat page load
document.addEventListener('DOMContentLoaded', function() {
    try {
        var savedTab = localStorage.getItem('ulasanKatTab_' + window.location.pathname);
        if (savedTab) {
            var el = document.getElementById(savedTab);
            var btn = document.querySelector('[onclick*="' + savedTab + '"]');
            if (el && btn) {
                document.querySelectorAll('.tab-content-panel').forEach(function(p) { p.style.display = 'none'; });
                document.querySelectorAll('.nav-tabs .nav-link').forEach(function(b) { b.classList.remove('active'); });
                el.style.display = 'block';
                btn.classList.add('active');
            }
        }
    } catch(e) {}
});

// ---- ACCORDION ----
function toggleAccordion(wisataId) {
    var body = document.getElementById('body-' + wisataId);
    var icon = document.getElementById('icon-' + wisataId);
    if (body.style.display === 'none' || body.style.display === '') {
        body.style.display = 'block';
        icon.style.transform = 'rotate(180deg)';
    } else {
        body.style.display = 'none';
        icon.style.transform = 'rotate(0deg)';
    }
}

// ---- STATUS CHECKBOX AJAX ----
function updateStatus(id, status) {
    var tokenEl = document.querySelector('meta[name=csrf-token]');
    if (!tokenEl) {
        alert('CSRF token tidak ditemukan!');
        return;
    }

    var url = '';
    if (status === 'approved') {
        url = '/admin/ulasan/' + id + '/approve';
    } else if (status === 'rejected') {
        url = '/admin/ulasan/' + id + '/reject';
    } else if (status === 'pending') {
        url = '/admin/ulasan/' + id + '/pending';
    }

    if (!url) { return; }

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': tokenEl.content
        },
        body: JSON.stringify({ status: status })
    })
    .then(function(r) { return r.json(); })
    .then(function(data) {
        if (data.success) {
            var row = document.getElementById('ulasan-row-' + id);
            if (row) {
                row.querySelectorAll('.status-checkbox').forEach(function(cb) {
                    cb.checked = false;
                });
                var activeCheckbox = row.querySelector('.cb-' + status);
                if (activeCheckbox) { activeCheckbox.checked = true; }
            }
            showNotif();
        } else {
            alert('Gagal mengubah status: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(function(err) {
        alert('Error: ' + err.message);
    });
}

// ---- PAGINATION ----
function showPage(wisataId, page, total) {
    var perPage = 10;
    var start   = (page - 1) * perPage;
    var end     = start + perPage;
    var rows    = document.querySelectorAll('.ulasan-item-' + wisataId);

    rows.forEach(function(row, idx) {
        row.style.display = (idx >= start && idx < end) ? 'table-row' : 'none';
    });

    var showing = Math.min(end, total);
    var info = document.getElementById('info-' + wisataId);
    if (info) {
        info.textContent = 'Menampilkan ' + (start + 1) + '-' + showing + ' dari ' + total + ' ulasan';
    }

    var prevBtn = document.getElementById('prev-' + wisataId);
    var nextBtn = document.getElementById('next-' + wisataId);
    if (prevBtn) { prevBtn.disabled = page <= 1; }
    if (nextBtn) { nextBtn.disabled = end >= total; }

    currentPage[wisataId] = page;
}

function prevPage(wisataId, total) {
    var page = currentPage[wisataId] || 1;
    if (page > 1) { showPage(wisataId, page - 1, total); }
}

function nextPage(wisataId, total) {
    var page = currentPage[wisataId] || 1;
    showPage(wisataId, page + 1, total);
}

// ---- DRAG & DROP URUTAN PER WISATA ----
document.querySelectorAll('[id^="sortable-ulasan-"]').forEach(function(tbody) {
    Sortable.create(tbody, {
        animation: 150,
        ghostClass: 'sortable-ghost',
        handle: '.fa-grip-vertical',
        onEnd: function() {
            var rows = tbody.querySelectorAll('tr[data-id]');
            rows.forEach(function(row, idx) {
                var noEl = row.querySelector('.urutan-no');
                if (noEl) { noEl.textContent = idx + 1; }
            });

            var order = [];
            rows.forEach(function(row) { order.push(row.getAttribute('data-id')); });

            fetch('{{ route("ulasan.updateOrder") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ order: order })
            })
            .then(function(r) { return r.json(); })
            .then(function(data) { if (data.success) { showNotif(); } });
        }
    });
});
</script>
</body>
</html>
