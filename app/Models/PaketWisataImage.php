<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaketWisataImage extends Model
{
    protected $table = 'paket_wisata_images';

    protected $fillable = ['paket_wisata_id', 'path_gambar', 'urutan'];

    public function paketWisata()
    {
        return $this->belongsTo(PaketWisata::class);
    }
}
