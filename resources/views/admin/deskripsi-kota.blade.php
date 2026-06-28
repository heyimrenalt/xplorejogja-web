<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Deskripsi Kota - Admin XPloreJogja</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: Poppins, sans-serif; background: #f8fafc; }</style>
</head>
<body>

<nav style="background: #0e7490; padding: 14px 24px; display: flex; justify-content: space-between; align-items: center;">
    <span style="color: white; font-weight: 700; font-size: 16px; display: flex; align-items: center; gap: 8px;">
        <i class="fas fa-map-marked-alt"></i> XPloreJogja
    </span>
    <div style="display: flex; gap: 8px;">
        <a href="{{ route('admin') }}?tab=deskripsi" style="background: white; color: #0e7490; border: none; border-radius: 8px; padding: 6px 16px; font-size: 13px; font-weight: 600; text-decoration: none; display: flex; align-items: center; gap: 6px;">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>
</nav>

<div class="container py-4" style="max-width: 800px;">

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden;">
        <div class="card-header py-3" style="background: #0e7490;">
            <h5 class="mb-0 text-white fw-bold">
                <i class="fas fa-city me-2"></i> Deskripsi Kota Yogyakarta
            </h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('deskripsi-kota.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Preview Gambar --}}
                <div class="mb-4">
                    <label class="form-label fw-bold" style="color: #0e7490;">Gambar Saat Ini</label>
                    @if($deskripsi->gambar)
                    <div class="mb-3">
                        <img src="{{ asset('images/' . $deskripsi->gambar) }}"
                             style="width: 100%; max-height: 300px; object-fit: cover; border-radius: 12px; border: 1px solid #e5e7eb;"
                             onerror="this.src='https://placehold.co/800x300?text=Gambar+tidak+ditemukan'">
                    </div>
                    @else
                    <div class="mb-3 p-4 text-center" style="background: #f1f5f9; border-radius: 12px; border: 2px dashed #d1d5db;">
                        <i class="fas fa-image fa-2x text-muted mb-2 d-block"></i>
                        <span class="text-muted small">Belum ada gambar</span>
                    </div>
                    @endif

                    <label class="form-label fw-bold" style="color: #0e7490;">Ganti Gambar</label>
                    <input type="file" name="gambar" class="form-control" accept="image/jpeg,image/png,image/jpg"
                           onchange="previewGambar(this)">
                    <small class="text-muted">Format: JPG, PNG. Maks 10MB. Kosongkan jika tidak ingin mengganti.</small>
                    <div id="preview-container" class="mt-3" style="display: none;">
                        <img id="preview-gambar" style="width: 100%; max-height: 300px; object-fit: cover; border-radius: 12px; border: 1px solid #e5e7eb;">
                    </div>
                </div>

                {{-- Teks Deskripsi --}}
                <div class="mb-4">
                    <label class="form-label fw-bold" style="color: #0e7490;">Teks Deskripsi <span class="text-danger">*</span></label>
                    <textarea name="teks" class="form-control" rows="10"
                              style="border-radius: 8px; font-size: 14px; line-height: 1.7;">{{ old('teks', $deskripsi->teks) }}</textarea>
                    <small class="text-muted">Teks ini akan tampil di halaman utama website.</small>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ url()->previous() != url()->current() ? url()->previous() : route('admin') }}" class="btn btn-secondary px-4">Batal</a>
                    <button type="submit" class="btn px-5 fw-bold text-white" style="background: #0e7490;">
                        <i class="fas fa-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function previewGambar(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview-gambar').src = e.target.result;
            document.getElementById('preview-container').style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
</body>
</html>
