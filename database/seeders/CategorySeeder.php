<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Category::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $categories = [
            'Wisata Alam' => [
                'Wisata Pantai', 'Wisata Air Terjun', 'Wisata Sungai/Waduk',
                'Wisata Hutan', 'Wisata Pegunungan/Bukit', 'Wisata Goa'
            ],
            'Hiburan Keluarga' => [
                'Taman Bermain', 'Wahana Air', 'Kebun Binatang'
            ],
            'Pantai Parangtritis' => [
                'Info Pantai', 'Aktivitas Pantai'
            ],
            'Penginapan' => [
                'Hotel', 'Villa', 'Homestay'
            ],
            'Transportasi' => [
                'Sewa Motor', 'Sewa Mobil', 'Ojek Wisata'
            ],
            'Kuliner' => [
                'Cafe & Resto', 'Kuliner Tradisional', 'Street Food'
            ],
            'Blog & Informasi' => [
                'Tips Wisata', 'Berita', 'Panduan'
            ],
        ];

        foreach ($categories as $parent => $children) {
            $parentCat = Category::create([
                'name' => $parent,
                'parent_id' => null
            ]);
            foreach ($children as $child) {
                Category::create([
                    'name' => $child,
                    'parent_id' => $parentCat->id
                ]);
            }
        }
    }
}