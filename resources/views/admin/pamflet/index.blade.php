<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pamflet</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f4f6f9; }
        .pamflet-item { cursor: grab; }
        .pamflet-item:active { cursor: grabbing; }
        .sortable-ghost { opacity: 0.4; background: #ecfeff; }
        .btn-primary  { background: #0891b2 !important; border-color: #0891b2 !important; color: #fff !important; }
        .btn-primary:hover  { background: #0e7490 !important; border-color: #0e7490 !important; }
        .btn-warning  { background: #fbbf24 !important; border-color: #fbbf24 !important; color: #78350f !important; }
        .btn-warning:hover  { background: #f59e0b !important; color: #78350f !important; }
        .btn-danger   { background: #ef4444 !important; border-color: #ef4444 !important; color: #fff !important; }
        .btn-danger:hover   { background: #dc2626 !important; }
        .btn-secondary { background: #fff !important; border: 1px solid #d1d5db !important; color: #4b5563 !important; }
        .btn-secondary:hover { background: #f9fafb !important; color: #374151 !important; }
        .card { border-radius: 12px !important; border: 1px solid #e5e7eb !important; }
        .card-header { border-radius: 12px 12px 0 0 !important; background: #fff; border-bottom: 1px solid #e5e7eb; }
        .badge.bg-primary   { background: #0891b2 !important; }
        .badge.bg-secondary { background: #6b7280 !important; }
        .alert-success { background: #f0fdf4 !important; border-color: #bbf7d0 !important; color: #166534 !important; }
        .alert-danger  { background: #fef2f2 !important; border-color: #fecaca !important; color: #991b1b !important; }
        .alert-warning { background: #fffbeb !important; border-color: #fde68a !important; color: #92400e !important; }
        .pamflet-urutan { background: #0891b2 !important; border-radius: 6px; }
    </style>
</head>
<body class="bg-light">

<nav style="background: #0e7490; padding: 14px 24px; display: flex; justify-content: space-between; align-items: center;">
    <span style="color: white; font-weight: 700; font-size: 16px; display: flex; align-items: center; gap: 8px;">
        <i class="fas fa-map-marked-alt"></i> XPloreJogja
    </span>
    <div style="display: flex; gap: 8px;">
        @if($pamflets->count() < 7)
            <a href="{{ route('pamflet.create') }}" style="background: white; color: #0e7490; border: none; border-radius: 8px; padding: 6px 16px; font-size: 13px; font-weight: 600; text-decoration: none; display: flex; align-items: center; gap: 6px;">
                <i class="fas fa-plus"></i> Tambah Pamflet
            </a>
        @else
            <span style="background: white; color: #0e7490; border: none; border-radius: 8px; padding: 6px 16px; font-size: 13px; font-weight: 600; display: flex; align-items: center; gap: 6px; cursor: not-allowed; opacity: 0.4;" title="Maksimal 7 pamflet">
                <i class="fas fa-plus"></i> Tambah Pamflet
            </span>
        @endif
        <a href="{{ route('admin') }}?tab=pamflet" style="background: white; color: #0e7490; border: none; border-radius: 8px; padding: 6px 16px; font-size: 13px; font-weight: 600; text-decoration: none; display: flex; align-items: center; gap: 6px;">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>
</nav>

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0"><i class="fas fa-images me-2 text-primary"></i> Kelola Pamflet</h4>
        <div class="d-flex gap-2">
            @if($pamflets->count() < 7)
                <a href="{{ route('pamflet.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> Tambah Pamflet
                </a>
            @else
                <button class="btn btn-primary" disabled title="Maksimal 7 pamflet">
                    <i class="fas fa-plus me-1"></i> Tambah Pamflet
                </button>
            @endif
            <a href="{{ route('admin') }}?tab=pamflet" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if($pamflets->count() >= 7)
    <div class="alert alert-warning">
        <i class="fas fa-exclamation-triangle me-2"></i>
        Sudah mencapai batas maksimal <strong>7 pamflet</strong>. Hapus salah satu untuk menambah baru.
    </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold">
                    <i class="fas fa-images me-2 text-primary"></i>
                    Daftar Pamflet
                    @if($pamflets->count() > 0)
                    <span class="badge bg-primary ms-2">{{ $pamflets->count() }}/7 aktif</span>
                    @else
                    <span class="badge bg-secondary ms-2">0/7 aktif</span>
                    @endif
                </h6>
                <small class="text-muted"><i class="fas fa-grip-vertical me-1"></i> Drag &amp; drop untuk mengatur urutan</small>
            </div>
        </div>
        <div class="card-body">
            @if($pamflets->isEmpty())
                <div class="text-center py-5 text-muted">
                    <i class="fas fa-images fa-3x mb-3 d-block text-secondary"></i>
                    Belum ada pamflet. Silakan tambah pamflet baru.
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
                                <span class="position-absolute top-0 start-0 badge bg-dark m-2 pamflet-urutan">
                                    {{ $loop->iteration }}
                                </span>
                            </div>
                            <div class="card-footer d-flex align-items-center gap-2 p-2 bg-white">
                                <i class="fas fa-grip-vertical text-muted" style="cursor:grab;"></i>
                                <a href="{{ route('pamflet.edit', $pamflet->id) }}"
                                   class="btn btn-sm btn-warning flex-grow-1">
                                    <i class="fas fa-edit me-1"></i> Edit
                                </a>
                                <form action="{{ route('pamflet.destroy', $pamflet->id) }}" method="POST"
                                      onsubmit="return confirm('Yakin hapus pamflet ini?')">
                                    @csrf
                                    @method('DELETE')
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
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
var gridEl = document.getElementById('pamflet-grid');
if (gridEl) {
    Sortable.create(gridEl, {
        animation: 150,
        ghostClass: 'sortable-ghost',
        handle: '.fa-grip-vertical',
        onEnd: function() {
            var items = gridEl.querySelectorAll('.pamflet-item');
            var order = [];
            items.forEach(function(item) {
                order.push(item.getAttribute('data-id'));
            });

            fetch('{{ route("pamflet.order") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ order: order })
            }).then(function(res) {
                return res.json();
            }).then(function(data) {
                if (data.success) {
                    items.forEach(function(item, idx) {
                        var badge = item.querySelector('.pamflet-urutan');
                        if (badge) badge.textContent = idx + 1;
                    });
                }
            });
        }
    });
}
</script>
</body>
</html>
