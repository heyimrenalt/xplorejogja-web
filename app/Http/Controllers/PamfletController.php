<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pamflet;

class PamfletController extends Controller
{
    public function index()
    {
        session(['admin_back_url' => request()->fullUrl()]);

        $pamflets = Pamflet::orderBy('urutan')->get();
        return response()->view('admin.pamflet.index', compact('pamflets'))
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate')
            ->header('Pragma', 'no-cache');
    }

    public function create()
    {
        $count = Pamflet::count();
        return view('admin.pamflet.create', compact('count'));
    }

    public function store(Request $request)
    {
        if (Pamflet::count() >= 7) {
            return redirect()->route('pamflet.index')
                ->with('error', 'Maksimal 7 pamflet telah tercapai. Hapus dulu salah satu untuk menambah baru.');
        }

        $request->validate([
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'gambar.required' => 'Gambar wajib diunggah.',
            'gambar.image'    => 'File harus berupa gambar.',
            'gambar.mimes'    => 'Format gambar harus jpeg, png, atau jpg.',
            'gambar.max'      => 'Ukuran gambar maksimal 2MB.',
        ]);

        $file     = $request->file('gambar');
        $namaFile = time() . '_pamflet_' . $file->getClientOriginalName();
        try {
            $file->move(public_path('images'), $namaFile);
        } catch (\Throwable $e) {}

        $maxUrutan = Pamflet::max('urutan');
        $urutan    = ($maxUrutan !== null ? (int)$maxUrutan : 0) + 1;

        Pamflet::create([
            'gambar' => $namaFile,
            'urutan' => $urutan,
        ]);

        $redirectTo = $request->input('redirect_to');
        if ($redirectTo && strpos($redirectTo, url('/')) === 0) {
            return redirect($redirectTo)->with('success', 'Pamflet berhasil ditambahkan!');
        }
        return redirect()->route('pamflet.index')->with('success', 'Pamflet berhasil ditambahkan!');
    }

    public function show($id)
    {
        return redirect()->route('pamflet.edit', $id);
    }

    public function edit($id)
    {
        $pamflet = Pamflet::findOrFail($id);
        return view('admin.pamflet.edit', compact('pamflet'));
    }

    public function update(Request $request, $id)
    {
        $pamflet = Pamflet::findOrFail($id);

        $request->validate([
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus jpeg, png, atau jpg.',
            'gambar.max'   => 'Ukuran gambar maksimal 2MB.',
        ]);

        if ($request->hasFile('gambar')) {
            if ($pamflet->gambar) {
                $oldFile = public_path('images/' . $pamflet->gambar);
                if (file_exists($oldFile) && is_file($oldFile)) {
                    try { @unlink($oldFile); } catch (\Throwable $e) {}
                }
            }

            $file     = $request->file('gambar');
            $namaFile = time() . '_pamflet_' . $file->getClientOriginalName();
            try {
                $file->move(public_path('images'), $namaFile);
                $pamflet->gambar = $namaFile;
            } catch (\Throwable $e) {}
        }

        $pamflet->save();

        $redirectTo = $request->input('redirect_to');
        if ($redirectTo && strpos($redirectTo, url('/')) === 0) {
            return redirect($redirectTo)->with('success', 'Pamflet berhasil diupdate!');
        }
        return redirect()->route('pamflet.index')->with('success', 'Pamflet berhasil diupdate!');
    }

    public function destroy($id)
    {
        $pamflet = Pamflet::findOrFail($id);

        if ($pamflet->gambar) {
            $path = public_path('images/' . $pamflet->gambar);
            if (file_exists($path) && is_file($path)) {
                try { @unlink($path); } catch (\Throwable $e) {}
            }
        }

        $pamflet->delete();

        Pamflet::orderBy('urutan')->get()->each(function ($p, $index) {
            $p->update(['urutan' => $index + 1]);
        });

        $redirectTo = request()->input('redirect_to');
        if ($redirectTo && strpos($redirectTo, url('/')) === 0) {
            return redirect($redirectTo)->with('success', 'Pamflet berhasil dihapus!');
        }
        return redirect()->route('admin')->with('success', 'Pamflet berhasil dihapus!');
    }

    public function updateOrder(Request $request)
    {
        $order = $request->input('order', []);

        foreach ($order as $index => $id) {
            Pamflet::where('id', $id)->update(['urutan' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }
}
