<?php
// app/Models/Category.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'parent_id'];

    // Relasi ke sub kategori
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    // Relasi ke parent
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
    public function wisatas()
{
    return $this->hasMany(\App\Models\Wisata::class, 'category_id');
}
}