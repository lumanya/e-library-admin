<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthorTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'author';

    /**
     * Run the migrations.
     * @table author
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('author_id');
            $table->string('name', 100)->nullable()->default(null);
            $table->string('education', 25)->nullable()->default(null);
            $table->text('description')->nullable()->default(null);
            $table->string('designation', 25)->nullable()->default(null);
            $table->string('mobile', 25)->nullable()->default(null);
            $table->string('email', 100)->nullable()->default(null);
            $table->string('address')->nullable();
            $table->string('image')->nullable()->default(null);
            $table->string('status')->nullable()->default('1');
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
