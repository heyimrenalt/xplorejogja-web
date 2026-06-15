<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPerformanceIndexes extends Migration
{
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->index('parent_id', 'idx_categories_parent_id');
        });

        Schema::table('ulasans', function (Blueprint $table) {
            $table->index(['wisata_id', 'status'], 'idx_ulasans_wisata_status');
        });

        Schema::table('wisatas', function (Blueprint $table) {
            $table->index('tampil_home', 'idx_wisatas_tampil_home');
            $table->index('is_populer', 'idx_wisatas_is_populer');
        });
    }

    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex('idx_categories_parent_id');
        });

        Schema::table('ulasans', function (Blueprint $table) {
            $table->dropIndex('idx_ulasans_wisata_status');
        });

        Schema::table('wisatas', function (Blueprint $table) {
            $table->dropIndex('idx_wisatas_tampil_home');
            $table->dropIndex('idx_wisatas_is_populer');
        });
    }
}
