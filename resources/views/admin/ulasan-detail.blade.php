<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Ulasan - Admin XPloreJogja</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { background: #f4f6f9; font-family: 'Poppins', sans-serif; }
        .admin-header { background: #0e7490; padding: 0.65rem 1.25rem; }
        .logo-text { color: #fff; font-weight: 700; font-size: 1rem; }
        .btn-primary   { background: #0891b2 !important; border-color: #0891b2 !important; color: #fff !important; }
        .btn-primary:hover  { background: #0e7490 !important; border-color: #0e7490 !important; }
        .btn-success   { background: #22c55e !important; border-color: #22c55e !important; color: #fff !important; }
        .btn-danger    { background: #ef4444 !important; border-color: #ef4444 !important; color: #fff !important; }
        .btn-warning   { background: #fbbf24 !important; border-color: #fbbf24 !important; color: #78350f !important; }
        .btn-secondary { background: #fff !important; border: 1px solid #d1d5db !important; color: #4b5563 !important; }
        .card { border-radius: 12px !important; border: 1px solid #e5e7eb !important; }
    </style>
</head>
<body>

<nav style="background: #0e7490; padding: 14px 24px; display: flex; justify-content: space-between; align-items: center;">
    <span style="color: white; font-weight: 700; font-size: 16px; display: flex; align-items: center; gap: 8px;">
        <i class="fas fa-map-marked-alt"></i> XPloreJogja
    </span>
    <div style="display: flex; gap: 8px;">
        <a href="javascript:history.back()" style="background: white; color: #0e7490; border: none; border-radius: 8px; padding: 6px 16px; font-size: 13px; font-weight: 600; text-decoration: none; display: flex; align-items: center; gap: 6px;">
            <i class="fas fa-arrow-left"></i> Kembali
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

<div class="container py-4" style="max-width: 720px;">
    <div class="card shadow-sm">
        <div class="card-header py-3">
            <h6 class="fw-bold mb-0">
                <i class="fas fa-star me-2 text-warning"></i> Detail Ulasan
            </h6>
        </div>
        <div class="card-body">

            {{-- Nama Wisata --}}
            <div class="mb-3 pb-3 border-bottom">
                <div class="text-muted small mb-1">Destinasi</div>
                <div class="fw-bold">{{ $ulasan->wisata->nama_wisata ?? '-' }}</div>
            </div>

            {{-- Nama Pengulas --}}
            <div class="mb-3 pb-3 border-bottom">
                <div class="text-muted small mb-1">Nama Pengulas</div>
                <div class="fw-semibold">{{ $ulasan->nama }}</div>
            </div>

            {{-- Rating --}}
            <div class="mb-3 pb-3 border-bottom">
                <div class="text-muted small mb-1">Rating</div>
                <div class="d-flex gap-1 align-items-center">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $ulasan->rating)
                            <i class="fas fa-star text-warning"></i>
                        @else
                            <i class="fas fa-star text-secondary" style="opacity:0.3;"></i>
                        @endif
                    @endfor
                    <span class="ms-2 fw-bold text-warning">{{ $ulasan->rating }}/5</span>
                </div>
            </div>

            {{-- Teks Ulasan --}}
            <div class="mb-3 pb-3 border-bottom">
                <div class="text-muted small mb-1">Ulasan</div>
                <p class="mb-0" style="white-space: pre-line;">{{ $ulasan->teks }}</p>
            </div>

            {{-- Foto --}}
            @if($ulasan->foto1 || $ulasan->foto2 || $ulasan->foto3)
            <div class="mb-3 pb-3 border-bottom">
                <div class="text-muted small mb-2">Foto</div>
                <div class="d-flex gap-2 flex-wrap">
                    @foreach(['foto1','foto2','foto3'] as $foto)
                        @if($ulasan->$foto)
                        <a href="{{ asset('storage/ulasan/' . $ulasan->$foto1) }}" target="_blank">
                            <img src="{{ asset('storage/ulasan/' . $ulasan->$foto1) }}"
                                 style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px; border: 1px solid #dee2e6;">
                        </a>
                        @endif
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Status --}}
            <div class="mb-3 pb-3 border-bottom">
                <div class="text-muted small mb-1">Status</div>
                @if($ulasan->status === 'approved')
                    <span class="badge bg-success">Approved</span>
                @elseif($ulasan->status === 'rejected')
                    <span class="badge bg-danger">Rejected</span>
                @else
                    <span class="badge bg-warning text-dark">Pending</span>
                @endif
            </div>

            {{-- Tanggal --}}
            <div class="mb-4">
                <div class="text-muted small mb-1">Tanggal</div>
                <div>{{ $ulasan->created_at->format('d M Y, H:i') }}</div>
            </div>

            {{-- Aksi --}}
            <div class="d-flex gap-2 flex-wrap">
                @if($ulasan->status !== 'approved')
                <button type="button" class="btn btn-success btn-approve" data-id="{{ $ulasan->id }}">
                    <i class="fas fa-check me-1"></i> Approve
                </button>
                @endif
                @if($ulasan->status !== 'rejected')
                <button type="button" class="btn btn-warning btn-reject" data-id="{{ $ulasan->id }}">
                    <i class="fas fa-times me-1"></i> Reject
                </button>
                @endif
                <form action="{{ route('ulasan.destroy', $ulasan->id) }}" method="POST"
                      onsubmit="return confirm('Yakin hapus ulasan ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash-alt me-1"></i> Hapus
                    </button>
                </form>
            </div>

            <div id="aksi-notif" class="alert mt-3 d-none"></div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

function showNotif(msg, type) {
    var el = document.getElementById('aksi-notif');
    el.className = 'alert mt-3 alert-' + type;
    el.textContent = msg;
    el.classList.remove('d-none');
}

var btnApprove = document.querySelector('.btn-approve');
if (btnApprove) {
    btnApprove.addEventListener('click', function() {
        var id = this.getAttribute('data-id');
        this.disabled = true;
        fetch('/admin/ulasan/' + id + '/approve', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
            body: JSON.stringify({})
        })
        .then(function(r) { return r.json(); })
        .then(function(data) {
            if (data.success) {
                showNotif('Ulasan berhasil di-approve.', 'success');
                setTimeout(function() { location.reload(); }, 1000);
            }
        });
    });
}

var btnReject = document.querySelector('.btn-reject');
if (btnReject) {
    btnReject.addEventListener('click', function() {
        var id = this.getAttribute('data-id');
        this.disabled = true;
        fetch('/admin/ulasan/' + id + '/reject', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
            body: JSON.stringify({})
        })
        .then(function(r) { return r.json(); })
        .then(function(data) {
            if (data.success) {
                showNotif('Ulasan berhasil di-reject.', 'warning');
                setTimeout(function() { location.reload(); }, 1000);
            }
        });
    });
}
</script>
</body>
</html>
