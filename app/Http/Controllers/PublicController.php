<?php

namespace App\Http\Controllers;

use App\Models\Wisata;
use App\Models\Ulasan;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function home()
    {
        $pamflets      = \App\Models\Pamflet::orderBy('urutan')->get();
        $wisataPopuler = \App\Models\Wisata::where('is_populer', true)->orderBy('urutan_populer')->limit(7)->get();

        $alamIds      = \App\Models\Category::where('parent_id', 1)->pluck('id');
        $wisataAlam   = \App\Models\Wisata::whereIn('category_id', $alamIds)->where('tampil_home', true)->limit(4)->get();

        $hiburanIds   = \App\Models\Category::where('parent_id', 8)->pluck('id');
        $hiburanKel   = \App\Models\Wisata::whereIn('category_id', $hiburanIds)->where('tampil_home', true)->limit(4)->get();

        $penginapanIds = \App\Models\Category::where('parent_id', 15)->pluck('id');
        $penginapan    = \App\Models\Wisata::whereIn('category_id', $penginapanIds)->where('tampil_home', true)->limit(4)->get();

        $transportasiIds = \App\Models\Category::where('parent_id', 19)->pluck('id');
        $transportasi    = \App\Models\Wisata::whereIn('category_id', $transportasiIds)->where('tampil_home', true)->limit(4)->get();

        $kulinerIds   = \App\Models\Category::where('parent_id', 23)->pluck('id');
        $kuliner      = \App\Models\Wisata::whereIn('category_id', $kulinerIds)->where('tampil_home', true)->limit(4)->get();

        $blogInformasi = \App\Models\Wisata::whereHas('category', function($q) {
            $q->where('parent_id', 27);
        })
        ->where('tampil_home', true)
        ->orderBy('urutan_subkategori', 'asc')
        ->orderBy('created_at', 'desc')
        ->get();

        $deskripsiKota = \App\Models\DeskripsiKota::first();

        return view('home', compact(
            'pamflets', 'wisataPopuler',
            'wisataAlam', 'hiburanKel', 'penginapan',
            'transportasi', 'kuliner', 'blogInformasi',
            'deskripsiKota'
        ));
    }

    public function pantai()
{
    $category = \App\Models\Category::where('name', 'Wisata Pantai')->first();
    if (!$category) {
        $wisatas = collect();
    } else {
        $wisatas = Wisata::where('category_id', $category->id)->latest()->get();
    }
    return view('wisata-pantai', compact('wisatas'));
}
public function wisataAlam()
{
    $subKategoris = \App\Models\Category::where('parent_id', 1)
                    ->with(['wisatas' => function($q) {
                        $q->orderBy('urutan_subkategori', 'asc')
                          ->orderBy('created_at', 'desc');
                    }])
                    ->get();

    return view('wisata-alam', compact('subKategoris'));
}
public function subKategori($id)
{
    $category = \App\Models\Category::findOrFail($id);
    $wisatas = \App\Models\Wisata::where('category_id', $id)
        ->orderByRaw('ISNULL(urutan_subkategori), urutan_subkategori ASC')
        ->orderBy('created_at', 'desc')
        ->get();

    $parentCategory = $category->parent_id
        ? \App\Models\Category::findOrFail($category->parent_id)
        : $category;

    $siblings = \App\Models\Category::where('parent_id', $parentCategory->id)->get();

    return view('sub-kategori', compact('wisatas', 'category', 'parentCategory', 'siblings'));
}
public function detail($slug)
{
    $wisata = Wisata::with('category')->where('slug', $slug)->firstOrFail();

    $related = Wisata::where('category_id', $wisata->category_id)
                     ->where('id', '!=', $wisata->id)
                     ->limit(4)
                     ->get();

    $parentId = $wisata->category ? $wisata->category->parent_id : null;

    if ($parentId == 15) {
        $view = 'detail-jasa';
        $labelHarga = 'Harga per Malam';
    } elseif ($parentId == 19) {
        $view = 'detail-jasa';
        $labelHarga = 'Harga Sewa';
    } elseif ($parentId == 23) {
        $view = 'detail-kuliner';
        $labelHarga = 'Range Harga Menu';
    } else {
        $view = 'detail';
        $labelHarga = 'Harga Tiket';
    }

    $ulasans = Ulasan::where('wisata_id', $wisata->id)
        ->where('status', 'approved')
        ->orderBy('urutan')
        ->orderBy('created_at', 'desc')
        ->limit(5)
        ->get();

    $totalUlasan = Ulasan::where('wisata_id', $wisata->id)
        ->where('status', 'approved')
        ->count();

    $rataRating = Ulasan::where('wisata_id', $wisata->id)
        ->where('status', 'approved')
        ->avg('rating');

    $rataRating = $rataRating ? round($rataRating, 1) : 0;

    return view($view, compact('wisata', 'related', 'labelHarga', 'ulasans', 'totalUlasan', 'rataRating'));
}
public function hiburanKel()
{
    $category = \App\Models\Category::findOrFail(8);
    $subKategoris = \App\Models\Category::where('parent_id', 8)
        ->with(['wisatas' => function($q) {
            $q->orderBy('urutan_subkategori', 'asc')
              ->orderBy('created_at', 'desc');
        }])
        ->get();

    $wisatas = $subKategoris->isEmpty()
        ? \App\Models\Wisata::where('category_id', 8)->latest()->get()
        : collect();

    return view('hiburan-kel', compact('subKategoris', 'wisatas', 'category'));
}

public function penginapan()
{
    $category = \App\Models\Category::findOrFail(15);
    $subKategoris = \App\Models\Category::where('parent_id', 15)
        ->with(['wisatas' => function($q) {
            $q->orderBy('urutan_subkategori', 'asc')
              ->orderBy('created_at', 'desc');
        }])
        ->get();

    $wisatas = $subKategoris->isEmpty()
        ? \App\Models\Wisata::where('category_id', 15)->latest()->get()
        : collect();

    return view('penginapan', compact('subKategoris', 'wisatas', 'category'));
}

public function transportasi()
{
    $category = \App\Models\Category::findOrFail(19);
    $subKategoris = \App\Models\Category::where('parent_id', 19)
        ->with(['wisatas' => function($q) {
            $q->orderBy('urutan_subkategori', 'asc')
              ->orderBy('created_at', 'desc');
        }])
        ->get();

    $wisatas = $subKategoris->isEmpty()
        ? \App\Models\Wisata::where('category_id', 19)->latest()->get()
        : collect();

    return view('transportasi', compact('subKategoris', 'wisatas', 'category'));
}

public function kuliner()
{
    $category = \App\Models\Category::findOrFail(23);
    $subKategoris = \App\Models\Category::where('parent_id', 23)
        ->with(['wisatas' => function($q) {
            $q->orderBy('urutan_subkategori', 'asc')
              ->orderBy('created_at', 'desc');
        }])
        ->get();

    $wisatas = $subKategoris->isEmpty()
        ? \App\Models\Wisata::where('category_id', 23)->latest()->get()
        : collect();

    return view('kuliner', compact('subKategoris', 'wisatas', 'category'));
}

public function searchWisata(Request $request)
{
    $keyword = $request->input('q', '');

    if (strlen(trim($keyword)) < 2) {
        return response()->json([]);
    }

    $results = Wisata::with('category')
        ->where('nama_wisata', 'LIKE', '%' . $keyword . '%')
        ->limit(10)
        ->get()
        ->map(function ($w) {
            $parentId = $w->category ? $w->category->parent_id : null;
            return [
                'nama'      => $w->nama_wisata,
                'slug'      => $w->slug,
                'kategori'  => $w->category ? $w->category->name : '',
                'parent_id' => $parentId,
                'gambar'    => $w->gambar1 ? asset('images/' . $w->gambar1) : null,
                'link_nav'  => $w->link_navigasi ?? null,
            ];
        });

    return response()->json($results);
}

public function blogInformasi()
{
    $category = \App\Models\Category::findOrFail(27);
    $subKategoris = \App\Models\Category::where('parent_id', 27)
        ->with(['wisatas' => function($q) {
            $q->orderBy('urutan_subkategori', 'asc')
              ->orderBy('created_at', 'desc');
        }])
        ->get();

    $wisatas = $subKategoris->isEmpty()
        ? \App\Models\Wisata::where('category_id', 27)->latest()->get()
        : collect();

    return view('blog-informasi', compact('subKategoris', 'wisatas', 'category'));
}
}