<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToAudioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('audio', function (Blueprint $table) {
            $table->tinyInteger('flag_top_sell')->nullable()->default('0')->after('view_count');
            $table->tinyInteger('flag_recommend')->nullable()->default('0')->after('flag_top_sell');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('audio', function (Blueprint $table) {
            $table->dropColumn('flag_top_sell');
            $table->dropColumn('flag_recommend');
        });
    }
}
