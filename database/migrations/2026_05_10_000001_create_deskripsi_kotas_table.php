<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeskripsiKotasTable extends Migration
{
    public function up()
    {
        Schema::create('deskripsi_kotas', function (Blueprint $table) {
            $table->id();
            $table->string('gambar')->nullable();
            $table->text('teks');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('deskripsi_kotas');
    }
}
