<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookRatingTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'book_rating';

    /**
     * Run the migrations.
     * @table book_rating
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('rating_id');
            $table->integer('book_id')->nullable()->default(null);
            $table->integer('user_id')->nullable()->default(null);
            $table->double('rating')->nullable()->default(null);
            $table->text('review')->nullable()->default(null);
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
