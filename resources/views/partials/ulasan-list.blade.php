@forelse($ulasans as $ulasan)
<div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
    <div class="flex items-center gap-3 mb-3">
        <div class="w-10 h-10 rounded-full bg-cyan-100 flex items-center justify-center font-bold text-cyan-700 text-sm">
            {{ strtoupper(substr($ulasan->nama, 0, 2)) }}
        </div>
        <div>
            <div class="text-sm font-bold text-gray-800">{{ $ulasan->nama }}</div>
            <div class="flex gap-1 items-center">
                @for($i = 1; $i <= 5; $i++)
                    @if($i <= $ulasan->rating)
                        <i class="fas fa-star text-yellow-400 text-xs"></i>
                    @else
                        <i class="fas fa-star text-gray-300 text-xs"></i>
                    @endif
                @endfor
                <span class="text-xs text-gray-400 ml-1">{{ $ulasan->created_at->diffForHumans() }}</span>
            </div>
        </div>
    </div>
    <p class="text-sm text-gray-600 leading-relaxed mb-3">{{ $ulasan->teks }}</p>
    @if($ulasan->foto1 || $ulasan->foto2 || $ulasan->foto3)
    <div class="flex gap-2">
        @foreach(['foto1','foto2','foto3'] as $foto)
    @if($ulasan->$foto)
    <img src="{{ asset('images/ulasan/' . $ulasan->$foto) }}"
         class="w-20 h-20 object-cover rounded-xl border border-gray-100 cursor-pointer"
         onclick="window.open(this.src)">
    @endif
@endforeach
    </div>
    @endif
</div>
@empty
<div class="text-center py-8 text-gray-400">
    <i class="fas fa-comment-slash fa-2x mb-2"></i>
    <p class="text-sm">Belum ada ulasan untuk destinasi ini.</p>
</div>
@endforelse
