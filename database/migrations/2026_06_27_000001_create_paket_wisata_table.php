<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaketWisataTable extends Migration
{
    public function up()
    {
        Schema::create('paket_wisata', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wisata_id')->constrained('wisatas')->onDelete('cascade');
            $table->string('nama_paket');
            $table->string('gambar');
            $table->string('lokasi')->nullable();
            $table->string('durasi', 100)->nullable();
            $table->string('transport')->nullable();
            $table->string('makan', 100)->nullable();
            $table->unsignedInteger('harga')->nullable();
            $table->text('destinasi_kunjungi')->nullable();
            $table->text('termasuk')->nullable();
            $table->text('tidak_termasuk')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('paket_wisata');
    }
}
