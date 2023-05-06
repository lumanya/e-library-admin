<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'book';

    /**
     * Run the migrations.
     * @table book
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('book_id');
            $table->integer('category_id')->nullable()->default(null);
            $table->integer('subcategory_id')->nullable()->default(null);
            $table->integer('author_id')->nullable()->default(null);
            $table->string('name', 100)->nullable()->default(null);
            $table->string('title', 100)->nullable()->default(null);
            $table->string('topic_cover')->nullable()->default(null);
            $table->text('description')->nullable()->default(null);
            $table->string('format', 50)->nullable()->default(null);
            $table->string('edition', 50)->nullable()->default(null);
            $table->text('keywords')->nullable()->default(null);
            $table->string('language', 100)->nullable()->default(null);
            $table->string('publisher', 50)->nullable()->default(null);
            $table->date('date_of_publication')->nullable()->default(null);
            $table->string('front_cover')->nullable()->default(null);
            $table->string('back_cover')->nullable()->default(null);
            $table->string('check_mark', 250)->nullable()->default(null);
            $table->string('file_path')->nullable()->default(null);
            $table->string('file_sample_path')->nullable()->default(null);
            $table->integer('page_count')->nullable()->default('0');
            $table->integer('in_stock')->nullable()->default('0');
            $table->double('price')->nullable()->default('0');
            $table->double('discount')->nullable()->default('0');
            $table->double('discounted_price')->nullable()->default('0');
            $table->double('rating')->nullable()->default('0');
            $table->string('status')->nullable()->default('1');
            $table->tinyInteger('flag_top_sell')->nullable()->default('0');
            $table->tinyInteger('flag_recommend')->nullable()->default('0');
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
