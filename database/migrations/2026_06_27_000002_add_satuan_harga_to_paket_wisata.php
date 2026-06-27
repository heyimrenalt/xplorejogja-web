<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSatuanHargaToPaketWisata extends Migration
{
    public function up()
    {
        Schema::table('paket_wisata', function (Blueprint $table) {
            $table->string('satuan_harga', 10)->default('orang')->after('harga');
            $table->text('keterangan_harga')->nullable()->after('satuan_harga');
        });
    }

    public function down()
    {
        Schema::table('paket_wisata', function (Blueprint $table) {
            $table->dropColumn(['satuan_harga', 'keterangan_harga']);
        });
    }
}
