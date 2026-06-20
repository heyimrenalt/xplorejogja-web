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
    Schema::create('categories', function (Blueprint $table) {
        $table->id();
        $table->string('name'); 
        $table->unsignedBigInteger('parent_id')->nullable(); 
        $table->timestamps();
    });
    Schema::create('wisatas', function (Blueprint $table) {
        $table->id();
        $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
        $table->string('nama_wisata');
        $table->string('gambar1'); 
        $table->string('gambar2')->nullable(); 
        $table->string('gambar3')->nullable(); 
        $table->text('deskripsi');
        $table->string('jam_buka')->nullable();
        $table->string('jam_tutup')->nullable();
        $table->string('harga_tiket')->nullable();
        $table->text('fasilitas')->nullable();
        $table->text('biaya_parkir')->nullable(); 
        $table->text('biaya_penginapan')->nullable(); 
        $table->text('info_tiket_tambahan')->nullable();
        $table->text('alamat_lengkap')->nullable();
        $table->text('link_gmaps')->nullable(); 
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