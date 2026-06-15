<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin XPloreJogja</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { background: #f4f6f9; margin: 0; font-family: 'Poppins', sans-serif; }

        /* Header */
        .admin-header {
            background: #0e7490;
            border-bottom: none;
            padding: 0.65rem 1.25rem;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .logo-text { color: #fff; font-weight: 700; font-size: 1rem; }
        .btn-logout { border: 1px solid rgba(255,255,255,0.55); color: #fff !important; background: transparent; font-size: 0.8rem; }
        .btn-logout:hover { background: #155e75 !important; border-color: transparent; }

        /* Sidebar */
        .admin-sidebar {
            width: 220px;
            min-width: 220px;
            background: #fff;
            border-right: 1px solid #e5e7eb;
            min-height: calc(100vh - 53px);
            padding-top: 8px;
        }

        .tab-item {
            display: block;
            padding: 0.7rem 1rem;
            cursor: pointer;
            border-left: 3px solid transparent;
            color: #4b5563;
            text-decoration: none;
            transition: background 0.12s, border-color 0.12s;
        }
        .tab-item:hover { background: #f9fafb; color: #111827; text-decoration: none; }
        .tab-item.active {
            border-left-color: #0891b2;
            background: #ecfeff;
            color: #0e7490;
            font-weight: 600;
        }
        .tab-item .tab-name { font-size: 0.88rem; }
        .tab-item .tab-sub { font-size: 0.74rem; color: #6b7280; margin-top: 2px; }
        .tab-item.active .tab-sub { color: #0891b2; }

        /* Wisata accordion */
        #wisata-accordion a:hover { background: #ecfeff; color: #0e7490 !important; text-decoration: none; }
        #wisata-accordion { background: #f9fafb !important; border-left: 3px solid #0891b2 !important; }

        /* Content panels */
        .tab-content-panel { display: none; }
        .tab-content-panel.active { display: block; }

        /* Sortable */
        .populer-item { cursor: default; }
        .pamflet-item { cursor: default; }
        .sortable-ghost { opacity: 0.4; background: #e9ecef !important; }

        /* Notification */
        #notif-saved {
            position: fixed; bottom: 20px; right: 20px;
            z-index: 9999; display: none; min-width: 220px;
        }

        /* === Design System === */
        .btn-primary  { background: #0891b2 !important; border-color: #0891b2 !important; color: #fff !important; }
        .btn-primary:hover  { background: #0e7490 !important; border-color: #0e7490 !important; }
        .btn-warning  { background: #fbbf24 !important; border-color: #fbbf24 !important; color: #78350f !important; }
        .btn-warning:hover  { background: #f59e0b !important; border-color: #f59e0b !important; color: #78350f !important; }
        .btn-danger   { background: #ef4444 !important; border-color: #ef4444 !important; color: #fff !important; }
        .btn-danger:hover   { background: #dc2626 !important; border-color: #dc2626 !important; }
        .btn-success  { background: #0891b2 !important; border-color: #0891b2 !important; color: #fff !important; }
        .btn-success:hover  { background: #0e7490 !important; border-color: #0e7490 !important; }
        .btn-secondary { background: #fff !important; border: 1px solid #d1d5db !important; color: #4b5563 !important; }
        .btn-secondary:hover { background: #f9fafb !important; color: #374151 !important; }
        .btn-info     { background: #0891b2 !important; border-color: #0891b2 !important; color: #fff !important; }
        .btn-info:hover     { background: #0e7490 !important; border-color: #0e7490 !important; }
        .btn-outline-warning { border-color: #fbbf24 !important; color: #78350f !important; }
        .btn-outline-warning:hover { background: #fbbf24 !important; color: #78350f !important; }
        .btn-outline-danger { border-color: #ef4444 !important; color: #ef4444 !important; }
        .btn-outline-danger:hover { background: #ef4444 !important; color: #fff !important; }

        .card { border-radius: 12px !important; border: 1px solid #e5e7eb !important; }
        .card-header { border-radius: 12px 12px 0 0 !important; }

        .form-control, .form-select { border: 1px solid #d1d5db !important; border-radius: 8px !important; }
        .form-control:focus, .form-select:focus { border-color: #0891b2 !important; box-shadow: 0 0 0 0.2rem rgba(8,145,178,0.15) !important; }
        .form-label { color: #374151; font-weight: 500; font-size: 14px; }

        .table thead th { background: #f9fafb; color: #4b5563; font-size: 13px; font-weight: 600; }
        .table-hover tbody tr:hover td { background: #ecfeff !important; }
        tr.wisata-row.is-populer { background: #fffdf0; }

        .badge.bg-primary   { background: #0891b2 !important; }
        .badge.bg-info      { background: #0891b2 !important; }
        .badge.bg-secondary { background: #6b7280 !important; }

        .alert-success { background: #f0fdf4 !important; border-color: #bbf7d0 !important; color: #166534 !important; }
        .alert-danger  { background: #fef2f2 !important; border-color: #fecaca !important; color: #991b1b !important; }
        .alert-warning { background: #fffbeb !important; border-color: #fde68a !important; color: #92400e !important; }

        .accordion-button:not(.collapsed) { color: #0e7490; background: #ecfeff; box-shadow: none; }
        .accordion-button:focus { box-shadow: none; }
        .accordion-item { border: 1px solid #e5e7eb !important; border-radius: 8px !important; overflow: hidden; }

        .nav-tabs .nav-link { color: #4b5563; font-size: 0.87rem; }
        .nav-tabs .nav-link.active { color: #0e7490 !important; border-color: #e5e7eb #e5e7eb #fff !important; font-weight: 600; }
        .nav-tabs .nav-link:hover { color: #0e7490; background: #ecfeff; }

        .pamflet-urutan { border-radius: 6px; }
    </style>
</head>
<body>

{{-- HEADER --}}
<nav style="background: #0e7490; padding: 14px 24px; display: flex; justify-content: space-between; align-items: center;">
    <span style="color: white; font-weight: 700; font-size: 16px; display: flex; align-items: center; gap: 8px;">
        <i class="fas fa-map-marked-alt"></i> XPloreJogja
    </span>
    <div style="display: flex; gap: 8px;">
        <form action="{{ route('logout') }}" method="POST" class="mb-0">
            @csrf
            <button type="submit" style="background: white; color: #dc2626; border: none; border-radius: 8px; padding: 6px 16px; font-size: 13px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 6px;">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </form>
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

{{-- MAIN LAYOUT --}}
<div class="d-flex">

    {{-- SIDEBAR --}}
    <div class="admin-sidebar">
        @php
        $totalWisata = $countWisataAlam + $countHiburanKel + $countPenginapan + $countTransportasi + $countKuliner;
        $tabList = [
            ['id' => 'pamflet', 'label' => 'Pamflet',           'icon' => 'fa-images',    'sub' => $pamflets->count() . '/7 aktif'],
            ['id' => 'populer', 'label' => 'Destinasi Populer', 'icon' => 'fa-star',      'sub' => $wisataPopuler->count() . '/7 aktif'],
            ['id' => 'blog',    'label' => 'Blog & Informasi',  'icon' => 'fa-newspaper', 'sub' => $blogs->count() . ' artikel'],
        ];
        @endphp

        {{-- 2 tab pertama: Pamflet, Destinasi Populer --}}
        @foreach($tabList as $idx => $tab)
        @if($idx < 2)
        <a class="tab-item {{ $idx === 0 ? 'active' : '' }}"
           data-tab="{{ $tab['id'] }}" href="#">
            <div class="tab-name">
                <i class="fas {{ $tab['icon'] }} me-2"></i>{{ $tab['label'] }}
            </div>
            <div class="tab-sub" @if($tab['id'] === 'populer') id="sidebar-populer-count" @endif>{{ $tab['sub'] }}</div>
        </a>
        @endif
        @endforeach

        {{-- Tab Deskripsi Kota --}}
        <a href="{{ route('deskripsi-kota.edit') }}" class="tab-item">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="tab-name">
                        <i class="fas fa-city me-2"></i>Deskripsi Kota
                    </div>
                    <div class="tab-sub">Teks &amp; gambar Jogja</div>
                </div>
                <i class="fas fa-chevron-right" style="font-size:11px; flex-shrink:0; margin-left:6px;"></i>
            </div>
        </a>

        {{-- DESTINASI WISATA: accordion sidebar --}}
        <div class="tab-item" id="wisata-toggle" style="cursor:pointer;" onclick="toggleWisataAccordion()">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="tab-name">
                        <i class="fas fa-map-marked-alt me-2"></i>Destinasi Wisata
                    </div>
                    <div class="tab-sub">{{ $totalWisata }} destinasi</div>
                </div>
                <i class="fas fa-chevron-down" id="wisata-chevron"
                   style="font-size:11px; transition:transform 0.2s; flex-shrink:0; margin-left:6px;"></i>
            </div>
        </div>
        <div id="wisata-accordion" style="display:none; background:#f8f9fa; border-left:3px solid #dee2e6;">
            <a href="{{ route('wisata.kategori', 1) }}"
               onclick="saveLastTab('wisata')"
               class="d-block px-4 py-2 text-decoration-none text-secondary"
               style="font-size:0.82rem;">
                <i class="fas fa-mountain me-2 text-success"></i> Wisata Alam
            </a>
            <a href="{{ route('wisata.kategori', 8) }}"
               onclick="saveLastTab('wisata')"
               class="d-block px-4 py-2 text-decoration-none text-secondary"
               style="font-size:0.82rem;">
                <i class="fas fa-laugh me-2 text-warning"></i> Hiburan Keluarga
            </a>
            <a href="{{ route('wisata.kategori', 15) }}"
               onclick="saveLastTab('wisata')"
               class="d-block px-4 py-2 text-decoration-none text-secondary"
               style="font-size:0.82rem;">
                <i class="fas fa-hotel me-2 text-info"></i> Penginapan
            </a>
            <a href="{{ route('wisata.kategori', 19) }}"
               onclick="saveLastTab('wisata')"
               class="d-block px-4 py-2 text-decoration-none text-secondary"
               style="font-size:0.82rem;">
                <i class="fas fa-bus me-2 text-dark"></i> Transportasi
            </a>
            <a href="{{ route('wisata.kategori', 23) }}"
               onclick="saveLastTab('wisata')"
               class="d-block px-4 py-2 text-decoration-none text-secondary"
               style="font-size:0.82rem;">
                <i class="fas fa-utensils me-2 text-danger"></i> Kuliner
            </a>
            <a href="{{ route('wisata.kategori', 27) }}"
               onclick="saveLastTab('wisata')"
               class="d-block px-4 py-2 text-decoration-none text-secondary"
               style="font-size:0.82rem;">
                <i class="fas fa-newspaper me-2 text-primary"></i> Blog & Informasi
            </a>
        </div>

        {{-- Tab Blog & Informasi --}}
        <a class="tab-item" data-tab="blog" href="#">
            <div class="tab-name">
                <i class="fas fa-newspaper me-2"></i>Blog & Informasi
            </div>
            <div class="tab-sub">{{ $blogs->count() }} artikel</div>
        </a>

        {{-- Tab Ulasan --}}
        <div id="tab-ulasan-sidebar" onclick="switchTab('ulasan')"
             style="padding: 10px 1.25rem; cursor: pointer; border-left: 3px solid transparent;"
             class="tab-item" data-tab="ulasan">
            <div class="tab-name">
                <i class="fas fa-star me-2"></i>Ulasan
            </div>
            <div class="tab-sub" id="sidebar-ulasan-count">
                {{ $totalPendingUlasan }} ulasan pending
            </div>
        </div>
    </div>

    {{-- CONTENT AREA --}}
    <div class="flex-grow-1 p-4" style="min-width:0;">

        {{-- ========================== --}}
        {{-- TAB 1: BLOG & INFORMASI   --}}
        {{-- ========================== --}}
        <div id="tab-blog" class="tab-content-panel">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0">
                    <i class="fas fa-newspaper me-2 text-success"></i> Blog & Informasi
                </h6>
                <a href="{{ route('blog.create') }}" class="btn btn-success btn-sm">
                    <i class="fas fa-plus me-1"></i> Tambah Artikel
                </a>
            </div>

            <div id="order-notif-blog" style="display:none;" class="alert alert-success py-2 mb-2">
                <i class="fas fa-check-circle me-1"></i> Urutan berhasil disimpan
            </div>
            <div class="accordion" id="accordionBlog">
                @php
                $subBlogList = [
                    ['id' => 28, 'label' => 'Tips Wisata', 'icon' => 'fa-lightbulb', 'color' => 'warning'],
                    ['id' => 29, 'label' => 'Berita',      'icon' => 'fa-newspaper', 'color' => 'info'],
                    ['id' => 30, 'label' => 'Panduan',     'icon' => 'fa-book',      'color' => 'success'],
                ];
                @endphp

                @foreach($subBlogList as $sub)
                @php
                $subBlogs = $blogs->where('category_id', $sub['id']);
                $subCount = $subBlogs->count();
                $blogKey  = 'blog-' . $sub['id'];
                @endphp
                <div class="accordion-item border mb-2 rounded overflow-hidden">
                    <h2 class="accordion-header" id="heading-{{ $blogKey }}">
                        <button class="accordion-button collapsed py-2" type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#collapse-{{ $blogKey }}"
                            aria-expanded="false"
                            aria-controls="collapse-{{ $blogKey }}">
                            <i class="fas {{ $sub['icon'] }} me-2 text-{{ $sub['color'] }}"></i>
                            <span class="fw-bold">{{ $sub['label'] }}</span>
                            <span class="badge bg-secondary ms-2">{{ $subCount }} artikel</span>
                        </button>
                    </h2>
                    <div id="collapse-{{ $blogKey }}" class="accordion-collapse collapse"
                         aria-labelledby="heading-{{ $blogKey }}">
                        <div class="accordion-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0 table-sm">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="30"></th>
                                            <th width="40" class="text-center">No</th>
                                            <th width="50">Foto</th>
                                            <th>Judul Artikel</th>
                                            <th>Sumber</th>
                                            <th class="text-center" width="110">Tampil Home</th>
                                            <th width="90">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="blog-tbody">
                                        @forelse($subBlogs as $blog)
                                        <tr data-id="{{ $blog->id }}">
                                            <td><i class="fas fa-grip-vertical text-muted drag-handle" style="cursor:grab;"></i></td>
                                            <td class="text-center text-muted small row-no">{{ $loop->iteration }}</td>
                                            <td>
                                                @if($blog->gambar1)
                                                <img src="{{ asset('images/' . $blog->gambar1) }}"
                                                    style="width:40px; height:32px; object-fit:cover; border-radius:4px; border:1px solid #dee2e6;">
                                                @else
                                                <div style="width:40px; height:32px; background:#e9ecef; border-radius:4px;"></div>
                                                @endif
                                            </td>
                                            <td class="fw-semibold small">{{ $blog->nama_wisata }}</td>
                                            <td class="small text-muted">
                                                @if($blog->link_sumber)
                                                <a href="{{ $blog->link_sumber }}" target="_blank"
                                                    class="text-muted text-decoration-none">
                                                    {{ $blog->alamat_lengkap ?? '-' }}
                                                    <i class="fas fa-external-link-alt ms-1" style="font-size:9px;"></i>
                                                </a>
                                                @else
                                                {{ $blog->alamat_lengkap ?? '-' }}
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox"
                                                       class="form-check-input tampil-home-cb"
                                                       style="cursor:pointer; width:1.2em; height:1.2em;"
                                                       data-id="{{ $blog->id }}"
                                                       {{ $blog->tampil_home ? 'checked' : '' }}
                                                       onchange="toggleTampilHome({{ $blog->id }}, this)">
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <a href="{{ route('blog.edit', $blog->id) }}"
                                                        class="btn btn-sm btn-warning" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('blog.destroy', $blog->id) }}" method="POST"
                                                        onsubmit="return confirm('Yakin hapus artikel ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4 text-muted small">
                                                <i class="fas fa-inbox me-1"></i> Belum ada artikel di sub kategori ini.
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- ========================== --}}
        {{-- TAB 2: DESTINASI POPULER  --}}
        {{-- ========================== --}}
        <div id="tab-populer" class="tab-content-panel">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0">
                    <i class="fas fa-star me-2 text-warning"></i> Destinasi Populer
                    <span class="badge ms-2 {{ $wisataPopuler->count() > 0 ? 'bg-primary' : 'bg-secondary' }}"
                          id="badge-populer-count">{{ $wisataPopuler->count() }}/7 aktif</span>
                </h6>
                <small class="text-muted">
                    <i class="fas fa-grip-vertical me-1"></i> Drag &amp; drop untuk mengatur urutan
                </small>
            </div>

            @if($wisataPopuler->isEmpty())
            <div class="text-center py-5 text-muted" id="populer-empty-state">
                <i class="fas fa-star fa-3x mb-3 d-block text-secondary"></i>
                Belum ada destinasi populer.<br>
                <small>Centang "Tampilkan di Destinasi Populer" pada form wisata.</small>
            </div>
            @else
            <div class="card border-0 shadow-sm">
                <ul id="populer-list" class="list-group list-group-flush">
                    @foreach($wisataPopuler as $wp)
                    <li class="populer-item list-group-item d-flex align-items-center gap-3 py-2 px-3"
                        data-id="{{ $wp->id }}">
                        <i class="fas fa-grip-vertical text-muted" style="cursor:grab;"></i>
                        <span class="badge bg-secondary populer-nomor" style="min-width:26px;">{{ $loop->iteration }}</span>
                        @if($wp->gambar1)
                        <img src="{{ asset('images/' . $wp->gambar1) }}"
                            style="width:50px; height:38px; object-fit:cover; border-radius:5px; border:1px solid #dee2e6;">
                        @else
                        <div style="width:50px; height:38px; background:#e9ecef; border-radius:5px;"></div>
                        @endif
                        <div class="flex-grow-1">
                            <div class="fw-semibold small">{{ $wp->nama_wisata }}</div>
                            <span class="badge bg-primary" style="font-size:10px;">{{ $wp->category->name ?? '-' }}</span>
                        </div>
                        <a href="{{ route('wisata.edit', $wp->id) }}"
                            class="btn btn-sm btn-outline-warning" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button type="button"
                            class="btn btn-sm btn-outline-danger btn-hapus-populer"
                            data-id="{{ $wp->id }}"
                            data-url="{{ route('wisata.removePopuler', $wp->id) }}"
                            title="Hapus dari Destinasi Populer">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>

        {{-- ========================== --}}
        {{-- TAB 1: PAMFLET            --}}
        {{-- ========================== --}}
        <div id="tab-pamflet" class="tab-content-panel active">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0">
                    <i class="fas fa-images me-2 text-info"></i> Pamflet
                    @if($pamflets->count() > 0)
                    <span class="badge bg-primary ms-2">{{ $pamflets->count() }}/7 aktif</span>
                    @else
                    <span class="badge bg-secondary ms-2">0/7 aktif</span>
                    @endif
                </h6>
                @if($pamflets->count() < 7)
                <button type="button" class="btn btn-info btn-sm text-white"
                    data-bs-toggle="modal" data-bs-target="#modalTambahPamflet">
                    <i class="fas fa-plus me-1"></i> Tambah Pamflet
                </button>
                @else
                <span class="badge bg-danger py-2 px-3 fs-6">7/7 Penuh</span>
                @endif
            </div>

            @if($pamflets->isEmpty())
            <div class="text-center py-5 text-muted">
                <i class="fas fa-images fa-3x mb-3 d-block text-secondary"></i>
                Belum ada pamflet.<br>
                <small>Klik "Tambah Pamflet" untuk menambahkan.</small>
            </div>
            @else
            <div id="pamflet-grid" class="row g-3">
                @foreach($pamflets as $pamflet)
                <div class="col-md-4 pamflet-item" data-id="{{ $pamflet->id }}">
                    <div class="card border shadow-sm h-100">
                        <div class="position-relative">
                            <img src="{{ asset('images/' . $pamflet->gambar) }}"
                                class="card-img-top"
                                style="height:180px; object-fit:cover;">
                            <span class="position-absolute top-0 start-0 badge bg-secondary m-2 pamflet-urutan">
                                {{ $loop->iteration }}
                            </span>
                        </div>
                        <div class="card-footer d-flex align-items-center gap-2 p-2 bg-white">
                            <i class="fas fa-grip-vertical text-muted" style="cursor:grab;"></i>
                            <button type="button"
                                class="btn btn-sm btn-warning flex-grow-1 btn-edit-pamflet"
                                data-id="{{ $pamflet->id }}"
                                data-gambar="{{ asset('images/' . $pamflet->gambar) }}"
                                data-url="{{ route('pamflet.update', $pamflet->id) }}"
                                data-bs-toggle="modal"
                                data-bs-target="#modalEditPamflet">
                                <i class="fas fa-edit me-1"></i> Edit
                            </button>
                            <form action="{{ route('pamflet.destroy', $pamflet->id) }}" method="POST"
                                onsubmit="return confirm('Yakin hapus pamflet ini?')">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="redirect_to" value="{{ url()->current() }}">
                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        {{-- ========================== --}}
        {{-- TAB: ULASAN               --}}
        {{-- ========================== --}}
        <div id="tab-ulasan" class="tab-content-panel">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0">
                    <i class="fas fa-star me-2 text-warning"></i> Ulasan
                    @if($totalPendingUlasan > 0)
                    <span class="badge bg-danger ms-2">{{ $totalPendingUlasan }} pending</span>
                    @endif
                </h6>
            </div>

            <div class="accordion" id="accordionUlasan">
                @php
                $ulasanKategoriList = [
                    ['id' => 1,  'label' => 'Wisata Alam',        'icon' => 'fa-mountain',      'color' => 'success'],
                    ['id' => 8,  'label' => 'Hiburan Keluarga',   'icon' => 'fa-laugh',         'color' => 'warning'],
                    ['id' => 15, 'label' => 'Penginapan',         'icon' => 'fa-hotel',         'color' => 'info'],
                    ['id' => 19, 'label' => 'Transportasi',       'icon' => 'fa-bus',           'color' => 'dark'],
                    ['id' => 23, 'label' => 'Kuliner',            'icon' => 'fa-utensils',      'color' => 'danger'],
                ];
                @endphp

                @foreach($ulasanKategoriList as $kat)
                @php $pendingCount = $pendingUlasan[$kat['id']] ?? 0; @endphp
                <div class="accordion-item border mb-2 rounded overflow-hidden">
                    <h2 class="accordion-header" id="heading-ulasan-{{ $kat['id'] }}">
                        <button class="accordion-button collapsed py-2" type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#collapse-ulasan-{{ $kat['id'] }}"
                            aria-expanded="false">
                            <i class="fas {{ $kat['icon'] }} me-2 text-{{ $kat['color'] }}"></i>
                            <span class="fw-bold">{{ $kat['label'] }}</span>
                            @if($pendingCount > 0)
                            <span class="badge bg-danger ms-2">{{ $pendingCount }} pending</span>
                            @else
                            <span class="badge bg-secondary ms-2">0 pending</span>
                            @endif
                        </button>
                    </h2>
                    <div id="collapse-ulasan-{{ $kat['id'] }}" class="accordion-collapse collapse">
                        <div class="accordion-body p-3">
                            <a href="{{ route('ulasan.indexByKategori', $kat['id']) }}"
                               class="btn btn-sm btn-primary">
                                <i class="fas fa-eye me-1"></i> Kelola Ulasan {{ $kat['label'] }}
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </div>{{-- end content area --}}
</div>{{-- end main layout --}}

{{-- NOTIFIKASI URUTAN TERSIMPAN --}}
<div id="notif-saved" class="alert alert-success shadow-sm py-2 px-3">
    <i class="fas fa-check-circle me-2"></i> Urutan berhasil disimpan
</div>

{{-- ========================== --}}
{{-- MODAL TAMBAH PAMFLET       --}}
{{-- ========================== --}}
<div class="modal fade" id="modalTambahPamflet" tabindex="-1"
     aria-labelledby="modalTambahLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-bold" id="modalTambahLabel">
                    <i class="fas fa-plus me-2 text-info"></i> Tambah Pamflet
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formTambahPamflet" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div id="tambah-error" class="alert alert-danger py-2 d-none small"></div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Gambar Pamflet <span class="text-danger">*</span>
                        </label>
                        <input type="file" class="form-control" name="gambar" id="gambar-tambah"
                            accept="image/jpeg,image/png,image/jpg" required>
                        <div class="form-text">Format: JPEG, PNG, JPG. Maks. 2MB.</div>
                    </div>
                    <div id="tambah-preview" class="d-none">
                        <img id="preview-tambah-img" src=""
                            style="max-width:100%; max-height:200px; border-radius:6px;" class="border">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-info text-white" id="btnTambahSubmit">
                        <i class="fas fa-upload me-1"></i> Upload
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ========================== --}}
{{-- MODAL EDIT PAMFLET         --}}
{{-- ========================== --}}
<div class="modal fade" id="modalEditPamflet" tabindex="-1"
     aria-labelledby="modalEditLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-bold" id="modalEditLabel">
                    <i class="fas fa-edit me-2 text-warning"></i> Edit Pamflet
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formEditPamflet" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" id="edit-pamflet-url" value="">
                <div class="modal-body">
                    <div id="edit-error" class="alert alert-danger py-2 d-none small"></div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Gambar Saat Ini</label>
                        <div>
                            <img id="edit-gambar-lama" src=""
                                style="max-width:100%; max-height:160px; border-radius:6px;" class="border">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Ganti Gambar
                            <span class="text-muted fw-normal">(opsional)</span>
                        </label>
                        <input type="file" class="form-control" name="gambar" id="gambar-edit"
                            accept="image/jpeg,image/png,image/jpg">
                        <div class="form-text">Format: JPEG, PNG, JPG. Maks. 2MB. Kosongkan jika tidak ingin mengganti.</div>
                    </div>
                    <div id="edit-preview" class="d-none">
                        <img id="preview-edit-img" src=""
                            style="max-width:100%; max-height:200px; border-radius:6px;" class="border">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning" id="btnEditSubmit">
                        <i class="fas fa-save me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// ---- localStorage helpers ----
function saveLastTab(tab) {
    try { localStorage.setItem('lastAdminTab', tab); } catch(e) {}
}
function getLastTab() {
    try { return localStorage.getItem('lastAdminTab'); } catch(e) { return null; }
}

// ---- TAB SWITCHING ----
var tabItems  = document.querySelectorAll('.tab-item[data-tab]');
var tabPanels = document.querySelectorAll('.tab-content-panel');

function switchTab(tab) {
    var targetId = 'tab-' + tab;
    tabItems.forEach(function(t) { t.classList.remove('active'); });
    tabPanels.forEach(function(p) { p.classList.remove('active'); });

    var activeItem = document.querySelector('.tab-item[data-tab="' + tab + '"]');
    if (activeItem) { activeItem.classList.add('active'); }

    var panel = document.getElementById(targetId);
    if (panel) { panel.classList.add('active'); }

    saveLastTab(tab);
}

tabItems.forEach(function(item) {
    item.addEventListener('click', function(e) {
        e.preventDefault();
        switchTab(this.getAttribute('data-tab'));
    });
});

// ---- RESTORE LAST TAB ON LOAD ----
(function() {
    var urlParams  = new URLSearchParams(window.location.search);
    var tabFromUrl = urlParams.get('tab');
    var lastTab    = getLastTab();
    var activeTab  = tabFromUrl || lastTab || 'pamflet';
    switchTab(activeTab);
})();

// ---- WISATA ACCORDION TOGGLE ----
function toggleWisataAccordion() {
    var acc     = document.getElementById('wisata-accordion');
    var chevron = document.getElementById('wisata-chevron');
    if (acc.style.display === 'none' || acc.style.display === '') {
        acc.style.display = 'block';
        chevron.style.transform = 'rotate(180deg)';
    } else {
        acc.style.display = 'none';
        chevron.style.transform = 'rotate(0deg)';
    }
}

// ---- SORTABLE: DESTINASI POPULER ----
var populerList = document.getElementById('populer-list');
if (populerList) {
    Sortable.create(populerList, {
        animation: 150,
        ghostClass: 'sortable-ghost',
        handle: '.fa-grip-vertical',
        onEnd: function() {
            reindexPopulerNomor();
            var items = populerList.querySelectorAll('.populer-item');
            var order = [];
            items.forEach(function(item) {
                order.push(item.getAttribute('data-id'));
            });

            fetch('{{ route("wisata.updatePopulerOrder") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ order: order })
            })
            .then(function(res) { return res.json(); })
            .then(function(data) { if (data.success) { showNotif(); updateSidebarCount(); } });
        }
    });
}

function reindexPopulerNomor() {
    if (!populerList) { return; }
    var items = populerList.querySelectorAll('.populer-item');
    items.forEach(function(item, idx) {
        var badge = item.querySelector('.populer-nomor');
        if (badge) { badge.textContent = idx + 1; }
    });
}

function updateBadgePopulerCount() {
    var badge = document.getElementById('badge-populer-count');
    if (!badge) { return; }
    var items = document.querySelectorAll('.populer-item');
    var count = items.length;
    badge.textContent = count + '/7 aktif';
    badge.className = 'badge ms-2 ' + (count > 0 ? 'bg-primary' : 'bg-secondary');
}

function updateSidebarCount() {
    var sidebarEl = document.getElementById('sidebar-populer-count');
    if (!sidebarEl) { return; }
    var count = document.querySelectorAll('#populer-list .populer-item').length;
    sidebarEl.textContent = count + '/7 aktif';
}

// ---- HAPUS DARI DESTINASI POPULER ----
document.addEventListener('click', function(e) {
    var btn = e.target.closest('.btn-hapus-populer');
    if (!btn) { return; }

    if (!confirm('Hapus destinasi ini dari daftar populer?')) { return; }

    var url = btn.getAttribute('data-url');
    var li  = btn.closest('.populer-item');

    btn.disabled = true;

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({})
    })
    .then(function(res) { return res.json(); })
    .then(function(data) {
        if (data.success) {
            li.remove();
            reindexPopulerNomor();
            updateBadgePopulerCount();
            updateSidebarCount();
            showNotif();
        } else {
            btn.disabled = false;
            alert('Gagal menghapus. Silakan coba lagi.');
        }
    })
    .catch(function() {
        btn.disabled = false;
        alert('Terjadi kesalahan jaringan.');
    });
});

// ---- SORTABLE: PAMFLET ----
var pamfletGrid = document.getElementById('pamflet-grid');
if (pamfletGrid) {
    Sortable.create(pamfletGrid, {
        animation: 150,
        ghostClass: 'sortable-ghost',
        handle: '.fa-grip-vertical',
        onEnd: function() {
            var items = pamfletGrid.querySelectorAll('.pamflet-item');
            var order = [];
            items.forEach(function(item, idx) {
                order.push(item.getAttribute('data-id'));
                var badge = item.querySelector('.pamflet-urutan');
                if (badge) { badge.textContent = idx + 1; }
            });

            fetch('{{ route("pamflet.order") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ order: order })
            })
            .then(function(res) { return res.json(); })
            .then(function(data) { if (data.success) { showNotif(); } });
        }
    });
}

// ---- TAMPIL HOME CHECKBOX AJAX ----
function updateCategoryState(catKey) {
    var checkboxes   = document.querySelectorAll('.cb-tampil-home[data-cat="' + catKey + '"]');
    var checkedCount = 0;
    checkboxes.forEach(function(cb) { if (cb.checked) { checkedCount++; } });

    var badge = document.querySelector('.badge-home-count[data-cat="' + catKey + '"]');
    if (badge) {
        badge.textContent = checkedCount + '/4 ditampilkan di home';
        if (checkedCount > 0) {
            badge.className = 'badge bg-primary ms-1 badge-home-count';
        } else {
            badge.className = 'badge bg-light text-secondary border ms-1 badge-home-count';
        }
        badge.setAttribute('data-cat', catKey);
    }

    checkboxes.forEach(function(cb) {
        if (!cb.checked) { cb.disabled = checkedCount >= 4; }
    });
}

document.querySelectorAll('.cb-tampil-home').forEach(function(cb) {
    cb.addEventListener('change', function() {
        var cbEl       = this;
        var catKey     = cbEl.getAttribute('data-cat');
        var url        = cbEl.getAttribute('data-url');
        var wasChecked = cbEl.checked;

        cbEl.disabled = true;

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({})
        })
        .then(function(res) { return res.json(); })
        .then(function(data) {
            if (!data.success) {
                cbEl.checked = !wasChecked;
                alert(data.message);
            }
            cbEl.disabled = false;
            updateCategoryState(catKey);
        })
        .catch(function() {
            cbEl.checked = !wasChecked;
            cbEl.disabled = false;
            updateCategoryState(catKey);
        });
    });
});

// ---- PREVIEW GAMBAR: MODAL TAMBAH ----
document.getElementById('gambar-tambah').addEventListener('change', function() {
    var file = this.files[0];
    if (file) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview-tambah-img').src = e.target.result;
            document.getElementById('tambah-preview').classList.remove('d-none');
        };
        reader.readAsDataURL(file);
    }
});

// ---- PREVIEW GAMBAR: MODAL EDIT ----
document.getElementById('gambar-edit').addEventListener('change', function() {
    var file = this.files[0];
    if (file) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview-edit-img').src = e.target.result;
            document.getElementById('edit-preview').classList.remove('d-none');
        };
        reader.readAsDataURL(file);
    }
});

// ---- POPULATE MODAL EDIT PAMFLET ----
document.querySelectorAll('.btn-edit-pamflet').forEach(function(btn) {
    btn.addEventListener('click', function() {
        var gambar = this.getAttribute('data-gambar');
        var url    = this.getAttribute('data-url');

        document.getElementById('edit-gambar-lama').src = gambar;
        document.getElementById('edit-pamflet-url').value = url;
        document.getElementById('gambar-edit').value = '';
        document.getElementById('edit-preview').classList.add('d-none');
        document.getElementById('edit-error').classList.add('d-none');
        document.getElementById('edit-error').textContent = '';
    });
});

// ---- SUBMIT TAMBAH PAMFLET (fetch) ----
document.getElementById('formTambahPamflet').addEventListener('submit', function(e) {
    e.preventDefault();

    var errDiv = document.getElementById('tambah-error');
    errDiv.classList.add('d-none');
    errDiv.textContent = '';

    var file = document.getElementById('gambar-tambah').files[0];
    var allowed = ['image/jpeg', 'image/png', 'image/jpg'];

    if (!file) {
        errDiv.textContent = 'Gambar wajib diunggah.';
        errDiv.classList.remove('d-none');
        return;
    }
    if (file.size > 2 * 1024 * 1024) {
        errDiv.textContent = 'Ukuran gambar maksimal 2MB.';
        errDiv.classList.remove('d-none');
        return;
    }
    if (allowed.indexOf(file.type) === -1) {
        errDiv.textContent = 'Format gambar harus JPEG, PNG, atau JPG.';
        errDiv.classList.remove('d-none');
        return;
    }

    var btn = document.getElementById('btnTambahSubmit');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Mengupload...';

    fetch('{{ route("pamflet.store") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: new FormData(this)
    })
    .then(function(res) {
        if (res.status === 422) {
            return res.json().then(function(data) {
                var msgs = [];
                var errs = data.errors;
                for (var k in errs) {
                    if (errs.hasOwnProperty(k)) {
                        msgs = msgs.concat(errs[k]);
                    }
                }
                errDiv.textContent = msgs.join(' ');
                errDiv.classList.remove('d-none');
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-upload me-1"></i> Upload';
            });
        }
        window.location.reload();
    })
    .catch(function() {
        errDiv.textContent = 'Terjadi kesalahan jaringan. Silakan coba lagi.';
        errDiv.classList.remove('d-none');
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-upload me-1"></i> Upload';
    });
});

// ---- SUBMIT EDIT PAMFLET (fetch) ----
document.getElementById('formEditPamflet').addEventListener('submit', function(e) {
    e.preventDefault();

    var errDiv = document.getElementById('edit-error');
    errDiv.classList.add('d-none');
    errDiv.textContent = '';

    var file    = document.getElementById('gambar-edit').files[0];
    var allowed = ['image/jpeg', 'image/png', 'image/jpg'];

    if (file) {
        if (file.size > 2 * 1024 * 1024) {
            errDiv.textContent = 'Ukuran gambar maksimal 2MB.';
            errDiv.classList.remove('d-none');
            return;
        }
        if (allowed.indexOf(file.type) === -1) {
            errDiv.textContent = 'Format gambar harus JPEG, PNG, atau JPG.';
            errDiv.classList.remove('d-none');
            return;
        }
    }

    var btn = document.getElementById('btnEditSubmit');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...';

    var url = document.getElementById('edit-pamflet-url').value;

    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: new FormData(this)
    })
    .then(function(res) {
        if (res.status === 422) {
            return res.json().then(function(data) {
                var msgs = [];
                var errs = data.errors;
                for (var k in errs) {
                    if (errs.hasOwnProperty(k)) {
                        msgs = msgs.concat(errs[k]);
                    }
                }
                errDiv.textContent = msgs.join(' ');
                errDiv.classList.remove('d-none');
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-save me-1"></i> Simpan';
            });
        }
        window.location.reload();
    })
    .catch(function() {
        errDiv.textContent = 'Terjadi kesalahan jaringan. Silakan coba lagi.';
        errDiv.classList.remove('d-none');
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-save me-1"></i> Simpan';
    });
});

// ---- RESET MODAL TAMBAH saat dibuka ----
document.getElementById('modalTambahPamflet').addEventListener('show.bs.modal', function() {
    document.getElementById('formTambahPamflet').reset();
    document.getElementById('tambah-error').classList.add('d-none');
    document.getElementById('tambah-preview').classList.add('d-none');
    var btn = document.getElementById('btnTambahSubmit');
    btn.disabled = false;
    btn.innerHTML = '<i class="fas fa-upload me-1"></i> Upload';
});

// ---- NOTIFIKASI ----
function showNotif() {
    var el = document.getElementById('notif-saved');
    el.style.display = 'block';
    setTimeout(function() { el.style.display = 'none'; }, 2000);
}

// ---- TOGGLE TAMPIL HOME (BLOG) ----
function toggleTampilHome(id, checkbox) {
    fetch('/wisata/' + id + '/toggle-home', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({})
    })
    .then(function(r) { return r.json(); })
    .then(function(data) {
        if (!data.success) {
            checkbox.checked = !checkbox.checked;
            alert(data.message || 'Gagal mengubah status tampil home');
        }
    })
    .catch(function() {
        checkbox.checked = !checkbox.checked;
        alert('Terjadi kesalahan jaringan.');
    });
}

// ---- DRAG & DROP URUTAN BLOG ----
document.querySelectorAll('.blog-tbody').forEach(function(tbody) {
    Sortable.create(tbody, {
        animation: 150,
        handle: '.drag-handle',
        ghostClass: 'sortable-ghost',
        onEnd: function() {
            var rows = tbody.querySelectorAll('tr[data-id]');
            var order = [];
            rows.forEach(function(row, idx) {
                var noEl = row.querySelector('.row-no');
                if (noEl) { noEl.textContent = idx + 1; }
                order.push(row.getAttribute('data-id'));
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
                    var notif = document.getElementById('order-notif-blog');
                    if (notif) {
                        notif.style.display = 'block';
                        setTimeout(function() { notif.style.display = 'none'; }, 2000);
                    }
                }
            });
        }
    });
});
</script>
</body>
</html>
