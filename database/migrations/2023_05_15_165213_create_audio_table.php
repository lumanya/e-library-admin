<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAudioTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'audio';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('audio_id');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->text('keywords')->nullable()->default(null);
            $table->string('duration')->nullable();
            $table->enum('type', ['MP3', 'MP4', 'WAV', 'OGG', 'AAC'])->default('MP3');
            $table->string('cover_image')->nullable()->default(null);
            $table->string('audio_file_path')->nullable()->default(null);
            $table->integer('category_id')->nullable()->default(null);
            $table->integer('subcategory_id')->nullable()->default(null);
            $table->integer('author_id')->nullable()->default(null);
            $table->integer('like_count')->nullable()->default(0);
            $table->integer('view_count')->nullable()->default(0);
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
