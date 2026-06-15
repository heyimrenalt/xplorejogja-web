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

        $ulasanPerWisata = [];
        foreach ($subKategoris as $sub) {
            $wisatas = \App\Models\Wisata::where('category_id', $sub->id)->get();
            foreach ($wisatas as $wisata) {
                $ulasanPerWisata[$wisata->id] = \App\Models\Ulasan::where('wisata_id', $wisata->id)
                    ->orderBy('urutan')
                    ->orderBy('created_at', 'desc')
                    ->get();
            }
        }

        return view('admin.ulasan-kategori', compact('subKategoris', 'parentCategory', 'ulasanPerWisata'));
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

    if (!is_dir(public_path('images/ulasan'))) {
        mkdir(public_path('images/ulasan'), 0755, true);
    }

    foreach (['foto1', 'foto2', 'foto3'] as $foto) {
        if ($request->hasFile($foto)) {
            $file     = $request->file($foto);
            $namaFile = time() . '_ulasan_' . $foto . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/ulasan'), $namaFile);
            $data[$foto] = $namaFile;
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
                $path = public_path('images/ulasan/' . $ulasan->$foto);
                if (file_exists($path) && is_file($path)) {
                    unlink($path);
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

    public function loadMore($slug)
    {
        $wisata = Wisata::where('slug', $slug)->firstOrFail();
        $ulasans = Ulasan::where('wisata_id', $wisata->id)
            ->where('status', 'approved')
            ->orderBy('urutan')
            ->orderBy('created_at', 'desc')
            ->get();

        $html = view('partials.ulasan-list', compact('ulasans'))->render();
        return response()->json(['html' => $html]);
    }
}
