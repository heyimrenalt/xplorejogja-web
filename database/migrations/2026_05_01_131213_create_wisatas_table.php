<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWisatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    // 1. Tabel Kategori (Induk & Anak)
    Schema::create('categories', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // Contoh: Wisata Alam, Wisata Pantai
        $table->unsignedBigInteger('parent_id')->nullable(); // Untuk kategori bertingkat
        $table->timestamps();
    });
    Schema::create('wisatas', function (Blueprint $table) {
        $table->id();
        $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
        $table->string('nama_wisata');
        $table->string('gambar1'); // Tambahkan angka 1
        $table->string('gambar2')->nullable(); // Tambahkan ini
        $table->string('gambar3')->nullable(); // Tambahkan ini
        $table->text('deskripsi');
        $table->string('jam_buka')->nullable();
        $table->string('jam_tutup')->nullable();
        $table->string('harga_tiket')->nullable();
        $table->text('fasilitas')->nullable();
        $table->text('biaya_parkir')->nullable(); // Untuk simpan: Mobil=5rb, Motor=2rb, dll
        $table->text('biaya_penginapan')->nullable(); // Untuk simpan: 100k-500k
        $table->text('info_tiket_tambahan')->nullable();
        $table->text('alamat_lengkap')->nullable();
        $table->text('link_gmaps')->nullable(); // Tambahkan ini
        $table->string('instagram')->nullable();
        $table->string('whatsapp')->nullable();
        $table->string('link_navigasi')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wisatas');
    }
}