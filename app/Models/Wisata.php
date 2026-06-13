<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; // ← tambah ini

class Wisata extends Model
{
    protected $fillable = [
        'category_id', 'nama_wisata', 'slug',
        'gambar1', 'gambar2', 'gambar3',
        'deskripsi', 'jam_buka', 'jam_tutup', 'harga_tiket', 'fasilitas', 'rincian_penginapan',
        'biaya_parkir', 'biaya_penginapan', 'info_tiket_tambahan',
        'alamat_lengkap', 'link_gmaps', 'instagram', 'whatsapp',
        'facebook', 'twitter', 'tiktok', 'youtube', 'link_navigasi', 'link_sumber',
        'is_populer', 'urutan_populer', 'urutan_subkategori', 'tampil_home',
    ];

    protected $casts = [
        'is_populer'   => 'boolean',
        'tampil_home'  => 'boolean',
    ];

    // ← tambah ini
    protected static function booted()
{
    static::creating(function ($wisata) {
        $wisata->slug = Str::slug($wisata->nama_wisata) . '-' . rand(100, 999);
    });

    static::updating(function ($wisata) {
        if ($wisata->isDirty('nama_wisata')) {
            $wisata->slug = Str::slug($wisata->nama_wisata) . '-' . rand(100, 999);
        }
    });
}

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function ulasans()
    {
        return $this->hasMany(Ulasan::class);
    }
}