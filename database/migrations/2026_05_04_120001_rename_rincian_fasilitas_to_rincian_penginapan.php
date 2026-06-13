<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class RenameRincianFasilitasToRincianPenginapan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (DB::getDriverName() === 'sqlite') {
            // SQLite does not support CHANGE — drop old column and add new one
            Schema::table('wisatas', function (Blueprint $table) {
                $table->dropColumn('rincian_fasilitas');
            });
            Schema::table('wisatas', function (Blueprint $table) {
                $table->text('rincian_penginapan')->nullable();
            });
        } else {
            DB::statement('ALTER TABLE wisatas CHANGE rincian_fasilitas rincian_penginapan LONGTEXT NULL');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (DB::getDriverName() === 'sqlite') {
            Schema::table('wisatas', function (Blueprint $table) {
                $table->dropColumn('rincian_penginapan');
            });
            Schema::table('wisatas', function (Blueprint $table) {
                $table->text('rincian_fasilitas')->nullable();
            });
        } else {
            DB::statement('ALTER TABLE wisatas CHANGE rincian_penginapan rincian_fasilitas LONGTEXT NULL');
        }
    }
}
