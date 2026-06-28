<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pamflet</title>
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
        <a href="{{ route('pamflet.index') }}" style="background: white; color: #0e7490; border: none; border-radius: 8px; padding: 6px 16px; font-size: 13px; font-weight: 600; text-decoration: none; display: flex; align-items: center; gap: 6px;">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</nav>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-warning text-dark py-3">
                    <h5 class="mb-0"><i class="fas fa-edit me-2"></i> Edit Pamflet</h5>
                </div>
                <div class="card-body p-4">

                    @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('pamflet.update', $pamflet->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="form-label fw-bold">Gambar Saat Ini</label><br>
                            <img src="{{ asset('images/' . $pamflet->gambar) }}"
                                 style="max-height:200px; border-radius:8px; border:1px solid #dee2e6;">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Ganti Gambar</label>
                            <input type="file" name="gambar"
                                   class="form-control @error('gambar') is-invalid @enderror"
                                   accept="image/jpeg,image/png,image/jpg"
                                   onchange="previewGambar(this)">
                            <small class="text-muted">Kosongkan jika tidak ingin mengganti. Format: JPEG, PNG, JPG. Maksimal 2MB.</small>
                            @error('gambar')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div id="preview-area" class="mb-4 d-none">
                            <label class="form-label fw-bold text-muted">Preview Gambar Baru</label><br>
                            <img id="preview-img" src="" style="max-height:200px; border-radius:8px; border:1px solid #dee2e6;">
                        </div>

                        <input type="hidden" name="redirect_to" value="{{ old('redirect_to', url()->previous()) }}">
                        <div class="d-flex justify-content-end gap-2 pt-3">
                            <a href="{{ url()->previous() != url()->current() ? url()->previous() : route('pamflet.index') }}" class="btn btn-secondary px-4">Batal</a>
                            <button type="submit" class="btn btn-warning px-5 text-dark fw-bold">
                                <i class="fas fa-save me-1"></i> Update Pamflet
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
function previewGambar(input) {
    var area = document.getElementById('preview-area');
    var img  = document.getElementById('preview-img');
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            img.src = e.target.result;
            area.classList.remove('d-none');
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        area.classList.add('d-none');
    }
}
</script>
</body>
</html>
