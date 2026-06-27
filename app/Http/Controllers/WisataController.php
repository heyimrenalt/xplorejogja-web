<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Wisata;
use App\Models\Pamflet;
use App\Models\Ulasan;

class WisataController extends Controller
{
    public function index()
    {
        $countWisataAlam   = Wisata::whereHas('category', function($q) { $q->where('parent_id', 1); })->count();
        $countHiburanKel   = Wisata::whereHas('category', function($q) { $q->where('parent_id', 8); })->count();
        $countPenginapan   = Wisata::whereHas('category', function($q) { $q->where('parent_id', 15); })->count();
        $countTransportasi = Wisata::whereHas('category', function($q) { $q->where('parent_id', 19); })->count();
        $countKuliner      = Wisata::whereHas('category', function($q) { $q->where('parent_id', 23); })->count();
        $blogs             = Wisata::whereHas('category', function($q) { $q->where('parent_id', 27); })->get();
        $pamflets          = Pamflet::orderBy('urutan')->get();
        $wisataPopuler     = Wisata::with('category')->where('is_populer', true)->orderBy('urutan_populer')->get();

        $parentIds = [1, 8, 15, 19, 23];
        $pendingUlasan = DB::table('ulasans')
            ->join('wisatas', 'ulasans.wisata_id', '=', 'wisatas.id')
            ->join('categories', 'wisatas.category_id', '=', 'categories.id')
            ->where('ulasans.status', 'pending')
            ->whereIn('categories.parent_id', $parentIds)
            ->groupBy('categories.parent_id')
            ->selectRaw('categories.parent_id, COUNT(*) as total')
            ->pluck('total', 'parent_id')
            ->toArray();

        foreach ($parentIds as $pid) {
            if (!isset($pendingUlasan[$pid])) $pendingUlasan[$pid] = 0;
        }
        $totalPendingUlasan = array_sum($pendingUlasan);

        return view('admin.dashboard', compact(
            'countWisataAlam', 'countHiburanKel', 'countPenginapan', 'countTransportasi', 'countKuliner',
            'blogs', 'pamflets', 'wisataPopuler',
            'pendingUlasan', 'totalPendingUlasan'
        ));
    }

    public function toggleTampilHome(Request $request, $id)
    {
        $wisata = Wisata::findOrFail($id);

        $cat      = $wisata->category;
        $parentId = $cat ? $cat->parent_id : null;
        $catIds   = \App\Models\Category::where('parent_id', $parentId)->pluck('id');

        if (!$wisata->tampil_home) {
            $activeCount = Wisata::whereIn('category_id', $catIds)
                ->where('tampil_home', true)
                ->count();

            if ($activeCount >= 4) {
                return response()->json([
                    'success' => false,
                    'message' => 'Maksimal 4 wisata per kategori yang bisa ditampilkan di home.',
                    'count'   => $activeCount,
                ]);
            }

            $wisata->tampil_home = true;
            $wisata->save();

            $newCount = $activeCount + 1;
        } else {
            $wisata->tampil_home = false;
            $wisata->save();

            $newCount = Wisata::whereIn('category_id', $catIds)
                ->where('tampil_home', true)
                ->count();
        }

        return response()->json([
            'success' => true,
            'message' => $wisata->tampil_home ? 'Wisata ditambahkan ke halaman home.' : 'Wisata dihapus dari halaman home.',
            'count'   => $newCount,
            'active'  => $wisata->tampil_home,
        ]);
    }

    public function create()
    {
        $populerCount = Wisata::where('is_populer', true)->count();
        $subKategoriMap = \App\Models\Category::whereNotNull('parent_id')
            ->with('parent:id,name')
            ->orderBy('id')
            ->get()
            ->groupBy(fn($sub) => $sub->parent->name ?? 'Lainnya')
            ->map(fn($subs) => $subs->map(fn($s) => ['id' => $s->id, 'name' => $s->name])->values());
        return view('admin.create', compact('populerCount', 'subKategoriMap'));
    }

    public function store(Request $request)
    {
        $catId    = $request->input('category_id');
        $cat      = $catId ? \App\Models\Category::find($catId) : null;
        $parentId = $cat->parent_id ?? null;
        $isJasa   = $cat && in_array($parentId, [15, 19]);
        $isKuliner = $parentId == 23;

        if ($parentId == 15) {
            $labelNama = 'Nama penginapan';
        } elseif ($parentId == 19) {
            $labelNama = 'Nama layanan';
        } elseif ($parentId == 23) {
            $labelNama = 'Nama tempat kuliner';
        } elseif ($parentId == 27) {
            $labelNama = 'Judul artikel';
        } else {
            $labelNama = 'Nama wisata';
        }

        $rules = [
            'category_id'         => 'required',
            'nama_wisata'         => 'required',
            'gambar1'             => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'gambar2'             => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'gambar3'             => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'harga_tiket'         => 'required',
            'fasilitas'           => 'required',
            'alamat_lengkap'      => 'required',
            'link_gmaps'          => 'required|url',
            'link_navigasi'       => 'nullable|url',
            'biaya_penginapan'    => 'nullable',
            'rincian_penginapan'  => 'nullable',
            'info_tiket_tambahan' => 'nullable',
        ];

        if (!$isJasa) {
            $rules['jam_buka']  = 'required';
            $rules['jam_tutup'] = 'required';
        }

        if (!$isJasa && !$isKuliner) {
            $rules['deskripsi']    = 'required';
            $rules['biaya_parkir'] = 'required';
        }

        $request->validate($rules, [
            'category_id.required'    => 'Kategori wajib dipilih.',
            'nama_wisata.required'    => $labelNama . ' wajib diisi.',
            'gambar1.required'        => 'Gambar utama wajib diunggah.',
            'gambar1.image'           => 'File harus berupa gambar.',
            'gambar1.mimes'           => 'Format gambar harus jpeg, png, atau jpg.',
            'gambar1.max'             => 'Ukuran gambar maksimal 2MB.',
            'gambar2.mimes'           => 'Format gambar 2 harus jpeg, png, atau jpg.',
            'gambar3.mimes'           => 'Format gambar 3 harus jpeg, png, atau jpg.',
            'deskripsi.required'      => 'Deskripsi wajib diisi.',
            'jam_buka.required'       => 'Jam buka wajib diisi.',
            'jam_tutup.required'      => 'Jam tutup wajib diisi.',
            'harga_tiket.required'    => 'Harga wajib diisi.',
            'fasilitas.required'      => 'Fasilitas wajib diisi.',
            'alamat_lengkap.required' => 'Alamat lengkap wajib diisi.',
            'link_gmaps.required'     => 'Link Google Maps wajib diisi.',
            'link_gmaps.url'          => 'Format link Google Maps tidak valid.',
            'biaya_parkir.required'   => 'Rincian biaya parkir wajib diisi.',
        ]);

        // Cek batas destinasi populer
        $isPopuler = $request->has('is_populer');
        if ($isPopuler) {
            $totalPopuler = Wisata::where('is_populer', true)->count();
            if ($totalPopuler >= 7) {
                return redirect()->back()->withInput()->withErrors([
                    'is_populer' => 'Maksimal 7 destinasi populer telah tercapai. Hapus dulu salah satu untuk menambah baru.',
                ]);
            }
        }

        $data = $request->except(['gambar1', 'gambar2', 'gambar3', 'ulasan_raw']);

        if ($isJasa || $isKuliner) {
            $data['deskripsi']    = '';
            $data['biaya_parkir'] = '';
        }

        // Set is_populer dan urutan_populer
        $data['is_populer'] = $isPopuler ? 1 : 0;
        if ($isPopuler) {
            $maxUrutan             = Wisata::where('is_populer', true)->max('urutan_populer');
            $data['urutan_populer'] = ($maxUrutan !== null ? (int)$maxUrutan : 0) + 1;
        } else {
            $data['urutan_populer'] = null;
        }

        foreach (['gambar1', 'gambar2', 'gambar3'] as $img) {
            if ($request->hasFile($img)) {
                $file     = $request->file($img);
                $namaFile = time() . '_' . $img . '_' . $file->getClientOriginalName();
                try {
                    $file->move(public_path('images'), $namaFile);
                    $data[$img] = $namaFile;
                } catch (\Throwable $e) {}
            }
        }

        $wisata = Wisata::create($data);

        if ($request->filled('ulasan_raw')) {
            $items = explode("\n", trim($request->ulasan_raw));
            foreach ($items as $item) {
                $parts = explode('|', $item);
                if (count($parts) < 3) {
                    continue;
                }
                $nama   = trim($parts[0]);
                $rating = (int) trim($parts[1]);
                $teks   = trim($parts[2]);
                if (!$nama || !$teks) {
                    continue;
                }
                \App\Models\Ulasan::create([
                    'wisata_id' => $wisata->id,
                    'nama'      => $nama,
                    'rating'    => $rating,
                    'teks'      => $teks,
                    'status'    => 'approved',
                    'urutan'    => \App\Models\Ulasan::where('wisata_id', $wisata->id)->max('urutan') + 1,
                ]);
            }
        }

        return $this->redirectAfterSave($wisata, 'Destinasi Wisata XPloreJogja Berhasil Ditambahkan!', $request->input('redirect_to'));
    }

    public function show($id)
    {
        $wisata = Wisata::findOrFail($id);
        return redirect()->route('wisata.detail', $wisata->slug);
    }

    public function edit($id)
    {
        $wisata       = Wisata::findOrFail($id);
        $categories   = \App\Models\Category::whereNull('parent_id')
            ->whereNotIn('id', [12, 27])
            ->with('children')
            ->get();
        $populerCount = Wisata::where('is_populer', true)->where('id', '!=', $id)->count();
        $ulasans      = Ulasan::where('wisata_id', $id)->orderBy('urutan')->get();
        return view('admin.edit', compact('wisata', 'categories', 'populerCount', 'ulasans'));
    }

    public function update(Request $request, $id)
    {
        $wisata = Wisata::findOrFail($id);

        $catId    = $request->input('category_id');
        $cat      = $catId ? \App\Models\Category::find($catId) : null;
        $parentId = $cat->parent_id ?? null;
        $isJasa   = $cat && in_array($parentId, [15, 19]);
        $isKuliner = $parentId == 23;

        if ($parentId == 15) {
            $labelNama = 'Nama penginapan';
        } elseif ($parentId == 19) {
            $labelNama = 'Nama layanan';
        } elseif ($parentId == 23) {
            $labelNama = 'Nama tempat kuliner';
        } elseif ($parentId == 27) {
            $labelNama = 'Judul artikel';
        } else {
            $labelNama = 'Nama wisata';
        }

        $rules = [
            'category_id'         => 'required',
            'nama_wisata'         => 'required',
            'gambar1'             => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'gambar2'             => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'gambar3'             => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'harga_tiket'         => 'required',
            'fasilitas'           => 'required',
            'alamat_lengkap'      => 'required',
            'link_gmaps'          => 'required|url',
            'link_navigasi'       => 'nullable|url',
            'biaya_penginapan'    => 'nullable',
            'rincian_penginapan'  => 'nullable',
            'info_tiket_tambahan' => 'nullable',
        ];

        if (!$isJasa) {
            $rules['jam_buka']  = 'required';
            $rules['jam_tutup'] = 'required';
        }

        if (!$isJasa && !$isKuliner) {
            $rules['deskripsi']    = 'required';
            $rules['biaya_parkir'] = 'required';
        }

        $request->validate($rules, [
            'category_id.required'    => 'Kategori wajib dipilih.',
            'nama_wisata.required'    => $labelNama . ' wajib diisi.',
            'gambar1.image'           => 'File harus berupa gambar.',
            'gambar1.mimes'           => 'Format gambar harus jpeg, png, atau jpg.',
            'gambar2.mimes'           => 'Format gambar harus jpeg, png, atau jpg.',
            'gambar3.mimes'           => 'Format gambar harus jpeg, png, atau jpg.',
            'deskripsi.required'      => 'Deskripsi wajib diisi.',
            'jam_buka.required'       => 'Jam buka wajib diisi.',
            'jam_tutup.required'      => 'Jam tutup wajib diisi.',
            'harga_tiket.required'    => 'Harga wajib diisi.',
            'fasilitas.required'      => 'Fasilitas wajib diisi.',
            'alamat_lengkap.required' => 'Alamat lengkap wajib diisi.',
            'link_gmaps.required'     => 'Link Google Maps wajib diisi.',
            'link_gmaps.url'          => 'Format link Google Maps tidak valid.',
            'biaya_parkir.required'   => 'Rincian biaya parkir wajib diisi.',
        ]);

        // Cek batas destinasi populer (hanya jika baru dijadikan populer)
        $isPopuler = $request->has('is_populer');
        if ($isPopuler && !$wisata->is_populer) {
            $totalPopuler = Wisata::where('is_populer', true)->count();
            if ($totalPopuler >= 7) {
                return redirect()->back()->withInput()->withErrors([
                    'is_populer' => 'Maksimal 7 destinasi populer telah tercapai. Hapus dulu salah satu untuk menambah baru.',
                ]);
            }
        }

        $data = $request->except(['gambar1', 'gambar2', 'gambar3', '_token', '_method', 'ulasan_raw']);

        if ($isJasa || $isKuliner) {
            $data['deskripsi']    = '';
            $data['biaya_parkir'] = '';
        }

        // Set is_populer dan urutan_populer
        $data['is_populer'] = $isPopuler ? 1 : 0;
        if (!$isPopuler) {
            $data['urutan_populer'] = null;
        } elseif (!$wisata->is_populer) {
            // Baru dijadikan populer, tentukan urutan berikutnya
            $maxUrutan             = Wisata::where('is_populer', true)->max('urutan_populer');
            $data['urutan_populer'] = ($maxUrutan !== null ? (int)$maxUrutan : 0) + 1;
        }
        // Jika sudah populer sebelumnya, biarkan urutan_populer tidak berubah

        foreach (['gambar1', 'gambar2', 'gambar3'] as $img) {
            if ($request->hasFile($img)) {
                if ($wisata->$img) {
                    $oldFile = public_path('images/' . $wisata->$img);
                    if (file_exists($oldFile) && is_file($oldFile)) {
                        try { @unlink($oldFile); } catch (\Throwable $e) {}
                    }
                }

                $file     = $request->file($img);
                $namaFile = time() . '_' . $img . '_' . $file->getClientOriginalName();
                try {
                    $file->move(public_path('images'), $namaFile);
                    $data[$img] = $namaFile;
                } catch (\Throwable $e) {}
            }
        }

        $wisata->update($data);

        if ($request->filled('ulasan_raw')) {
            $items = explode("\n", trim($request->ulasan_raw));
            foreach ($items as $item) {
                $parts = explode('|', $item);
                if (count($parts) < 3) {
                    continue;
                }
                $nama   = trim($parts[0]);
                $rating = (int) trim($parts[1]);
                $teks   = trim($parts[2]);
                if (!$nama || !$teks) {
                    continue;
                }
                $exists = \App\Models\Ulasan::where('wisata_id', $wisata->id)
                    ->where('nama', $nama)
                    ->where('teks', $teks)
                    ->exists();
                if (!$exists) {
                    \App\Models\Ulasan::create([
                        'wisata_id' => $wisata->id,
                        'nama'      => $nama,
                        'rating'    => $rating,
                        'teks'      => $teks,
                        'status'    => 'approved',
                        'urutan'    => \App\Models\Ulasan::where('wisata_id', $wisata->id)->max('urutan') + 1,
                    ]);
                }
            }
        }

        return $this->redirectAfterSave($wisata->fresh(), 'Data wisata berhasil diupdate!', $request->input('redirect_to'));
    }

    public function destroy($id)
    {
        $wisata = Wisata::findOrFail($id);

        foreach (['gambar1', 'gambar2', 'gambar3'] as $img) {
            if ($wisata->$img) {
                $path = public_path('images/' . $wisata->$img);
                if (file_exists($path)) {
                    try { @unlink($path); } catch (\Throwable $e) {}
                }
            }
        }

        $wisata->delete();

        $redirectTo = request()->input('redirect_to');
        if ($redirectTo && strpos($redirectTo, url('/')) === 0) {
            return redirect($redirectTo)->with('success', 'Data wisata berhasil dihapus!');
        }
        return redirect()->route('admin')->with('success', 'Data wisata berhasil dihapus!');
    }

    public function updateSubkategoriOrder(Request $request)
    {
        $order = $request->input('order', []);
        if (empty($order)) return response()->json(['success' => true]);

        $cases = '';
        $ids = [];
        foreach ($order as $idx => $id) {
            $idInt = (int) $id;
            $ids[] = $idInt;
            $cases .= " WHEN {$idInt} THEN " . ($idx + 1);
        }
        $idList = implode(',', $ids);
        DB::statement("UPDATE wisatas SET urutan_subkategori = CASE id{$cases} END WHERE id IN ({$idList})");

        return response()->json(['success' => true]);
    }

    public function updatePopulerOrder(Request $request)
    {
        $order = $request->input('order', []);
        if (empty($order)) return response()->json(['success' => true]);

        $cases = '';
        $ids = [];
        foreach ($order as $idx => $id) {
            $idInt = (int) $id;
            $ids[] = $idInt;
            $cases .= " WHEN {$idInt} THEN " . ($idx + 1);
        }
        $idList = implode(',', $ids);
        DB::statement("UPDATE wisatas SET urutan_populer = CASE id{$cases} END WHERE id IN ({$idList})");

        return response()->json(['success' => true]);
    }

    public function removePopuler($id)
    {
        $wisata = Wisata::findOrFail($id);
        $wisata->is_populer     = false;
        $wisata->urutan_populer = null;
        $wisata->save();

        $remainingIds = Wisata::where('is_populer', true)->orderBy('urutan_populer')->pluck('id');
        if ($remainingIds->isNotEmpty()) {
            $cases = '';
            $ids = [];
            foreach ($remainingIds as $idx => $id) {
                $idInt = (int) $id;
                $ids[] = $idInt;
                $cases .= " WHEN {$idInt} THEN " . ($idx + 1);
            }
            $idList = implode(',', $ids);
            DB::statement("UPDATE wisatas SET urutan_populer = CASE id{$cases} END WHERE id IN ({$idList})");
        }

        return response()->json(['success' => true]);
    }

    public function indexByKategori($parentId)
    {
        $parentCategory = \App\Models\Category::findOrFail($parentId);
        $subKategoris   = \App\Models\Category::where('parent_id', $parentId)
                            ->with(['wisatas' => function ($q) {
                                $q->orderByDesc('is_populer')
                                  ->orderBy('urutan_populer')
                                  ->orderBy('nama_wisata');
                            }])
                            ->get();

        return view('admin.wisata-kategori', compact('subKategoris', 'parentCategory'));
    }

    public function togglePopuler($id)
    {
        $wisata = Wisata::findOrFail($id);

        if (!$wisata->is_populer) {
            $totalPopuler = Wisata::where('is_populer', true)->count();
            if ($totalPopuler >= 7) {
                return response()->json([
                    'success' => false,
                    'message' => 'Maksimal 7 destinasi populer telah tercapai.',
                ]);
            }
            $maxUrutan             = Wisata::where('is_populer', true)->max('urutan_populer');
            $wisata->is_populer    = true;
            $wisata->urutan_populer = ($maxUrutan !== null ? (int)$maxUrutan : 0) + 1;
            $wisata->save();
        } else {
            $wisata->is_populer     = false;
            $wisata->urutan_populer = null;
            $wisata->save();

            $remainingIds = Wisata::where('is_populer', true)->orderBy('urutan_populer')->pluck('id');
            if ($remainingIds->isNotEmpty()) {
                $cases = '';
                $ids = [];
                foreach ($remainingIds as $idx => $id) {
                    $idInt = (int) $id;
                    $ids[] = $idInt;
                    $cases .= " WHEN {$idInt} THEN " . ($idx + 1);
                }
                $idList = implode(',', $ids);
                DB::statement("UPDATE wisatas SET urutan_populer = CASE id{$cases} END WHERE id IN ({$idList})");
            }
        }

        return response()->json([
            'success'    => true,
            'is_populer' => $wisata->is_populer,
        ]);
    }

    private function redirectAfterSave($wisata, $message, $redirectTo = null)
    {
        if ($redirectTo && strpos($redirectTo, url('/')) === 0) {
            return redirect($redirectTo)->with('success', $message);
        }

        $wisataParentIds = [1, 8, 15, 19, 23];

        $cat      = $wisata->category;
        $parentId = $cat ? $cat->parent_id : null;

        if ($parentId !== null && in_array($parentId, $wisataParentIds)) {
            return redirect()->route('wisata.kategori', $parentId)->with('success', $message);
        }

        return redirect()->route('admin')->with('success', $message);
    }
}
