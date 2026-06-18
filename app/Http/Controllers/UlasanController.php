<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ulasan;
use App\Models\Wisata;

class UlasanController extends Controller
{
    public function index()
    {
        return redirect()->route('admin');
    }

    public function indexByKategori($parentId)
    {
        $parentCategory = \App\Models\Category::findOrFail($parentId);
        $subKategoris = \App\Models\Category::where('parent_id', $parentId)->get();

        $catIds = $subKategoris->pluck('id');
        $wisataDenganUlasan = \App\Models\Wisata::whereIn('category_id', $catIds)
            ->with(['ulasans' => function($q) {
                $q->orderBy('urutan')->orderBy('created_at', 'desc');
            }])
            ->orderByDesc('is_populer')
            ->orderBy('urutan_populer')
            ->orderBy('nama_wisata')
            ->get();

        $ulasanPerWisata = $wisataDenganUlasan->keyBy('id')->map(function($w) { return $w->ulasans; });
        $wisataPerSub = $wisataDenganUlasan->groupBy('category_id');

        return view('admin.ulasan-kategori', compact('subKategoris', 'parentCategory', 'ulasanPerWisata', 'wisataPerSub'));
    }

    public function store(Request $request, $wisataSlug)
{
    $wisata = \App\Models\Wisata::where('slug', $wisataSlug)->firstOrFail();

    $request->validate([
        'nama'   => 'required|string|max:100',
        'rating' => 'required|integer|min:1|max:5',
        'teks'   => 'required|string',
        'foto1'  => 'nullable|image|mimes:jpeg,png,jpg|max:10240',
        'foto2'  => 'nullable|image|mimes:jpeg,png,jpg|max:10240',
        'foto3'  => 'nullable|image|mimes:jpeg,png,jpg|max:10240',
    ], [
        'nama.required'   => 'Nama wajib diisi.',
        'rating.required' => 'Rating wajib dipilih.',
        'teks.required'   => 'Ulasan wajib diisi.',
        'foto1.image'     => 'File harus berupa gambar.',
        'foto1.mimes'     => 'Format gambar harus jpeg, png, atau jpg.',
        'foto1.max'       => 'Ukuran foto maksimal 10MB.',
        'foto2.image'     => 'File harus berupa gambar.',
        'foto2.mimes'     => 'Format gambar harus jpeg, png, atau jpg.',
        'foto2.max'       => 'Ukuran foto maksimal 10MB.',
        'foto3.image'     => 'File harus berupa gambar.',
        'foto3.mimes'     => 'Format gambar harus jpeg, png, atau jpg.',
        'foto3.max'       => 'Ukuran foto maksimal 10MB.',
    ]);

    $status = auth()->check() ? 'approved' : 'pending';

    $data = [
        'wisata_id' => $wisata->id,
        'nama'      => $request->nama,
        'rating'    => $request->rating,
        'teks'      => $request->teks,
        'status'    => $status,
        'urutan'    => \App\Models\Ulasan::where('wisata_id', $wisata->id)->max('urutan') + 1,
    ];

    try {
        if (!is_dir(storage_path('app/public/ulasan'))) {
            @mkdir(storage_path('app/public/ulasan'), 0775, true);
        }
    } catch (\Throwable $e) {}

foreach (['foto1', 'foto2', 'foto3'] as $foto) {
    if ($request->hasFile($foto)) {
        $file     = $request->file($foto);
        $namaFile = time() . '_ulasan_' . $foto . '_' . $file->getClientOriginalName();
        try {
            $file->move(storage_path('app/public/ulasan'), $namaFile);
            $data[$foto] = $namaFile;
        } catch (\Exception $e) {
            // foto gagal diupload, ulasan tetap tersimpan tanpa foto ini
        }
    }
}

    \App\Models\Ulasan::create($data);

    if ($status === 'approved') {
        return redirect()->back()->with('ulasan_success', 'Ulasan berhasil ditambahkan dan langsung ditampilkan.');
    }

    return redirect()->back()->with('ulasan_success', 'Ulasan kamu sedang menunggu persetujuan admin. Terima kasih!');
}

    public function setPending($id)
    {
        $ulasan = Ulasan::findOrFail($id);
        $ulasan->status = 'pending';
        $ulasan->save();
        return response()->json(['success' => true]);
    }

    public function approve($id)
    {
        $ulasan = Ulasan::findOrFail($id);
        $ulasan->status = 'approved';
        $ulasan->save();

        return response()->json(['success' => true]);
    }

    public function reject($id)
    {
        $ulasan = Ulasan::findOrFail($id);
        $ulasan->status = 'rejected';
        $ulasan->save();

        return response()->json(['success' => true]);
    }

    public function updateOrder(Request $request)
    {
        $order = $request->input('order', []);
        foreach ($order as $index => $id) {
            Ulasan::where('id', $id)->update(['urutan' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $ulasan = Ulasan::findOrFail($id);

        foreach (['foto1', 'foto2', 'foto3'] as $foto) {
            if ($ulasan->$foto) {
                $path = storage_path('app/public/ulasan/' . $ulasan->$foto);
                if (file_exists($path) && is_file($path)) {
                    try { @unlink($path); } catch (\Throwable $e) {}
                }
            }
        }

        $ulasan->delete();

        return redirect()->back()->with('success', 'Ulasan berhasil dihapus.');
    }

    public function show($id)
    {
        $ulasan = Ulasan::with('wisata')->findOrFail($id);
        return view('admin.ulasan-detail', compact('ulasan'));
    }

    public function loadMore($slug, \Illuminate\Http\Request $request)
    {
        $wisata  = Wisata::where('slug', $slug)->firstOrFail();
        $offset  = (int) $request->input('offset', 5);
        $limit   = 10;

        // Safety cap untuk prevent abuse
        if ($offset < 0) $offset = 0;
        if ($offset > 1000) $offset = 1000;

        $ulasans = Ulasan::where('wisata_id', $wisata->id)
            ->where('status', 'approved')
            ->orderBy('urutan')
            ->orderBy('created_at', 'desc')
            ->offset($offset)
            ->limit($limit)
            ->get();

        $total = Ulasan::where('wisata_id', $wisata->id)
            ->where('status', 'approved')
            ->count();

        $html = view('partials.ulasan-list', compact('ulasans'))->render();

        return response()->json([
            'html'    => $html,
            'hasMore' => ($offset + $limit) < $total,
            'total'   => $total,
        ]);
    }
}
