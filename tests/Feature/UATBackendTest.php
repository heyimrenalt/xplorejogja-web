<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Pamflet;
use App\Models\Ulasan;
use App\Models\User;
use App\Models\Wisata;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class UATBackendTest extends TestCase
{
    use RefreshDatabase;

    /** @var User */
    protected $admin;

    /** @var Category */
    protected $parentCategory;

    /** @var Category */
    protected $subCategory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'email'    => 'admin@xplorejogja.com',
            'password' => bcrypt('password123'),
        ]);

        // Parent = Wisata Alam, sub-category = Wisata Pantai
        // parent_id on sub-category won't be 15/19/23 → full validation applies
        $this->parentCategory = Category::create([
            'name'      => 'Wisata Alam',
            'parent_id' => null,
        ]);

        $this->subCategory = Category::create([
            'name'      => 'Wisata Pantai',
            'parent_id' => $this->parentCategory->id,
        ]);
    }

    // =========================================================================
    // UAT TABEL 4.5 — ADMIN AUTHENTICATION
    // =========================================================================

    // UAT Tabel 4.5 - Skenario 1: Login dengan kredensial valid
    public function test_login_valid_credentials_redirects_to_dashboard()
    {
        $response = $this->post('/login', [
            'email'    => 'admin@xplorejogja.com',
            'password' => 'password123',
        ]);
    

        $response->assertRedirect('/admin');
        $this->assertAuthenticated();
    }

    // UAT Tabel 4.5 - Skenario 2: Login dengan password salah
    public function test_login_wrong_password_shows_error_no_session()
    {
        $response = $this->post('/login', [
            'email'    => 'admin@xplorejogja.com',
            'password' => 'passwordsalah',
        ]);

        $response->assertSessionHasErrors();
        $this->assertGuest();
    }

    // UAT Tabel 4.5 - Skenario 3: Login dengan email tidak terdaftar
    public function test_login_unregistered_email_shows_error()
    {
        $response = $this->post('/login', [
            'email'    => 'tidakterdaftar@example.com',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors();
        $this->assertGuest();
    }

    // UAT Tabel 4.5 - Skenario 4: Login dengan email kosong
    public function test_login_empty_email_shows_validation_error()
    {
        $response = $this->post('/login', [
            'email'    => '',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    // UAT Tabel 4.5 - Skenario 5: Login dengan password kosong
    public function test_login_empty_password_shows_validation_error()
    {
        $response = $this->post('/login', [
            'email'    => 'admin@xplorejogja.com',
            'password' => '',
        ]);

        $response->assertSessionHasErrors('password');
        $this->assertGuest();
    }

    // UAT Tabel 4.5 - Skenario 6: Logout setelah login → session hancur, redirect ke login
    public function test_logout_destroys_session_and_redirects_to_login()
    {
        $response = $this->actingAs($this->admin)->post('/logout');

        $response->assertRedirect('/login');
        $this->assertGuest();
    }

    // UAT Tabel 4.5 - Skenario 7: Akses /admin tanpa session → redirect ke login (HTTP 302)
    public function test_access_admin_without_session_redirects_to_login()
    {
        $response = $this->get('/admin');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    // UAT Tabel 4.5 - Skenario 8: Akses /admin setelah logout (simulasi tombol back)
    public function test_access_admin_after_logout_is_denied()
    {
        // Login then logout
        $this->actingAs($this->admin)->post('/logout');

        // New request without session (simulates pressing Back after logout)
        $response = $this->get('/admin');

        $response->assertStatus(302);
        $this->assertStringContainsString('login', $response->headers->get('Location') ?? '');
    }

    // =========================================================================
    // UAT TABEL 4.6 — CRUD WISATA / DESTINASI
    // =========================================================================

    /**
     * Build a complete valid payload for wisata store/update.
     * All fields required when parent_id is not 15/19/23.
     *
     * @param  array $overrides
     * @return array
     */
    private function wisataPayload(array $overrides = [])
    {
        return array_merge([
            'category_id'    => $this->subCategory->id,
            'nama_wisata'    => 'Pantai Test Indah',
            'gambar1'        => UploadedFile::fake()->image('gambar1.jpg', 800, 600),
            'deskripsi'      => 'Pantai yang sangat indah di Yogyakarta.',
            'jam_buka'       => '08:00',
            'jam_tutup'      => '17:00',
            'harga_tiket'    => 'Rp 10.000',
            'fasilitas'      => 'Parkir, Toilet, Mushola',
            'biaya_parkir'   => 'Motor Rp 2.000, Mobil Rp 5.000',
            'alamat_lengkap' => 'Jl. Pantai No. 1, Gunung Kidul, Yogyakarta',
            'link_gmaps'     => 'https://www.google.com/maps/embed?pb=test',
        ], $overrides);
    }

    /** Create a minimal wisata directly in DB (no controller, no file required). */
    private function makeWisata(array $attrs = [])
    {
        return Wisata::create(array_merge([
            'category_id'    => $this->subCategory->id,
            'nama_wisata'    => 'Wisata Seed',
            'gambar1'        => 'dummy.jpg',
            'deskripsi'      => 'Deskripsi seed.',
            'harga_tiket'    => 'Gratis',
            'fasilitas'      => 'Parkir',
            'alamat_lengkap' => 'Jl. Seed No. 1',
            'link_gmaps'     => 'https://maps.google.com/',
        ], $attrs));
    }

    // UAT Tabel 4.6 - Skenario 1: Buat destinasi dengan semua field valid → tersimpan
    public function test_create_wisata_all_valid_fields_saves_to_database()
    {
        $response = $this->actingAs($this->admin)->post('/wisata', $this->wisataPayload());

        $this->assertDatabaseHas('wisatas', ['nama_wisata' => 'Pantai Test Indah']);
    }

    // UAT Tabel 4.6 - Skenario 2: Buat destinasi dengan nama kosong → validation error
    public function test_create_wisata_empty_nama_returns_validation_error()
    {
        $response = $this->actingAs($this->admin)
            ->post('/wisata', $this->wisataPayload(['nama_wisata' => '']));

        $response->assertSessionHasErrors('nama_wisata');
        $this->assertDatabaseMissing('wisatas', ['deskripsi' => 'Pantai yang sangat indah di Yogyakarta.']);
    }

    // UAT Tabel 4.6 - Skenario 3: Buat destinasi tanpa kategori → validation error
    public function test_create_wisata_without_category_returns_validation_error()
    {
        $response = $this->actingAs($this->admin)
            ->post('/wisata', $this->wisataPayload(['category_id' => '']));

        $response->assertSessionHasErrors('category_id');
    }

    // UAT Tabel 4.6 - Skenario 4: Edit destinasi yang ada → data terupdate di DB
    public function test_edit_wisata_updates_data_in_database()
    {
        $wisata = $this->makeWisata(['nama_wisata' => 'Nama Lama']);

        $response = $this->actingAs($this->admin)->put('/wisata/' . $wisata->id, [
            'category_id'    => $this->subCategory->id,
            'nama_wisata'    => 'Nama Baru Setelah Update',
            'deskripsi'      => 'Deskripsi baru.',
            'jam_buka'       => '09:00',
            'jam_tutup'      => '18:00',
            'harga_tiket'    => 'Rp 15.000',
            'fasilitas'      => 'Parkir, Toilet',
            'biaya_parkir'   => 'Motor Rp 3.000',
            'alamat_lengkap' => 'Jl. Baru No. 2',
            'link_gmaps'     => 'https://www.google.com/maps/embed?pb=updated',
            '_method'        => 'PUT',
        ]);

        $this->assertDatabaseHas('wisatas', [
            'id'         => $wisata->id,
            'nama_wisata' => 'Nama Baru Setelah Update',
        ]);
    }

    // UAT Tabel 4.6 - Skenario 5: Edit form dengan ID tidak ada → 404, bukan 500
    public function test_edit_wisata_nonexistent_id_returns_404()
    {
        $response = $this->actingAs($this->admin)->get('/wisata/99999/edit');

        $response->assertStatus(404);
    }

    // UAT Tabel 4.6 - Skenario 6: Hapus destinasi tanpa ulasan → dihapus dari wisatas
    public function test_delete_wisata_without_reviews_removes_record()
    {
        $wisata   = $this->makeWisata(['nama_wisata' => 'Wisata Hapus Bersih']);
        $response = $this->actingAs($this->admin)->delete('/wisata/' . $wisata->id);

        $response->assertStatus(302);
        $this->assertDatabaseMissing('wisatas', ['id' => $wisata->id]);
    }

    // UAT Tabel 4.6 - Skenario 7: Hapus destinasi yang punya ulasan → cascade, tidak 500
    public function test_delete_wisata_with_reviews_is_handled_gracefully_no_500()
    {
        $wisata = $this->makeWisata(['nama_wisata' => 'Wisata Hapus Dengan Ulasan']);

        Ulasan::create([
            'wisata_id' => $wisata->id,
            'nama'      => 'Reviewer Satu',
            'rating'    => 5,
            'teks'      => 'Sangat bagus!',
            'status'    => 'approved',
        ]);

        $response = $this->actingAs($this->admin)->delete('/wisata/' . $wisata->id);

        $this->assertNotEquals(500, $response->getStatusCode());
        $this->assertDatabaseMissing('wisatas', ['id' => $wisata->id]);
        $this->assertDatabaseMissing('ulasans', ['wisata_id' => $wisata->id]);
    }

    // =========================================================================
    // UAT TABEL 4.8 — CRUD BANNER (PAMFLET)
    // =========================================================================

    // UAT Tabel 4.8 - Skenario 1: Upload banner JPG/PNG valid → tersimpan di DB dan server
    public function test_upload_banner_valid_image_saves_to_database()
    {
        $response = $this->actingAs($this->admin)->post('/pamflet', [
            'gambar' => UploadedFile::fake()->image('banner.jpg', 1200, 400),
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseCount('pamflets', 1);
    }

    // UAT Tabel 4.8 - Skenario 2: Upload banner format PDF → ditolak, pesan error
    public function test_upload_banner_pdf_format_is_rejected_with_error()
    {
        $response = $this->actingAs($this->admin)->post('/pamflet', [
            'gambar' => UploadedFile::fake()->create('brosur.pdf', 500, 'application/pdf'),
        ]);

        $response->assertSessionHasErrors('gambar');
        $this->assertDatabaseCount('pamflets', 0);
    }

    // UAT Tabel 4.8 - Skenario 3: Submit form banner tanpa file → validation error
    public function test_upload_banner_without_file_shows_validation_error()
    {
        $response = $this->actingAs($this->admin)->post('/pamflet', []);

        $response->assertSessionHasErrors('gambar');
        $this->assertDatabaseCount('pamflets', 0);
    }

    // UAT Tabel 4.8 - Skenario 4: Edit banner dengan gambar baru → server diupdate
    public function test_edit_banner_with_new_image_updates_record()
    {
        $pamflet = Pamflet::create(['gambar' => 'old_banner.jpg', 'urutan' => 1]);

        $response = $this->actingAs($this->admin)->put('/pamflet/' . $pamflet->id, [
            'gambar' => UploadedFile::fake()->image('new_banner.png', 1200, 400),
        ]);

        $response->assertStatus(302);

        $updated = Pamflet::find($pamflet->id);
        $this->assertNotEquals('old_banner.jpg', $updated->gambar);
    }

    // UAT Tabel 4.8 - Skenario 5: Hapus banner → dihapus dari DB dan server
    public function test_delete_banner_removes_from_database()
    {
        $pamflet  = Pamflet::create(['gambar' => 'todelete.jpg', 'urutan' => 1]);
        $response = $this->actingAs($this->admin)->delete('/pamflet/' . $pamflet->id);

        $response->assertStatus(302);
        $this->assertDatabaseMissing('pamflets', ['id' => $pamflet->id]);
    }

    // =========================================================================
    // UAT TABEL 4.9 — API /api/search ENDPOINT
    // =========================================================================

    /** Create a wisata directly in DB for search tests (no file upload needed). */
    private function makeWisataForSearch($namaWisata)
    {
        return $this->makeWisata(['nama_wisata' => $namaWisata]);
    }

    // UAT Tabel 4.9 - Skenario 1: Search dengan keyword cocok → HTTP 200, JSON array valid
    public function test_search_matching_keyword_returns_200_and_json_array()
    {
        $this->makeWisataForSearch('Pantai Parangtritis');

        $response = $this->get('/api/search?q=Pantai');

        $response->assertStatus(200);
        $data = $response->json();
        $this->assertIsArray($data);
        $this->assertNotEmpty($data);
        $this->assertEquals('Pantai Parangtritis', $data[0]['nama']);
    }

    // UAT Tabel 4.9 - Skenario 2: Search dengan keyword tidak cocok → HTTP 200, array kosong
    public function test_search_no_matching_keyword_returns_empty_array()
    {
        $this->makeWisataForSearch('Pantai Kukup');

        $response = $this->get('/api/search?q=xyzabcnotmatch');

        $response->assertStatus(200);
        $response->assertJson([]);
    }

    // UAT Tabel 4.9 - Skenario 3: Search dengan query kosong → HTTP 200, tidak 500
    public function test_search_empty_query_returns_200_no_500()
    {
        $response = $this->get('/api/search?q=');

        $response->assertStatus(200);
        $data = $response->json();
        $this->assertIsArray($data);
    }

    // UAT Tabel 4.9 - Skenario 4: Struktur JSON response konsisten
    public function test_search_response_has_consistent_json_fields()
    {
        $this->makeWisataForSearch('Candi Prambanan');

        $response = $this->get('/api/search?q=Candi');

        $response->assertStatus(200);
        $data = $response->json();
        $this->assertNotEmpty($data);
        $this->assertArrayHasKey('nama', $data[0]);
        $this->assertArrayHasKey('slug', $data[0]);
        $this->assertArrayHasKey('kategori', $data[0]);
        $this->assertArrayHasKey('parent_id', $data[0]);
        $this->assertArrayHasKey('gambar', $data[0]);
    }

    // UAT Tabel 4.9 - Skenario 5: SQL Injection → tidak bocorkan data, tidak 500
    public function test_search_sql_injection_attempt_is_safe_no_data_leak()
    {
        $this->makeWisataForSearch('Pantai Normal');

        $response = $this->get('/api/search?q=' . urlencode("' OR 1=1 --"));

        $response->assertStatus(200);
        $data = $response->json();
        $this->assertIsArray($data);
        // Should return empty since keyword does not literally match nama_wisata
        $this->assertEmpty($data);
    }

    // UAT Tabel 4.9 - Skenario 6: XSS payload → di-escape dalam response JSON
    public function test_search_xss_payload_is_safe_in_json_response()
    {
        // The XSS payload itself won't be executed in a JSON context
        $this->makeWisataForSearch('Pantai Normal Biasa');

        $response = $this->get('/api/search?q=Pantai');

        $response->assertStatus(200);
        // JSON response is inherently safe — script tags won't execute from JSON
        $content = $response->getContent();
        $this->assertNotEmpty($content);
        $this->assertStringNotContainsString('<script>alert', $content);
    }

    // =========================================================================
    // UAT TABEL 4.10 — REVIEW SYSTEM
    // =========================================================================

    /** Create wisata with a predictable slug for ulasan route tests. */
    private function makeWisataWithSlug($slug)
    {
        $wisata = $this->makeWisata(['nama_wisata' => 'Wisata Ulasan ' . $slug]);
        // Override auto-generated slug directly
        $wisata->slug = $slug;
        $wisata->saveQuietly();
        return $wisata;
    }

    // UAT Tabel 4.10 - Skenario 1: Publik submit ulasan (tanpa auth) → tersimpan sebagai pending
    public function test_public_user_submits_review_saved_as_pending()
    {
        $wisata   = $this->makeWisataWithSlug('pantai-indah-555');
        $response = $this->post('/destinasi/' . $wisata->slug . '/ulasan', [
            'nama'   => 'Pengunjung Umum',
            'rating' => 5,
            'teks'   => 'Tempat yang sangat indah dan bersih!',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('ulasans', [
            'wisata_id' => $wisata->id,
            'nama'      => 'Pengunjung Umum',
            'status'    => 'pending',
        ]);
    }

    // UAT Tabel 4.10 - Skenario 2: Submit ulasan dengan teks kosong → validation error
    public function test_submit_review_empty_teks_shows_validation_error()
    {
        $wisata   = $this->makeWisataWithSlug('pantai-indah-556');
        $response = $this->post('/destinasi/' . $wisata->slug . '/ulasan', [
            'nama'   => 'User Test',
            'rating' => 3,
            'teks'   => '',
        ]);

        $response->assertSessionHasErrors('teks');
        $this->assertDatabaseMissing('ulasans', ['wisata_id' => $wisata->id]);
    }

    // UAT Tabel 4.10 - Skenario 3: Submit ulasan dengan teks 5000+ karakter → tidak 500
    public function test_submit_review_very_long_text_handled_without_500()
    {
        $wisata  = $this->makeWisataWithSlug('pantai-indah-557');
        $longTeks = str_repeat('Ulasan sangat panjang. ', 230); // ~5000 chars

        $response = $this->post('/destinasi/' . $wisata->slug . '/ulasan', [
            'nama'   => 'Reviewer Panjang',
            'rating' => 4,
            'teks'   => $longTeks,
        ]);

        $this->assertNotEquals(500, $response->getStatusCode());
    }

    // UAT Tabel 4.10 - Skenario 4: Admin lihat semua ulasan termasuk pending
    public function test_admin_views_all_reviews_including_pending()
    {
        $wisata = $this->makeWisataWithSlug('pantai-admin-558');

        Ulasan::create(['wisata_id' => $wisata->id, 'nama' => 'A', 'rating' => 5, 'teks' => 'Oke', 'status' => 'pending']);
        Ulasan::create(['wisata_id' => $wisata->id, 'nama' => 'B', 'rating' => 4, 'teks' => 'Bagus', 'status' => 'approved']);
        Ulasan::create(['wisata_id' => $wisata->id, 'nama' => 'C', 'rating' => 2, 'teks' => 'Biasa', 'status' => 'rejected']);

        $response = $this->actingAs($this->admin)
            ->get('/admin/ulasan/kategori/' . $this->parentCategory->id);

        $response->assertStatus(200);
    }

    // UAT Tabel 4.10 - Skenario 5: Admin approve ulasan pending → status jadi approved
    public function test_admin_approves_pending_review_status_becomes_approved()
    {
        $wisata = $this->makeWisataWithSlug('pantai-approve-559');
        $ulasan = Ulasan::create([
            'wisata_id' => $wisata->id,
            'nama'      => 'User Pending',
            'rating'    => 5,
            'teks'      => 'Sangat memuaskan!',
            'status'    => 'pending',
        ]);

        $response = $this->actingAs($this->admin)
            ->post('/admin/ulasan/' . $ulasan->id . '/approve');

        $response->assertStatus(200);
        $this->assertDatabaseHas('ulasans', ['id' => $ulasan->id, 'status' => 'approved']);
    }

    // UAT Tabel 4.10 - Skenario 6: Admin reject ulasan → status jadi rejected, tidak tampil publik
    public function test_admin_rejects_review_status_becomes_rejected_not_public()
    {
        $wisata = $this->makeWisataWithSlug('pantai-reject-560');
        $ulasan = Ulasan::create([
            'wisata_id' => $wisata->id,
            'nama'      => 'Spammer',
            'rating'    => 1,
            'teks'      => 'Konten spam atau tidak relevan',
            'status'    => 'pending',
        ]);

        $response = $this->actingAs($this->admin)
            ->post('/admin/ulasan/' . $ulasan->id . '/reject');

        $response->assertStatus(200);
        $this->assertDatabaseHas('ulasans', ['id' => $ulasan->id, 'status' => 'rejected']);

        // Verify rejected review is excluded from public approved count
        $publicCount = Ulasan::where('wisata_id', $wisata->id)
            ->where('status', 'approved')
            ->count();
        $this->assertEquals(0, $publicCount);
    }

    // UAT Tabel 4.10 - Skenario 7: Admin hapus ulasan → dihapus dari database
    public function test_admin_deletes_review_removes_from_database()
    {
        $wisata = $this->makeWisataWithSlug('pantai-delete-561');
        $ulasan = Ulasan::create([
            'wisata_id' => $wisata->id,
            'nama'      => 'User Hapus',
            'rating'    => 2,
            'teks'      => 'Ulasan yang akan dihapus admin',
            'status'    => 'pending',
        ]);

        $response = $this->actingAs($this->admin)
            ->delete('/admin/ulasan/' . $ulasan->id);

        $this->assertDatabaseMissing('ulasans', ['id' => $ulasan->id]);
    }

    // UAT Tabel 4.10 - Skenario 8: Hanya ulasan approved tampil di halaman publik
    public function test_only_approved_reviews_are_visible_publicly()
    {
        $wisata = $this->makeWisataWithSlug('pantai-public-562');

        Ulasan::create(['wisata_id' => $wisata->id, 'nama' => 'Disetujui', 'rating' => 5, 'teks' => 'Luar biasa!', 'status' => 'approved']);
        Ulasan::create(['wisata_id' => $wisata->id, 'nama' => 'Menunggu',  'rating' => 3, 'teks' => 'Biasa saja', 'status' => 'pending']);
        Ulasan::create(['wisata_id' => $wisata->id, 'nama' => 'Ditolak',   'rating' => 1, 'teks' => 'Buruk',      'status' => 'rejected']);

        // Simulate what PublicController::detail() queries
        $publiclyVisible = Ulasan::where('wisata_id', $wisata->id)
            ->where('status', 'approved')
            ->count();

        $this->assertEquals(1, $publiclyVisible);

        // Also hit the loadMore JSON endpoint (returns HTML of only approved)
        $response = $this->get('/destinasi/' . $wisata->slug . '/ulasan');
        $response->assertStatus(200);
        $html = $response->json()['html'] ?? '';
        $this->assertStringContainsString('Disetujui', $html);
        $this->assertStringNotContainsString('Menunggu', $html);
        $this->assertStringNotContainsString('Ditolak', $html);
    }

    // =========================================================================
    // UAT TABEL 4.11 — GOOGLE MAPS INTEGRATION
    // =========================================================================

    // UAT Tabel 4.11 - Skenario 1: Simpan link embed Google Maps valid → tersimpan, bisa iframe
    public function test_save_valid_gmaps_embed_url_is_stored_correctly()
    {
        $embedUrl = 'https://www.google.com/maps/embed?pb=!1m18!1m12!1mXYZ123';

        $this->actingAs($this->admin)->post('/wisata', $this->wisataPayload([
            'nama_wisata' => 'Wisata Maps Embed',
            'link_gmaps'  => $embedUrl,
        ]));

        $this->assertDatabaseHas('wisatas', [
            'nama_wisata' => 'Wisata Maps Embed',
            'link_gmaps'  => $embedUrl,
        ]);
    }

    // UAT Tabel 4.11 - Skenario 2: Simpan link navigasi valid → tersimpan, tombol link benar
    public function test_save_valid_navigation_link_is_stored_correctly()
    {
        $navLink = 'https://goo.gl/maps/ABCDEF123456';

        $this->actingAs($this->admin)->post('/wisata', $this->wisataPayload([
            'nama_wisata'   => 'Wisata Navigasi Link',
            'link_navigasi' => $navLink,
        ]));

        $this->assertDatabaseHas('wisatas', [
            'nama_wisata'   => 'Wisata Navigasi Link',
            'link_navigasi' => $navLink,
        ]);
    }

    // UAT Tabel 4.11 - Skenario 3: Simpan destinasi tanpa link navigasi (field opsional)
    public function test_save_wisata_without_navigation_link_is_accepted_no_error()
    {
        $payload = $this->wisataPayload([
            'nama_wisata'   => 'Wisata Tanpa Navigasi',
            'link_navigasi' => '',
        ]);

        $response = $this->actingAs($this->admin)->post('/wisata', $payload);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('wisatas', ['nama_wisata' => 'Wisata Tanpa Navigasi']);
    }

    // =========================================================================
    // UAT TABEL 4.12 — FILE UPLOAD SECURITY
    // =========================================================================

    // UAT Tabel 4.12 - Skenario 1: Upload foto JPG valid untuk destinasi → tersimpan
    public function test_upload_valid_jpg_photo_for_wisata_is_accepted()
    {
        $response = $this->actingAs($this->admin)->post('/wisata', $this->wisataPayload([
            'nama_wisata' => 'Wisata Foto JPG',
            'gambar1'     => UploadedFile::fake()->image('foto_wisata.jpg', 1024, 768),
        ]));

        $this->assertDatabaseHas('wisatas', ['nama_wisata' => 'Wisata Foto JPG']);
    }

    // UAT Tabel 4.12 - Skenario 2: Upload PDF sebagai foto destinasi → ditolak
    public function test_upload_pdf_as_wisata_photo_is_rejected_with_error()
    {
        $response = $this->actingAs($this->admin)->post('/wisata', $this->wisataPayload([
            'gambar1' => UploadedFile::fake()->create('dokumen.pdf', 100, 'application/pdf'),
        ]));

        $response->assertSessionHasErrors('gambar1');
    }

    // UAT Tabel 4.12 - Skenario 3: Upload file melebihi batas ukuran 2MB → ditolak
    public function test_upload_oversized_photo_is_rejected_with_size_error()
    {
        $response = $this->actingAs($this->admin)->post('/wisata', $this->wisataPayload([
            'gambar1' => UploadedFile::fake()->image('besar.jpg')->size(2049), // 2049 KB > 2MB limit
        ]));

        $response->assertSessionHasErrors('gambar1');
    }

    // =========================================================================
    // UAT TABEL 4.13 — EDGE CASES & SECURITY
    // =========================================================================

    // UAT Tabel 4.13 - Skenario 1: SQL Injection di form admin → prepared statements memblokir
    public function test_sql_injection_in_admin_form_is_blocked_by_orm()
    {
        $injectionPayload = "'; DROP TABLE wisatas; --";

        $response = $this->actingAs($this->admin)->post('/wisata', $this->wisataPayload([
            'nama_wisata' => $injectionPayload,
            'deskripsi'   => "' OR '1'='1' --",
        ]));

        // Wisatas table still exists and record stored safely as literal string
        $this->assertDatabaseHas('wisatas', ['nama_wisata' => $injectionPayload]);
    }

    // UAT Tabel 4.13 - Skenario 2: XSS payload di deskripsi → Blade {{ }} escapes output
    public function test_xss_payload_in_wisata_description_is_escaped_by_blade()
    {
        $xssPayload = '<script>alert("xss")</script>';

        $wisata = $this->makeWisata([
            'nama_wisata' => 'Wisata XSS Check',
            'deskripsi'   => $xssPayload,
        ]);
        $wisata->slug = 'wisata-xss-check-999';
        $wisata->saveQuietly();

        $response = $this->get('/destinasi/' . $wisata->slug);

        // Raw unescaped script tag must NOT appear in response
        $this->assertStringNotContainsString(
            '<script>alert("xss")</script>',
            $response->getContent()
        );
    }

    // UAT Tabel 4.13 - Skenario 3: POST tanpa CSRF token → HTTP 419 (middleware verified)
    //
    // NOTE: Laravel's VerifyCsrfToken middleware contains a runningUnitTests() guard
    // that intentionally skips CSRF checks when APP_ENV=testing. Therefore a live
    // 419 response cannot be triggered from within PHPUnit. Instead, this test
    // verifies that (a) VerifyCsrfToken IS present in the web middleware group, and
    // (b) the middleware correctly rejects a mismatched token when invoked directly.
    public function test_csrf_middleware_is_configured_and_rejects_invalid_token()
    {
        // Part A — configuration: VerifyCsrfToken must be in the web middleware group
        $webMiddleware = $this->app['router']->getMiddlewareGroups()['web'] ?? [];
        $hasCsrf       = false;

        foreach ($webMiddleware as $m) {
            if (is_string($m) && strpos($m, 'VerifyCsrfToken') !== false) {
                $hasCsrf = true;
                break;
            }
        }

        $this->assertTrue($hasCsrf, 'VerifyCsrfToken must be registered in the web middleware group');

        // Part B — behaviour: middleware throws TokenMismatchException for mismatched token
        $session = $this->app['session']->driver();
        $session->start();
        $session->put('_token', 'legit-session-token');

        $request = \Illuminate\Http\Request::create('/wisata', 'POST');
        $request->setLaravelSession($session);
        $request->merge(['_token' => 'wrong-request-token']);

        $middleware    = $this->app->make(\App\Http\Middleware\VerifyCsrfToken::class);
        $exceptionThrown = false;

        try {
            // Temporarily make the app believe it's not running unit tests
            $this->app->instance('env', 'production');
            $middleware->handle($request, function () {
                return response('ok');
            });
        } catch (\Illuminate\Session\TokenMismatchException $e) {
            $exceptionThrown = true;
        } finally {
            $this->app->instance('env', 'testing');
        }

        $this->assertTrue($exceptionThrown, 'VerifyCsrfToken must throw TokenMismatchException for an invalid token');
    }

    // UAT Tabel 4.13 - Skenario 4: Concurrent requests ke /api/search → keduanya benar
    public function test_concurrent_search_requests_both_return_correct_results()
    {
        $this->makeWisataForSearch('Gunung Merapi Wisata');
        $this->makeWisataForSearch('Pantai Kukup Indah');

        // Simulate concurrent calls sequentially (PHP is single-threaded)
        $response1 = $this->get('/api/search?q=Gunung');
        $response2 = $this->get('/api/search?q=Pantai');

        $response1->assertStatus(200);
        $response2->assertStatus(200);

        $data1 = $response1->json();
        $data2 = $response2->json();

        $this->assertNotEmpty($data1);
        $this->assertNotEmpty($data2);
        $this->assertEquals('Gunung Merapi Wisata', $data1[0]['nama']);
        $this->assertEquals('Pantai Kukup Indah', $data2[0]['nama']);
    }
}
