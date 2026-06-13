<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePamfletsTable extends Migration
{
    public function up()
    {
        Schema::create('pamflets', function (Blueprint $table) {
            $table->id();
            $table->string('gambar');
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pamflets');
    }
}
