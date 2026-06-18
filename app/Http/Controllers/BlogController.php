<?php

namespace App\Http\Controllers;

use App\Models\Wisata;
use App\Models\Category;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function create()
    {
        $subKategoris = Category::where('parent_id', 27)->get();
        return view('admin.blog.create', compact('subKategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'nama_wisata' => 'required',
            'gambar1'     => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'alamat_lengkap' => 'required',
            'link_sumber' => 'required|url',
        ], [
            'category_id.required'  => 'Sub kategori wajib dipilih.',
            'nama_wisata.required'  => 'Judul artikel wajib diisi.',
            'gambar1.required'      => 'Thumbnail wajib diunggah.',
            'gambar1.image'         => 'File harus berupa gambar.',
            'gambar1.mimes'         => 'Format gambar harus jpeg, png, atau jpg.',
            'gambar1.max'           => 'Ukuran gambar maksimal 2MB.',
            'alamat_lengkap.required' => 'Sumber wajib diisi.',
            'link_sumber.required'  => 'Link sumber wajib diisi.',
            'link_sumber.url'       => 'Format link sumber tidak valid.',
        ]);

        $data = $request->only(['category_id', 'nama_wisata', 'alamat_lengkap']);
        $data['link_sumber']   = $request->input('link_sumber');
        $data['link_navigasi'] = $request->input('link_sumber'); // juga simpan ke link_navigasi untuk kompatibilitas
        $data['deskripsi'] = '';

        if ($request->hasFile('gambar1')) {
            $file = $request->file('gambar1');
            $namaFile = time() . '_gambar1_' . $file->getClientOriginalName();
            try {
                $file->move(public_path('images'), $namaFile);
                $data['gambar1'] = $namaFile;
            } catch (\Throwable $e) {}
        }

        Wisata::create($data);

        return redirect()->route('admin')->with('success', 'Artikel Blog berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $blog = Wisata::findOrFail($id);
        $subKategoris = Category::where('parent_id', 27)->get();
        return view('admin.blog.edit', compact('blog', 'subKategoris'));
    }

    public function update(Request $request, $id)
    {
        $blog = Wisata::findOrFail($id);

        $request->validate([
            'category_id'    => 'required',
            'nama_wisata'    => 'required',
            'gambar1'        => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'alamat_lengkap' => 'required',
            'link_sumber'    => 'required|url',
        ], [
            'category_id.required'    => 'Sub kategori wajib dipilih.',
            'nama_wisata.required'    => 'Judul artikel wajib diisi.',
            'gambar1.image'           => 'File harus berupa gambar.',
            'gambar1.mimes'           => 'Format gambar harus jpeg, png, atau jpg.',
            'gambar1.max'             => 'Ukuran gambar maksimal 2MB.',
            'alamat_lengkap.required' => 'Sumber wajib diisi.',
            'link_sumber.required'    => 'Link sumber wajib diisi.',
            'link_sumber.url'         => 'Format link sumber tidak valid.',
        ]);

        $data = $request->only(['category_id', 'nama_wisata', 'alamat_lengkap']);
        $data['link_sumber']   = $request->input('link_sumber');
        $data['link_navigasi'] = $request->input('link_sumber'); // juga simpan ke link_navigasi untuk kompatibilitas
        $data['deskripsi'] = $blog->deskripsi ?? '';

        if ($request->hasFile('gambar1')) {
            if ($blog->gambar1 && file_exists(public_path('images/' . $blog->gambar1))) {
                try { @unlink(public_path('images/' . $blog->gambar1)); } catch (\Throwable $e) {}
            }
            $file = $request->file('gambar1');
            $namaFile = time() . '_gambar1_' . $file->getClientOriginalName();
            try {
                $file->move(public_path('images'), $namaFile);
                $data['gambar1'] = $namaFile;
            } catch (\Throwable $e) {}
        }

        $blog->update($data);

        return redirect()->route('admin')->with('success', 'Artikel Blog berhasil diupdate!');
    }

    public function destroy($id)
    {
        $blog = Wisata::findOrFail($id);

        if ($blog->gambar1 && file_exists(public_path('images/' . $blog->gambar1))) {
            try { @unlink(public_path('images/' . $blog->gambar1)); } catch (\Throwable $e) {}
        }

        $blog->delete();

        return redirect()->route('admin')->with('success', 'Artikel Blog berhasil dihapus!');
    }
}