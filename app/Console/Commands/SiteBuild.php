<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Wisata;
use Illuminate\Console\Command;
use Illuminate\Contracts\Http\Kernel as HttpKernel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SiteBuild extends Command
{
    /**
     * Contoh:
     *   php artisan site:build
     *   php artisan site:build --base=https://heyimrenalt.github.io/xplorejogja-web
     */
    protected $signature = 'site:build
        {--base=https://heyimrenalt.github.io/xplorejogja-web : Base URL tujuan (alamat GitHub Pages)}
        {--out=dist : Folder output relatif ke root project}';

    protected $description = 'Render seluruh halaman publik menjadi HTML statis untuk hosting di GitHub Pages';

    public function handle(): int
    {
        $base = rtrim($this->option('base'), '/');
        $out  = base_path($this->option('out'));

        $this->info("Base URL : {$base}");
        $this->info("Output   : {$out}");
        $this->newLine();

        // 1. Bersihkan folder output
        if (File::isDirectory($out)) {
            File::deleteDirectory($out);
        }
        File::makeDirectory($out, 0755, true);

        // 2. Kumpulkan semua URL publik yang mau dirender
        $paths = [
            '/', '/wisata-alam', '/wisata-pantai', '/hiburan-kel', '/penginapan',
            '/transportasi', '/kuliner', '/blog-informasi', '/paket',
        ];

        foreach (Category::pluck('id') as $id) {
            $paths[] = "/sub-kategori/{$id}";
        }

        foreach (Wisata::whereNotNull('slug')->where('slug', '<>', '')->pluck('slug') as $slug) {
            $paths[] = "/destinasi/{$slug}";
        }

        $paths = array_values(array_unique($paths));

        // 3. Render tiap URL lewat HTTP kernel (tanpa perlu jalankan server)
        $kernel = app(HttpKernel::class);
        $ok = 0;
        $skip = 0;

        foreach ($paths as $path) {
            $request  = Request::create('http://localhost' . $path, 'GET');
            $response = $kernel->handle($request);
            $status   = $response->getStatusCode();

            if ($status !== 200) {
                $this->warn("  [{$status}] SKIP  {$path}");
                $skip++;
                continue;
            }

            $html = $this->postProcess($response->getContent(), $base);
            File::put($this->targetFile($out, $path), $html);
            $this->line("  [200] OK    {$path}");
            $ok++;
        }

        // 4. Generate index pencarian client-side
        $this->writeSearchIndex($out, $base);

        // 5. Salin aset statis
        $this->copyAssets($out);

        // 6. File pendukung GitHub Pages
        File::put($out . '/.nojekyll', '');
        // fallback 404 -> arahkan ke home
        if (File::exists($out . '/index.html')) {
            File::copy($out . '/index.html', $out . '/404.html');
        }

        $this->newLine();
        $this->info("Selesai. {$ok} halaman dirender, {$skip} dilewati.");
        $this->info("Folder siap deploy: {$out}");

        return self::SUCCESS;
    }

    /** Tentukan path file output: '/' -> index.html, '/wisata-alam' -> wisata-alam/index.html */
    private function targetFile(string $out, string $path): string
    {
        $clean = trim($path, '/');
        $dir   = $clean === '' ? $out : $out . '/' . $clean;
        File::ensureDirectoryExists($dir);
        return $dir . '/index.html';
    }

    /** Ganti host lokal jadi base URL + suntik script untuk mode statis */
    private function postProcess(string $html, string $base): string
    {
        // Semua URL absolut yang digenerate route()/asset()/url() memakai host lokal
        $html = str_replace(['http://localhost', 'https://localhost'], $base, $html);

        $inject = <<<HTML
<script>
window.__XPLORE_STATIC__ = true;
window.__XPLORE_SEARCH_URL__ = "{$base}/search-index.json";
document.addEventListener('DOMContentLoaded', function () {
    // Sembunyikan tombol "muat lebih banyak" ulasan (butuh backend)
    var lm = document.getElementById('btn-load-more');
    if (lm) lm.style.display = 'none';
    // Nonaktifkan form kirim ulasan (versi statis read-only)
    document.querySelectorAll('form[action*="/ulasan"]').forEach(function (f) {
        f.addEventListener('submit', function (e) {
            e.preventDefault();
            alert('Pengiriman ulasan dinonaktifkan pada versi ini.');
        });
    });
});
</script>
HTML;

        // Suntik sebelum </body> (fallback: sebelum </html>)
        if (stripos($html, '</body>') !== false) {
            return preg_replace('/<\/body>/i', $inject . '</body>', $html, 1);
        }
        return $html . $inject;
    }

    /** Buat search-index.json dengan bentuk data yang sama seperti /api/search */
    private function writeSearchIndex(string $out, string $base): void
    {
        $items = Wisata::with(['category:id,name,parent_id'])
            ->select('id', 'nama_wisata', 'slug', 'gambar1', 'link_navigasi', 'category_id')
            ->get()
            ->map(function ($w) use ($base) {
                return [
                    'nama'      => $w->nama_wisata,
                    'slug'      => $w->slug,
                    'kategori'  => $w->category ? $w->category->name : '',
                    'parent_id' => $w->category ? $w->category->parent_id : null,
                    'gambar'    => $w->gambar1 ? $base . '/images/' . $w->gambar1 : null,
                    'link_nav'  => $w->link_navigasi ?? null,
                ];
            })
            ->values();

        File::put($out . '/search-index.json', $items->toJson(JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
        $this->line('  search-index.json (' . $items->count() . ' item)');
    }

    /** Salin folder & file aset publik ke output */
    private function copyAssets(string $out): void
    {
        foreach (['css', 'images', 'img'] as $dir) {
            $src = public_path($dir);
            if (File::isDirectory($src)) {
                File::copyDirectory($src, $out . '/' . $dir);
            }
        }

        // public/storage adalah symlink -> salin isi asli storage/app/public
        $storage = storage_path('app/public');
        if (File::isDirectory($storage)) {
            File::copyDirectory($storage, $out . '/storage');
        }

        foreach (['favicon.ico', 'robots.txt'] as $file) {
            $src = public_path($file);
            if (File::exists($src)) {
                File::copy($src, $out . '/' . $file);
            }
        }

        $this->line('  aset disalin (css, images, img, storage)');
    }
}
