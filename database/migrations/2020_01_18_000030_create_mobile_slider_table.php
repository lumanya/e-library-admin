<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMobileSliderTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'mobile_slider';

    /**
     * Run the migrations.
     * @table mobile_slider
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('mobile_slider_id');
            $table->string('title', 50)->nullable()->default(null);
            $table->string('slide_image')->nullable()->default(null);
            $table->string('link')->nullable()->default(null);
            $table->softDeletes();
            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists($this->tableName);
     }
}
