<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSlugToWisatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('wisatas', function (Blueprint $table) {
        $table->string('slug')->unique()->nullable()->after('nama_wisata');
    });
}

public function down()
{
    Schema::table('wisatas', function (Blueprint $table) {
        $table->dropColumn('slug');
    });
}
}
