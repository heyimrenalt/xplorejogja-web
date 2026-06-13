<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUrutanSubkategoriToWisatasTable extends Migration
{
    public function up()
    {
        Schema::table('wisatas', function (Blueprint $table) {
            $table->integer('urutan_subkategori')->nullable()->after('urutan_populer');
        });
    }

    public function down()
    {
        Schema::table('wisatas', function (Blueprint $table) {
            $table->dropColumn('urutan_subkategori');
        });
    }
}
