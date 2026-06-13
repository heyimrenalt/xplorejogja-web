<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\WisataController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\PamfletController;
use App\Http\Controllers\UlasanController;
use App\Http\Controllers\DeskripsiKotaController;

// --- RUTE PUBLIK ---
Route::get('/', [PublicController::class, 'home'])->name('home');

Route::get('/wisata-alam', [PublicController::class, 'wisataAlam'])->name('wisata-alam');
Route::get('/wisata-pantai', [PublicController::class, 'pantai'])->name('wisata-pantai');
Route::get('/hiburan-kel', [PublicController::class, 'hiburanKel'])->name('hiburan-kel');
Route::get('/penginapan', [PublicController::class, 'penginapan'])->name('penginapan');
Route::get('/transportasi', [PublicController::class, 'transportasi'])->name('transportasi');
Route::get('/kuliner', [PublicController::class, 'kuliner'])->name('kuliner');
Route::get('/blog-informasi', [PublicController::class, 'blogInformasi'])->name('blog-informasi');
Route::get('/sub-kategori/{id}', [PublicController::class, 'subKategori'])->name('sub-kategori');
Route::get('/api/search', [PublicController::class, 'searchWisata'])->name('api.search');

// Detail wisata publik
Route::get('/destinasi/{slug}', [PublicController::class, 'detail'])->name('wisata.detail');

// Ulasan publik
Route::post('/destinasi/{slug}/ulasan', [UlasanController::class, 'store'])->name('ulasan.store');
Route::get('/destinasi/{slug}/ulasan', [UlasanController::class, 'loadMore'])->name('ulasan.loadMore');

// --- RUTE AUTH ---
Auth::routes();

// --- RUTE ADMIN (Wajib Login) ---
Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [WisataController::class, 'index'])->name('admin');

    // Wisata CRUD
    Route::post('/wisata/populer-order', [WisataController::class, 'updatePopulerOrder'])->name('wisata.updatePopulerOrder');
    Route::post('/wisata/{id}/toggle-home', [WisataController::class, 'toggleTampilHome'])->name('wisata.toggleHome');
    Route::post('/wisata/{id}/toggle-populer', [WisataController::class, 'togglePopuler'])->name('wisata.togglePopuler');
    Route::post('/wisata/{id}/remove-populer', [WisataController::class, 'removePopuler'])->name('wisata.removePopuler');
    Route::get('/admin/wisata/kategori/{parentId}', [WisataController::class, 'indexByKategori'])->name('wisata.kategori');
    Route::post('/wisata/subkategori-order', [WisataController::class, 'updateSubkategoriOrder'])->name('wisata.updateSubkategoriOrder');
    Route::resource('wisata', WisataController::class);

    // Pamflet CRUD
    Route::post('/pamflet/order', [PamfletController::class, 'updateOrder'])->name('pamflet.order');
    Route::resource('pamflet', PamfletController::class)->only(['index', 'show', 'create', 'store', 'edit', 'update', 'destroy']);

    // Ulasan admin
    Route::get('/admin/ulasan', [UlasanController::class, 'index'])->name('ulasan.index');
    Route::get('/admin/ulasan/kategori/{parentId}', [UlasanController::class, 'indexByKategori'])->name('ulasan.indexByKategori');
    Route::get('/admin/ulasan/{id}/detail', [UlasanController::class, 'show'])->name('ulasan.show');
    Route::post('/admin/ulasan/{id}/approve', [UlasanController::class, 'approve'])->name('ulasan.approve');
    Route::post('/admin/ulasan/{id}/reject', [UlasanController::class, 'reject'])->name('ulasan.reject');
    Route::post('/admin/ulasan/{id}/pending', [UlasanController::class, 'setPending'])->name('ulasan.pending');
    Route::post('/admin/ulasan/order', [UlasanController::class, 'updateOrder'])->name('ulasan.updateOrder');
    Route::delete('/admin/ulasan/{id}', [UlasanController::class, 'destroy'])->name('ulasan.destroy');

    // Deskripsi Kota
    Route::get('/admin/deskripsi-kota', [DeskripsiKotaController::class, 'edit'])->name('deskripsi-kota.edit');
    Route::post('/admin/deskripsi-kota', [DeskripsiKotaController::class, 'update'])->name('deskripsi-kota.update');

    // Blog
    Route::get('/admin/blog', function() { return redirect()->route('blog.create'); });
    Route::get('/admin/blog/create', [BlogController::class, 'create'])->name('blog.create');
    Route::post('/admin/blog', [BlogController::class, 'store'])->name('blog.store');
    Route::get('/admin/blog/{id}/edit', [BlogController::class, 'edit'])->name('blog.edit');
    Route::put('/admin/blog/{id}', [BlogController::class, 'update'])->name('blog.update');
    Route::delete('/admin/blog/{id}', [BlogController::class, 'destroy'])->name('blog.destroy');
});
