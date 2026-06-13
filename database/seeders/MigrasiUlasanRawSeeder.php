<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Wisata;
use App\Models\Ulasan;

class MigrasiUlasanRawSeeder extends Seeder
{
    public function run()
    {
        $wisatas = Wisata::whereNotNull('ulasan_raw')->get();

        foreach ($wisatas as $wisata) {
            if (!$wisata->ulasan_raw || !trim($wisata->ulasan_raw)) {
                continue;
            }

            $sudahAda = Ulasan::where('wisata_id', $wisata->id)->exists();
            if ($sudahAda) {
                $this->command->info('Skip ' . $wisata->nama_wisata . ' — ulasan sudah ada di tabel ulasans.');
                continue;
            }

            $items = explode("\n", trim($wisata->ulasan_raw));
            $urutan = 1;
            foreach ($items as $item) {
                $item = trim($item);
                if (!$item) {
                    continue;
                }
                $parts = explode('|', $item);
                if (count($parts) < 3) {
                    continue;
                }
                Ulasan::create([
                    'wisata_id' => $wisata->id,
                    'nama'      => trim($parts[0]),
                    'rating'    => (int) trim($parts[1]),
                    'teks'      => trim($parts[2]),
                    'status'    => 'approved',
                    'urutan'    => $urutan,
                ]);
                $urutan++;
            }

            $this->command->info('Migrasi ulasan: ' . $wisata->nama_wisata . ' (' . ($urutan - 1) . ' ulasan)');
        }

        $this->command->info('Selesai. Jalankan seeder ini sekali saja.');
    }
}
