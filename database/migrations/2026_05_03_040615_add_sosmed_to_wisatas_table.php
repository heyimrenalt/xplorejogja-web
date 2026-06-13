<?php
// Buat file baru: database/migrations/2026_05_03_000001_add_sosmed_to_wisatas_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSosmedToWisatasTable extends Migration
{
    public function up()
    {
        Schema::table('wisatas', function (Blueprint $table) {
            $table->string('facebook')->nullable()->after('whatsapp');
            $table->string('twitter')->nullable()->after('facebook');
            $table->string('tiktok')->nullable()->after('twitter');
            $table->string('youtube')->nullable()->after('tiktok');
            $table->text('ulasan_raw')->nullable()->after('youtube');
        });
    }

    public function down()
    {
        Schema::table('wisatas', function (Blueprint $table) {
            $table->dropColumn(['facebook', 'twitter', 'tiktok', 'youtube', 'ulasan_raw']);
        });
    }
}