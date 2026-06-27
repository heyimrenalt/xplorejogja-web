<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaketWisata extends Model
{
    protected $table = 'paket_wisata';

    protected $fillable = [
        'wisata_id', 'nama_paket', 'gambar', 'lokasi', 'durasi',
        'transport', 'makan', 'harga', 'satuan_harga', 'keterangan_harga',
        'destinasi_kunjungi', 'termasuk',
    ];

    public function wisata()
    {
        return $this->belongsTo(Wisata::class);
    }

    public function images()
    {
        return $this->hasMany(PaketWisataImage::class, 'paket_wisata_id')->orderBy('urutan');
    }

    protected static function booted()
    {
        static::deleting(function ($paket) {
            if ($paket->gambar) {
                $path = public_path('images/' . $paket->gambar);
                if (file_exists($path) && is_file($path)) {
                    try { @unlink($path); } catch (\Throwable $e) {}
                }
            }
            foreach ($paket->images as $img) {
                $imgPath = public_path('images/' . $img->path_gambar);
                if (file_exists($imgPath) && is_file($imgPath)) {
                    try { @unlink($imgPath); } catch (\Throwable $e) {}
                }
            }
        });
    }
}
