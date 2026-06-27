<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaketWisata extends Model
{
    protected $table = 'paket_wisata';

    protected $fillable = [
        'wisata_id', 'nama_paket', 'gambar', 'lokasi', 'durasi',
        'transport', 'makan', 'harga', 'destinasi_kunjungi',
        'termasuk', 'tidak_termasuk',
    ];

    public function wisata()
    {
        return $this->belongsTo(Wisata::class);
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
        });
    }
}
