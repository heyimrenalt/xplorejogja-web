<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ulasan extends Model
{
    protected $fillable = [
        'wisata_id', 'nama', 'rating', 'teks',
        'foto1', 'foto2', 'foto3', 'urutan', 'status',
    ];

    public function wisata()
    {
        return $this->belongsTo(Wisata::class);
    }
}
