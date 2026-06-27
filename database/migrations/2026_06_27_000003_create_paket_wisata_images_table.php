<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaketWisataImagesTable extends Migration
{
    public function up()
    {
        Schema::create('paket_wisata_images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('paket_wisata_id');
            $table->string('path_gambar');
            $table->unsignedInteger('urutan')->default(0);
            $table->timestamps();

            $table->foreign('paket_wisata_id')
                  ->references('id')->on('paket_wisata')
                  ->onDelete('cascade');
            $table->index('paket_wisata_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('paket_wisata_images');
    }
}
