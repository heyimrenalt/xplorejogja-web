<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPopulerToWisatasTable extends Migration
{
    public function up()
    {
        Schema::table('wisatas', function (Blueprint $table) {
            $table->boolean('is_populer')->default(false)->after('link_sumber');
            $table->integer('urutan_populer')->nullable()->after('is_populer');
        });
    }

    public function down()
    {
        Schema::table('wisatas', function (Blueprint $table) {
            $table->dropColumn(['is_populer', 'urutan_populer']);
        });
    }
}
