<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Artikel Blog</title>
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

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-warning text-dark py-3">
                    <h5 class="mb-0"><i class="fas fa-edit me-2"></i> Edit Artikel Blog & Informasi</h5>
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

                    <form action="{{ route('blog.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="form-label fw-bold">Sub Kategori <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-select shadow-none" required>
                                <option value="">-- Pilih Sub Kategori --</option>
                                @foreach($subKategoris as $sub)
                                <option value="{{ $sub->id }}"
                                    {{ old('category_id', $blog->category_id) == $sub->id ? 'selected' : '' }}>
                                    {{ $sub->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Judul Artikel <span class="text-danger">*</span></label>
                            <input type="text" name="nama_wisata" class="form-control shadow-none"
                                value="{{ old('nama_wisata', $blog->nama_wisata) }}" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Thumbnail</label>
                            @if($blog->gambar1)
                            <div class="mb-2">
                                <img src="{{ asset('images/' . $blog->gambar1) }}"
                                    style="height:100px; border-radius:8px; object-fit:cover;">
                            </div>
                            @endif
                            <input type="file" name="gambar1" class="form-control" accept="image/*">
                            <small class="text-muted">Kosongkan jika tidak ingin mengganti. Format: jpeg, png, jpg. Maksimal 2MB.</small>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Sumber <span class="text-danger">*</span></label>
                            <input type="text" name="alamat_lengkap" class="form-control shadow-none"
                                value="{{ old('alamat_lengkap', $blog->alamat_lengkap) }}" placeholder="Contoh: Kompas.com" required>
                            <small class="text-muted">Nama media/website sumber artikel.</small>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Link Sumber <span class="text-danger">*</span></label>
                            <input type="url" name="link_sumber" class="form-control shadow-none"
                                value="{{ old('link_sumber', $blog->link_sumber) }}" required>
                            <small class="text-muted">URL lengkap ke halaman artikel asli.</small>
                        </div>

                        <div class="d-flex justify-content-end gap-2 pt-3">
                            <a href="{{ route('admin') }}" class="btn btn-secondary px-4">Batal</a>
                            <button type="submit" class="btn btn-warning px-5 fw-bold">
                                <i class="fas fa-save me-1"></i> Update Artikel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
