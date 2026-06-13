<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLinkSumberToWisatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wisatas', function (Blueprint $table) {
            $table->string('link_sumber')->nullable()->after('link_navigasi');
        });
    }

    public function down()
    {
        Schema::table('wisatas', function (Blueprint $table) {
            $table->dropColumn('link_sumber');
        });
    }
}
