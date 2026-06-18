<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeskripsiKotaController extends Controller
{
    public function edit()
    {
        $deskripsi = \App\Models\DeskripsiKota::first();
        if (!$deskripsi) {
            $deskripsi = \App\Models\DeskripsiKota::create([
                'teks'   => 'Isi deskripsi kota di sini.',
                'gambar' => null,
            ]);
        }
        return view('admin.deskripsi-kota', compact('deskripsi'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'teks'   => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:10240',
        ], [
            'teks.required' => 'Deskripsi kota wajib diisi.',
            'gambar.image'  => 'File harus berupa gambar.',
            'gambar.mimes'  => 'Format gambar harus jpeg, png, atau jpg.',
            'gambar.max'    => 'Ukuran gambar maksimal 10MB.',
        ]);

        $deskripsi = \App\Models\DeskripsiKota::first();
        if (!$deskripsi) {
            $deskripsi = new \App\Models\DeskripsiKota();
        }

        $deskripsi->teks = $request->teks;

        if ($request->hasFile('gambar')) {
            if ($deskripsi->gambar && file_exists(public_path('images/' . $deskripsi->gambar))) {
                try { @unlink(public_path('images/' . $deskripsi->gambar)); } catch (\Throwable $e) {}
            }
            $file     = $request->file('gambar');
            $namaFile = time() . '_deskripsi_kota_' . $file->getClientOriginalName();
            try {
                $file->move(public_path('images'), $namaFile);
                $deskripsi->gambar = $namaFile;
            } catch (\Throwable $e) {}
        }

        $deskripsi->save();

        return redirect()->route('admin')->with('success', 'Deskripsi kota berhasil diupdate!');
    }
}
