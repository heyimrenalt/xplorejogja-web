<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Wisata</title>
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
<body>

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

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0"><i class="fas fa-plus-circle me-2"></i> Tambah Destinasi Wisata XPloreJogja</h5>
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

                    <form action="{{ route('wisata.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- SELEKSI KATEGORI BERTINGKAT -->
                        <div class="row mb-4 p-3 bg-light rounded shadow-sm mx-0">
    <div class="col-md-6 mb-3 mb-md-0">
        <label class="form-label font-weight-bold text-primary">Kategori Utama <span class="text-danger">*</span></label>
        <select id="parent_category" name="parent_category" class="form-control form-select shadow-none">
            <option value="">-- Pilih Kategori --</option>
            <option value="Wisata Alam" {{ old('parent_category') == 'Wisata Alam' ? 'selected' : '' }}>Wisata Alam</option>
            <option value="Hiburan Keluarga" {{ old('parent_category') == 'Hiburan Keluarga' ? 'selected' : '' }}>Hiburan Keluarga</option>
            <option value="Penginapan" {{ old('parent_category') == 'Penginapan' ? 'selected' : '' }}>Penginapan</option>
            <option value="Transportasi" {{ old('parent_category') == 'Transportasi' ? 'selected' : '' }}>Transportasi</option>
            <option value="Kuliner" {{ old('parent_category') == 'Kuliner' ? 'selected' : '' }}>Kuliner</option>
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label font-weight-bold text-primary">Sub Kategori <span class="text-danger">*</span></label>
        <select name="category_id" id="sub_category" class="form-control form-select shadow-none">
            <option value="">-- Pilih Kategori Utama Dulu --</option>
        </select>
        <small class="text-muted italic">*Admin wajib memilih sub-kategori agar data terkelompok rapi.</small>
    </div>
</div>

                        <!-- Destinasi Populer -->
                        <div class="mb-4 p-3 bg-light rounded border">
                            <div class="form-check">
                                <input type="checkbox" name="is_populer" id="is_populer" value="1"
                                       class="form-check-input"
                                       {{ old('is_populer') ? 'checked' : '' }}
                                       {{ $populerCount >= 7 ? 'disabled' : '' }}>
                                <label for="is_populer" class="form-check-label fw-bold">
                                    <i class="fas fa-star text-warning me-1"></i> Tampilkan di Destinasi Populer
                                </label>
                            </div>
                            @if($populerCount >= 7)
                            <small class="text-danger mt-1 d-block">
                                <i class="fas fa-exclamation-triangle me-1"></i>
                                Maksimal 7 destinasi populer telah tercapai. Hapus dulu salah satu untuk menambah baru.
                            </small>
                            @else
                            <small class="text-muted mt-1 d-block">
                                Slot tersisa: {{ 7 - $populerCount }} dari 7
                            </small>
                            @endif
                            @error('is_populer')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Nama Wisata -->
                        <div class="mb-4">
                            <label id="label-nama" class="form-label font-weight-bold">Nama Wisata <span class="text-danger">*</span></label>
                            <input type="text" name="nama_wisata" class="form-control" value="{{ old('nama_wisata') }}" placeholder="Contoh: Pantai Parangtritis">
                        </div>

                        <!-- Upload 3 Gambar Slider -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label class="form-label font-weight-bold">Gambar 1 (Utama) <span class="text-danger">*</span></label>
                                <input type="file" name="gambar1" class="form-control" accept="image/*">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label font-weight-bold">Gambar 2</label>
                                <input type="file" name="gambar2" class="form-control" accept="image/*">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label font-weight-bold">Gambar 3</label>
                                <input type="file" name="gambar3" class="form-control" accept="image/*">
                            </div>
                        </div>

                        <div id="section-deskripsi" class="mb-4">
                            <label class="form-label font-weight-bold">Deskripsi <span class="text-danger">*</span></label>
                            <textarea name="deskripsi" class="form-control" rows="4" placeholder="Jelaskan detail keindahan tempat ini...">{{ old('deskripsi') }}</textarea>
                        </div>

                        <!-- Jam Operasional (disembunyikan untuk Penginapan) -->
                        <div id="section-operasional">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label class="form-label font-weight-bold">Jam Buka <span class="text-danger">*</span></label>
                                    <input type="text" name="jam_buka" class="form-control" value="{{ old('jam_buka') }}" placeholder="06:00 WIB">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label font-weight-bold">Jam Tutup <span class="text-danger">*</span></label>
                                    <input type="text" name="jam_tutup" class="form-control" value="{{ old('jam_tutup') }}" placeholder="18:00 WIB">
                                </div>
                            </div>
                        </div>

                        <!-- Catatan Jam / Info Tiket Tambahan -->
                        <div id="section-catatan-jam" class="mb-4">
                            <label id="label-catatan-jam" class="form-label font-weight-bold">Info Tiket Tambahan</label>
                            <textarea id="input-catatan-jam" name="info_tiket_tambahan" class="form-control" placeholder="Contoh: Termasuk asuransi Rp500">{{ old('info_tiket_tambahan') }}</textarea>
                        </div>

                        <!-- Harga (label berubah dinamis untuk Penginapan) -->
                        <div class="mb-4">
                            <label id="label-harga" class="form-label font-weight-bold">Harga Tiket <span class="text-danger">*</span></label>
                            <input type="text" id="input-harga" name="harga_tiket" class="form-control" value="{{ old('harga_tiket') }}" placeholder="Rp 20.000">
                        </div>

                        <div class="mb-4">
                            <label class="form-label font-weight-bold">Fasilitas <span class="text-danger">*</span></label>
                            <textarea name="fasilitas" class="form-control" rows="3" placeholder="Contoh: Mushola, Gazebo, Toilet Umum, Penginapan=Range Rp. 200.000-Rp. 500.000/malam">{{ old('fasilitas') }}</textarea>
                            <small class="text-muted">Pisahkan setiap fasilitas dengan koma. Untuk fasilitas yang punya rincian, gunakan format: <strong>NamaFasilitas=Rincian</strong> (contoh: <em>Penginapan=Range Rp. 200.000-Rp. 500.000/malam</em>). Jika tidak ada rincian, cukup tulis nama fasilitas saja.</small>
                        </div>

                        <div class="mb-4">
                            <label class="form-label font-weight-bold">Alamat Lengkap <span class="text-danger">*</span></label>
                            <textarea name="alamat_lengkap" class="form-control" rows="2">{{ old('alamat_lengkap') }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label font-weight-bold">Link Google Maps <span class="text-danger">*</span></label>
                            <input type="url" name="link_gmaps" class="form-control" value="{{ old('link_gmaps') }}" placeholder="https://goo.gl/maps/..." >
                        </div>

                        <div id="section-parkir-tiket">
                            <div class="mb-4">
                                <label class="form-label font-weight-bold">Rincian Biaya Parkir <span class="text-danger">*</span></label>
                                <textarea name="biaya_parkir" class="form-control" placeholder="Contoh: Mobil=Rp5.000, Motor=Rp2.000">{{ old('biaya_parkir') }}</textarea>
                            </div>
                        </div>

                        <hr class="my-4">
                        <h6 class="text-primary font-weight-bold mb-3"><i class="fas fa-share-alt me-2"></i> Media Sosial</h6>

                        <div class="row mb-2">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Instagram (@)</label>
                                <input type="text" name="instagram" class="form-control shadow-none" value="{{ old('instagram') }}" placeholder="@pantaiparangtritis">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">WhatsApp (No Telp)</label>
                                <input type="text" name="whatsapp" class="form-control shadow-none" value="{{ old('whatsapp') }}" placeholder="08123456789">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Facebook</label>
                                <input type="text" name="facebook" class="form-control shadow-none" value="{{ old('facebook') }}" placeholder="Nama Akun/Halaman FB">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Twitter (X)</label>
                                <input type="text" name="twitter" class="form-control shadow-none" value="{{ old('twitter') }}" placeholder="@parangtritis_x">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">TikTok</label>
                                <input type="text" name="tiktok" class="form-control shadow-none" value="{{ old('tiktok') }}" placeholder="@parangtritis_tiktok">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">YouTube</label>
                                <input type="text" name="youtube" class="form-control shadow-none" value="{{ old('youtube') }}" placeholder="Nama Channel YouTube">
                            </div>
                        </div>

                        {{-- PAKET OPEN TRIP (hanya tampil jika sub kategori = Ojek Wisata id 22) --}}
                        <div id="section-paket-open-trip" style="display:none;">
                            <hr class="my-4">
                            <h6 class="mb-3" style="color:#0e7490; font-weight:700;">
                                <i class="fas fa-route me-2"></i> Paket Open Trip
                            </h6>
                            <small class="text-muted d-block mb-3">
                                Tambah paket open trip untuk ditampilkan di halaman detail. Nama paket &amp; gambar wajib diisi.
                            </small>

                            <div id="paket-baru-list"></div>

                            <button type="button" class="btn btn-sm mb-3"
                                    style="background:#e0f2fe; color:#0e7490; border:1px dashed #0e7490;"
                                    onclick="tambahPaketBaru()">
                                <i class="fas fa-plus me-1"></i> + Tambah Paket
                            </button>
                        </div>

                        <hr class="my-4">
                        <h6 class="text-primary font-weight-bold mb-3"><i class="fas fa-star me-2"></i> Manajemen Ulasan</h6>

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
                            <p class="text-muted small">Belum ada ulasan ditambahkan.</p>
                        </div>
                        <input type="hidden" name="ulasan_raw" id="ulasan_raw">

                        <input type="hidden" name="redirect_to" value="{{ old('redirect_to', url()->previous()) }}">
                        <div class="d-flex justify-content-end gap-2 pt-3">
                            <a href="{{ route('admin') }}" class="btn btn-secondary px-4">Batal</a>
                            <button type="submit" class="btn btn-success px-5">Simpan Wisata</button>
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
        container.innerHTML = '<p class="text-muted small">Belum ada ulasan ditambahkan.</p>';
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

// 1. Logika Kategori Bertingkat
// 1. Logika Kategori Bertingkat - sesuai database sekarang
const subCategories = @json($subKategoriMap);

function applyJasaMode(parentName) {
    const isJasa    = parentName === 'Penginapan' || parentName === 'Transportasi';
    const isKuliner = parentName === 'Kuliner';

    document.getElementById('section-deskripsi').style.display    = (isJasa || isKuliner) ? 'none' : '';
    document.getElementById('section-operasional').style.display  = isJasa ? 'none' : '';
    document.getElementById('section-parkir-tiket').style.display = (isJasa || isKuliner) ? 'none' : '';
    document.getElementById('section-catatan-jam').style.display  = isJasa ? 'none' : '';

    document.getElementById('label-catatan-jam').innerHTML  = isKuliner ? 'Catatan Jam Operasional' : 'Info Tiket Tambahan';
    document.getElementById('input-catatan-jam').placeholder = isKuliner ? 'Contoh: Tutup setiap Senin & Hari Raya' : 'Contoh: Termasuk asuransi Rp500';

    let labelNama, labelHarga, placeholderHarga;
    if (parentName === 'Penginapan') {
        labelNama = 'Nama Penginapan'; labelHarga = 'Harga per Malam'; placeholderHarga = 'Rp 150.000 - Rp 500.000';
    } else if (parentName === 'Transportasi') {
        labelNama = 'Nama Layanan'; labelHarga = 'Harga Sewa'; placeholderHarga = 'Rp 100.000/hari';
    } else if (parentName === 'Kuliner') {
        labelNama = 'Nama Tempat Kuliner'; labelHarga = 'Range Harga Menu'; placeholderHarga = 'Rp 15.000 - Rp 50.000';
    } else {
        labelNama = 'Nama Wisata'; labelHarga = 'Harga Tiket'; placeholderHarga = 'Rp 20.000';
    }

    document.getElementById('label-nama').innerHTML  = labelNama  + ' <span class="text-danger">*</span>';
    document.getElementById('label-harga').innerHTML = labelHarga + ' <span class="text-danger">*</span>';
    document.getElementById('input-harga').placeholder = placeholderHarga;
}

document.getElementById('parent_category').addEventListener('change', function() {
    const subSelect = document.getElementById('sub_category');
    const selected = this.value;

    subSelect.innerHTML = '<option value="">-- Pilih Sub Kategori --</option>';

    if(subCategories[selected]) {
        subCategories[selected].forEach(sub => {
            let opt = document.createElement('option');
            opt.value = sub.id;
            opt.innerHTML = sub.name;
            subSelect.appendChild(opt);
        });
    }

    applyJasaMode(selected);
    toggleSectionPaket(0); // reset saat ganti parent
});

document.getElementById('sub_category').addEventListener('change', function() {
    toggleSectionPaket(this.value);
});

document.addEventListener('DOMContentLoaded', function() {
    const oldParent = "{{ old('parent_category') }}";
    const oldCategoryId = "{{ old('category_id') }}";

    if (oldParent) {
        const parentSelect = document.getElementById('parent_category');
        parentSelect.value = oldParent;

        const subSelect = document.getElementById('sub_category');
        subSelect.innerHTML = '<option value="">-- Pilih Sub Kategori --</option>';

        if (subCategories[oldParent]) {
            subCategories[oldParent].forEach(sub => {
                let opt = document.createElement('option');
                opt.value = sub.id;
                opt.innerHTML = sub.name;
                if (sub.id == oldCategoryId) opt.selected = true;
                subSelect.appendChild(opt);
            });
        }

        applyJasaMode(oldParent);
        toggleSectionPaket(oldCategoryId);
    }
});

// --- Paket Open Trip ---
var paketBaruCount = 0;

function toggleSectionPaket(subCatId) {
    var section = document.getElementById('section-paket-open-trip');
    if (section) {
        section.style.display = (subCatId == 22) ? '' : 'none';
    }
}

function tambahPaketBaru() {
    var idx = paketBaruCount++;
    var container = document.getElementById('paket-baru-list');
    var div = document.createElement('div');
    div.className = 'border rounded p-3 mb-3 bg-white';
    div.id = 'paket-baru-row-' + idx;
    div.innerHTML = `
        <div class="d-flex justify-content-between align-items-center mb-2">
            <strong class="small" style="color:#0e7490;">Paket Baru #${idx + 1}</strong>
            <button type="button" class="btn btn-danger btn-sm py-0 px-2" onclick="hapusPaketBaru(${idx})">
                <i class="fas fa-trash"></i>
            </button>
        </div>
        <div class="row">
            <div class="col-md-6 mb-2">
                <label class="form-label small">Nama Paket <span class="text-danger">*</span></label>
                <input type="text" name="paket[${idx}][nama_paket]" class="form-control form-control-sm" placeholder="Contoh: Paket 3D2N Pantai" required>
            </div>
            <div class="col-md-6 mb-2">
                <label class="form-label small">Gambar Paket <span class="text-danger">*</span></label>
                <input type="file" name="paket[${idx}][gambar]" class="form-control form-control-sm" accept="image/*" required>
            </div>
            <div class="col-md-6 mb-2">
                <label class="form-label small">Lokasi</label>
                <input type="text" name="paket[${idx}][lokasi]" class="form-control form-control-sm" placeholder="Contoh: Yogyakarta - Merapi">
            </div>
            <div class="col-md-2 mb-2">
                <label class="form-label small">Durasi</label>
                <input type="text" name="paket[${idx}][durasi]" class="form-control form-control-sm" placeholder="3D2N">
            </div>
            <div class="col-md-2 mb-2">
                <label class="form-label small">Transport</label>
                <input type="text" name="paket[${idx}][transport]" class="form-control form-control-sm" placeholder="Elf AC">
            </div>
            <div class="col-md-2 mb-2">
                <label class="form-label small">Makan</label>
                <input type="text" name="paket[${idx}][makan]" class="form-control form-control-sm" placeholder="5x">
            </div>
            <div class="col-md-4 mb-2">
                <label class="form-label small">Harga (Rp/orang)</label>
                <input type="number" name="paket[${idx}][harga]" class="form-control form-control-sm" placeholder="350000">
            </div>
            <div class="col-12 mb-2">
                <label class="form-label small">Destinasi yang Dikunjungi</label>
                <textarea name="paket[${idx}][destinasi_kunjungi]" class="form-control form-control-sm" rows="3"
                    placeholder="Satu destinasi per baris&#10;Contoh:&#10;Pantai Parangtritis&#10;Bukit Bintang&#10;Taman Sari"></textarea>
            </div>
            <div class="col-md-6 mb-2">
                <label class="form-label small">Termasuk</label>
                <textarea name="paket[${idx}][termasuk]" class="form-control form-control-sm" rows="3"
                    placeholder="Satu item per baris&#10;Contoh:&#10;Guide lokal&#10;Tiket masuk&#10;Snack"></textarea>
            </div>
            <div class="col-md-6 mb-2">
                <label class="form-label small">Tidak Termasuk</label>
                <textarea name="paket[${idx}][tidak_termasuk]" class="form-control form-control-sm" rows="3"
                    placeholder="Satu item per baris&#10;Contoh:&#10;Penginapan&#10;Biaya pribadi"></textarea>
            </div>
        </div>`;
    container.appendChild(div);
}

function hapusPaketBaru(idx) {
    var row = document.getElementById('paket-baru-row-' + idx);
    if (row) row.remove();
}

</script>
</body>
</html>