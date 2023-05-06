<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStaticDataTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'static_data';

    /**
     * Run the migrations.
     * @table static_data
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('type')->nullable()->default(null);
            $table->string('value')->nullable()->default(null);
            $table->string('label')->nullable()->default(null);
            $table->integer('status')->nullable()->default('1');
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
