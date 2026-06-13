<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            // SUB-KATEGORI: WISATA ALAM (ID 1-6)
            ['id' => 1, 'name' => 'Wisata Pantai'],
            ['id' => 2, 'name' => 'Wisata Air Terjun'],
            ['id' => 3, 'name' => 'Wisata Sungai/Waduk'],
            ['id' => 4, 'name' => 'Wisata Hutan'],
            ['id' => 5, 'name' => 'Wisata Pegunungan/Bukit'],
            ['id' => 6, 'name' => 'Wisata Goa'],

            // SUB-KATEGORI: WISATA KELUARGA / LAINNYA (ID 7 dst)
            ['id' => 7, 'name' => 'Wisata Keluarga'],
            ['id' => 8, 'name' => 'Taman Hiburan'],
            ['id' => 9, 'name' => 'Penginapan / Glamping'],
            ['id' => 10, 'name' => 'Kuliner'],
        ];

        // Kosongkan tabel dulu agar tidak double saat di-seed ulang
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('categories')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('categories')->insert($categories);
    }
}