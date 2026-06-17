<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Wisata</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f4f6f9; }
        .btn-primary  { background: #0891b2 !important; border-color: #0891b2 !important; color: #fff !important; }
        .btn-primary:hover  { background: #0e7490 !important; border-color: #0e7490 !important; }
        .btn-warning  { background: #fbbf24 !important; border-color: #fbbf24 !important; color: #78350f !important; }
        .btn-warning:hover  { background: #f59e0b !important; color: #78350f !important; }
        .btn-danger   { background: #ef4444 !important; border-color: #ef4444 !important; color: #fff !important; }
        .btn-danger:hover   { background: #dc2626 !important; }
        .btn-success  { background: #0891b2 !important; border-color: #0891b2 !important; color: #fff !important; }
        .btn-success:hover  { background: #0e7490 !important; }
        .btn-secondary { background: #fff !important; border: 1px solid #d1d5db !important; color: #4b5563 !important; }
        .btn-secondary:hover { background: #f9fafb !important; color: #374151 !important; }
        .card { border-radius: 12px !important; border: 1px solid #e5e7eb !important; }
        .card-header { border-radius: 12px 12px 0 0 !important; }
        .card-header.bg-primary { background: #0e7490 !important; }
        .card-header.bg-warning { background: #fbbf24 !important; color: #78350f !important; }
        .card-header.bg-success { background: #0e7490 !important; }
        .form-control, .form-select { border: 1px solid #d1d5db !important; border-radius: 8px !important; }
        .form-control:focus, .form-select:focus { border-color: #0891b2 !important; box-shadow: 0 0 0 0.2rem rgba(8,145,178,0.15) !important; }
        .form-label { color: #374151; font-weight: 500; font-size: 14px; }
        .alert-success { background: #f0fdf4 !important; border-color: #bbf7d0 !important; color: #166534 !important; }
        .alert-danger  { background: #fef2f2 !important; border-color: #fecaca !important; color: #991b1b !important; }
    </style>
</head>
<body class="bg-light">

<nav style="background: #0e7490; padding: 14px 24px; display: flex; justify-content: space-between; align-items: center;">
    <span style="color: white; font-weight: 700; font-size: 16px; display: flex; align-items: center; gap: 8px;">
        <i class="fas fa-map-marked-alt"></i> XPloreJogja
    </span>
    <div style="display: flex; gap: 8px;">
        <a href="{{ route('admin') }}" style="background: white; color: #0e7490; border: none; border-radius: 8px; padding: 6px 16px; font-size: 13px; font-weight: 600; text-decoration: none; display: flex; align-items: center; gap: 6px;">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>
</nav>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-warning text-dark py-3">
                    <h5 class="mb-0"><i class="fas fa-edit me-2"></i> Edit Destinasi Wisata</h5>
                </div>
                <div class="card-body p-4">

                    @if ($errors->any())
                    <div class="alert alert-danger mb-4">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('wisata.update', $wisata->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- KATEGORI BERTINGKAT --}}
                        <div class="row mb-4 p-3 bg-light rounded shadow-sm mx-0">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label class="form-label fw-bold text-primary">Kategori Utama <span class="text-danger">*</span></label>
                                <select id="parent_category" class="form-select shadow-none">
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}"
                                        {{ ($wisata->category && $wisata->category->parent_id == $cat->id) ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-primary">Sub Kategori <span class="text-danger">*</span></label>
                                <select name="category_id" id="sub_category" class="form-select shadow-none @error('category_id') is-invalid @enderror">
                                    <option value="">-- Pilih Kategori Utama Dulu --</option>
                                    {{-- Opsi aktif akan diisi oleh JavaScript --}}
                                </select>
                                @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        {{-- DESTINASI POPULER --}}
                        <div class="mb-4 p-3 bg-light rounded border">
                            <div class="form-check">
                                @php
                                    $isPopulerChecked = old('is_populer', $wisata->is_populer) ? true : false;
                                    $disablePopuler   = ($populerCount >= 7 && !$wisata->is_populer);
                                @endphp
                                <input type="checkbox" name="is_populer" id="is_populer" value="1"
                                       class="form-check-input"
                                       {{ $isPopulerChecked ? 'checked' : '' }}
                                       {{ $disablePopuler ? 'disabled' : '' }}>
                                <label for="is_populer" class="form-check-label fw-bold">
                                    <i class="fas fa-star text-warning me-1"></i> Tampilkan di Destinasi Populer
                                </label>
                            </div>
                            @if($disablePopuler)
                            <small class="text-danger mt-1 d-block">
                                <i class="fas fa-exclamation-triangle me-1"></i>
                                Maksimal 7 destinasi populer telah tercapai. Hapus dulu salah satu untuk menambah baru.
                            </small>
                            @elseif(!$wisata->is_populer)
                            <small class="text-muted mt-1 d-block">
                                Slot tersisa: {{ 7 - $populerCount }} dari 7
                            </small>
                            @else
                            <small class="text-success mt-1 d-block">
                                <i class="fas fa-check-circle me-1"></i> Saat ini ditampilkan di Destinasi Populer
                            </small>
                            @endif
                            @error('is_populer')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- NAMA WISATA --}}
                        <div class="mb-4">
                            <label id="label-nama" class="form-label fw-bold">Nama Wisata <span class="text-danger">*</span></label>
                            <input type="text" name="nama_wisata" class="form-control @error('nama_wisata') is-invalid @enderror"
                                value="{{ old('nama_wisata', $wisata->nama_wisata) }}">
                            @error('nama_wisata') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- GAMBAR --}}
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Gambar 1 (Utama)</label>
                                @if($wisata->gambar1)
                                <img src="{{ asset('images/' . $wisata->gambar1) }}" class="img-thumbnail mb-2" style="height:100px;">
                                @endif
                                <input type="file" name="gambar1" class="form-control" accept="image/*">
                                <small class="text-muted">Kosongkan jika tidak ingin mengganti</small>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Gambar 2</label>
                                @if($wisata->gambar2)
                                <img src="{{ asset('images/' . $wisata->gambar2) }}" class="img-thumbnail mb-2" style="height:100px;">
                                @endif
                                <input type="file" name="gambar2" class="form-control" accept="image/*">
                                <small class="text-muted">Kosongkan jika tidak ingin mengganti</small>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Gambar 3</label>
                                @if($wisata->gambar3)
                                <img src="{{ asset('images/' . $wisata->gambar3) }}" class="img-thumbnail mb-2" style="height:100px;">
                                @endif
                                <input type="file" name="gambar3" class="form-control" accept="image/*">
                                <small class="text-muted">Kosongkan jika tidak ingin mengganti</small>
                            </div>
                        </div>

                        {{-- DESKRIPSI --}}
                        <div id="section-deskripsi" class="mb-4">
                            <label class="form-label fw-bold">Deskripsi <span class="text-danger">*</span></label>
                            <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="4">{{ old('deskripsi', $wisata->deskripsi) }}</textarea>
                            @error('deskripsi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- OPERASIONAL (disembunyikan untuk Penginapan) --}}
                        <div id="section-operasional">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Jam Buka <span class="text-danger">*</span></label>
                                    <input type="text" name="jam_buka" class="form-control @error('jam_buka') is-invalid @enderror" value="{{ old('jam_buka', $wisata->jam_buka) }}">
                                    @error('jam_buka') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Jam Tutup <span class="text-danger">*</span></label>
                                    <input type="text" name="jam_tutup" class="form-control @error('jam_tutup') is-invalid @enderror" value="{{ old('jam_tutup', $wisata->jam_tutup) }}">
                                    @error('jam_tutup') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        {{-- CATATAN JAM / INFO TIKET TAMBAHAN --}}
                        <div id="section-catatan-jam" class="mb-4">
                            <label id="label-catatan-jam" class="form-label fw-bold">Info Tiket Tambahan</label>
                            <textarea id="input-catatan-jam" name="info_tiket_tambahan" class="form-control" placeholder="Contoh: Termasuk asuransi Rp500">{{ old('info_tiket_tambahan', $wisata->info_tiket_tambahan) }}</textarea>
                        </div>

                        {{-- HARGA (label berubah dinamis untuk Penginapan) --}}
                        <div class="mb-4">
                            <label id="label-harga" class="form-label fw-bold">Harga Tiket <span class="text-danger">*</span></label>
                            <input type="text" id="input-harga" name="harga_tiket" class="form-control @error('harga_tiket') is-invalid @enderror" value="{{ old('harga_tiket', $wisata->harga_tiket) }}" placeholder="Rp 20.000">
                            @error('harga_tiket') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Fasilitas <span class="text-danger">*</span></label>
                            <textarea name="fasilitas" class="form-control @error('fasilitas') is-invalid @enderror" rows="3" placeholder="Contoh: Mushola, Gazebo, Toilet Umum, Penginapan=Range Rp. 200.000-Rp. 500.000/malam">{{ old('fasilitas', $wisata->fasilitas) }}</textarea>
                            <small class="text-muted">Pisahkan setiap fasilitas dengan koma. Untuk fasilitas yang punya rincian, gunakan format: <strong>NamaFasilitas=Rincian</strong> (contoh: <em>Penginapan=Range Rp. 200.000-Rp. 500.000/malam</em>). Jika tidak ada rincian, cukup tulis nama fasilitas saja.</small>
                            @error('fasilitas') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Alamat Lengkap <span class="text-danger">*</span></label>
                            <textarea name="alamat_lengkap" class="form-control @error('alamat_lengkap') is-invalid @enderror" rows="2">{{ old('alamat_lengkap', $wisata->alamat_lengkap) }}</textarea>
                            @error('alamat_lengkap') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Link Google Maps <span class="text-danger">*</span></label>
                            <input type="url" name="link_gmaps" class="form-control @error('link_gmaps') is-invalid @enderror" value="{{ old('link_gmaps', $wisata->link_gmaps) }}">
                            @error('link_gmaps') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div id="section-parkir-tiket">
                            <div class="mb-4">
                                <label class="form-label fw-bold">Rincian Biaya Parkir <span class="text-danger">*</span></label>
                                <textarea name="biaya_parkir" class="form-control @error('biaya_parkir') is-invalid @enderror">{{ old('biaya_parkir', $wisata->biaya_parkir) }}</textarea>
                                @error('biaya_parkir') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        {{-- MEDIA SOSIAL --}}
                        <hr class="my-4">
                        <h6 class="text-primary fw-bold mb-3"><i class="fas fa-share-alt me-2"></i> Media Sosial</h6>
                        <div class="row mb-2">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Instagram (@)</label>
                                <input type="text" name="instagram" class="form-control" value="{{ old('instagram', $wisata->instagram) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">WhatsApp</label>
                                <input type="text" name="whatsapp" class="form-control" value="{{ old('whatsapp', $wisata->whatsapp) }}">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Facebook</label>
                                <input type="text" name="facebook" class="form-control" value="{{ old('facebook', $wisata->facebook) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Twitter (X)</label>
                                <input type="text" name="twitter" class="form-control" value="{{ old('twitter', $wisata->twitter) }}">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">TikTok</label>
                                <input type="text" name="tiktok" class="form-control" value="{{ old('tiktok', $wisata->tiktok) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">YouTube</label>
                                <input type="text" name="youtube" class="form-control" value="{{ old('youtube', $wisata->youtube) }}">
                            </div>
                        </div>
                        
                        <hr class="my-4">
                        <h6 class="text-primary fw-bold mb-3"><i class="fas fa-star me-2"></i> Manajemen Ulasan</h6>

                        @if($ulasans->isNotEmpty())
                        <div class="mb-3">
                            <p class="small text-muted mb-2">Ulasan yang sudah tersimpan:</p>
                            <ul class="list-group list-group-flush border rounded mb-3">
                                @foreach($ulasans as $ul)
                                <li class="list-group-item py-2">
                                    <span class="small">
                                        <strong>{{ $ul->nama }}</strong> &nbsp;|&nbsp;
                                        {{ $ul->rating }}&#9733; &nbsp;|&nbsp;
                                        {{ $ul->teks }}
                                        <span class="badge bg-{{ $ul->status === 'approved' ? 'success' : ($ul->status === 'rejected' ? 'danger' : 'warning') }} ms-2">{{ $ul->status }}</span>
                                    </span>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <p class="small text-muted mb-2">Tambah ulasan baru (tidak akan menduplikat yang sudah ada):</p>
                        <div class="row mb-3">
                            <div class="col-md-4 mb-2">
                                <label class="form-label">Nama Pengulas</label>
                                <input type="text" id="input-nama-ulasan" class="form-control" placeholder="Nama pengulas">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label class="form-label">Rating</label>
                                <select id="input-rating-ulasan" class="form-control form-select">
                                    <option value="1">&#9733; 1</option>
                                    <option value="2">&#9733;&#9733; 2</option>
                                    <option value="3">&#9733;&#9733;&#9733; 3</option>
                                    <option value="4">&#9733;&#9733;&#9733;&#9733; 4</option>
                                    <option value="5" selected>&#9733;&#9733;&#9733;&#9733;&#9733; 5</option>
                                </select>
                            </div>
                            <div class="col-md-5 mb-2">
                                <label class="form-label">Isi Ulasan</label>
                                <textarea id="input-teks-ulasan" class="form-control" rows="2" placeholder="Tulis ulasan..."></textarea>
                            </div>
                        </div>
                        <div class="mb-3">
                            <button type="button" class="btn btn-primary btn-sm" onclick="tambahUlasan()">
                                <i class="fas fa-plus me-1"></i> Tambah ke History
                            </button>
                        </div>
                        <div id="daftar-ulasan-history" class="mb-3">
                            <p class="text-muted small">Belum ada ulasan baru ditambahkan.</p>
                        </div>
                        <input type="hidden" name="ulasan_raw" id="ulasan_raw">

                        <input type="hidden" name="redirect_to" value="{{ old('redirect_to', url()->previous()) }}">
                        {{-- TOMBOL --}}
                        <div class="d-flex justify-content-end gap-2 pt-3">
                            <a href="{{ route('admin') }}" class="btn btn-secondary px-4">Batal</a>
                            <button type="submit" class="btn btn-warning px-5 text-dark fw-bold">
                                <i class="fas fa-save me-1"></i> Update Wisata
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Manajemen Ulasan
var ulasanList = [];

function tambahUlasan() {
    var nama   = document.getElementById('input-nama-ulasan').value.trim();
    var rating = document.getElementById('input-rating-ulasan').value;
    var teks   = document.getElementById('input-teks-ulasan').value.trim();

    if (!nama || !teks) {
        alert('Nama dan isi ulasan wajib diisi.');
        return;
    }

    ulasanList.push({ nama: nama, rating: rating, teks: teks });
    document.getElementById('input-nama-ulasan').value = '';
    document.getElementById('input-teks-ulasan').value = '';
    renderUlasanHistory();
    updateUlasanRaw();
}

function hapusUlasan(idx) {
    ulasanList.splice(idx, 1);
    renderUlasanHistory();
    updateUlasanRaw();
}

function renderUlasanHistory() {
    var container = document.getElementById('daftar-ulasan-history');
    if (ulasanList.length === 0) {
        container.innerHTML = '<p class="text-muted small">Belum ada ulasan baru ditambahkan.</p>';
        return;
    }
    var html = '<ul class="list-group list-group-flush border rounded">';
    for (var i = 0; i < ulasanList.length; i++) {
        var u = ulasanList[i];
        html += '<li class="list-group-item d-flex justify-content-between align-items-center py-2">';
        html += '<span class="small"><strong>' + escapeHtml(u.nama) + '</strong> &nbsp;|&nbsp; ' + u.rating + '&#9733; &nbsp;|&nbsp; ' + escapeHtml(u.teks) + '</span>';
        html += '<button type="button" class="btn btn-danger btn-sm py-0 px-2" onclick="hapusUlasan(' + i + ')"><i class="fas fa-trash"></i></button>';
        html += '</li>';
    }
    html += '</ul>';
    container.innerHTML = html;
}

function updateUlasanRaw() {
    var raw = '';
    for (var i = 0; i < ulasanList.length; i++) {
        var u = ulasanList[i];
        if (raw) { raw += "\n"; }
        raw += u.nama + '|' + u.rating + '|' + u.teks;
    }
    document.getElementById('ulasan_raw').value = raw;
}

function escapeHtml(str) {
    var div = document.createElement('div');
    div.appendChild(document.createTextNode(str));
    return div.innerHTML;
}

// Data sub kategori dari database (dikirim dari controller)
const allCategories = @json($categories);

// Saat halaman load, set nilai kategori yang sudah tersimpan
const savedCategoryId = {{ $wisata->category_id ?? 'null' }};
const savedParentId = {{ $wisata->category ? $wisata->category->parent_id : 'null' }};

// Fungsi mengisi dropdown sub kategori
function fillSubCategory(parentId, selectedSubId = null) {
    const subSelect = document.getElementById('sub_category');
    subSelect.innerHTML = '<option value="">-- Pilih Sub Kategori --</option>';

    const parent = allCategories.find(c => c.id == parentId);
    if (parent && parent.children) {
        parent.children.forEach(sub => {
            const opt = document.createElement('option');
            opt.value = sub.id;
            opt.textContent = sub.name;
            if (selectedSubId && sub.id == selectedSubId) opt.selected = true;
            subSelect.appendChild(opt);
        });
    }
}

function applyJasaMode(parentId) {
    const isJasa    = parentId == 15 || parentId == 19;
    const isKuliner = parentId == 23;

    document.getElementById('section-deskripsi').style.display    = (isJasa || isKuliner) ? 'none' : '';
    document.getElementById('section-operasional').style.display  = isJasa ? 'none' : '';
    document.getElementById('section-parkir-tiket').style.display = (isJasa || isKuliner) ? 'none' : '';
    document.getElementById('section-catatan-jam').style.display  = isJasa ? 'none' : '';

    document.getElementById('label-catatan-jam').innerHTML  = isKuliner ? 'Catatan Jam Operasional' : 'Info Tiket Tambahan';
    document.getElementById('input-catatan-jam').placeholder = isKuliner ? 'Contoh: Tutup setiap Senin & Hari Raya' : 'Contoh: Termasuk asuransi Rp500';

    let labelNama, labelHarga, placeholderHarga;
    if (parentId == 15) {
        labelNama = 'Nama Penginapan'; labelHarga = 'Harga per Malam'; placeholderHarga = 'Rp 150.000 - Rp 500.000';
    } else if (parentId == 19) {
        labelNama = 'Nama Layanan'; labelHarga = 'Harga Sewa'; placeholderHarga = 'Rp 100.000/hari';
    } else if (parentId == 23) {
        labelNama = 'Nama Tempat Kuliner'; labelHarga = 'Range Harga Menu'; placeholderHarga = 'Rp 15.000 - Rp 50.000';
    } else {
        labelNama = 'Nama Wisata'; labelHarga = 'Harga Tiket'; placeholderHarga = 'Rp 20.000';
    }

    document.getElementById('label-nama').innerHTML  = labelNama  + ' <span class="text-danger">*</span>';
    document.getElementById('label-harga').innerHTML = labelHarga + ' <span class="text-danger">*</span>';
    document.getElementById('input-harga').placeholder = placeholderHarga;
}

// Set nilai awal saat halaman dibuka
if (savedParentId) {
    document.getElementById('parent_category').value = savedParentId;
    fillSubCategory(savedParentId, savedCategoryId);
    applyJasaMode(savedParentId);
}

// Event saat admin ganti kategori utama
document.getElementById('parent_category').addEventListener('change', function() {
    fillSubCategory(this.value);
    applyJasaMode(this.value);
});

</script>

</body>
</html>