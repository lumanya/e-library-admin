<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailTemplateTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'mail_template';

    /**
     * Run the migrations.
     * @table mail_template
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('mail_id');
            $table->integer('mail_template_id')->nullable()->default(null);
            $table->string('mail_subject')->nullable()->default(null);
            $table->text('mail_body')->nullable()->default(null);
            $table->string('mail_footer')->nullable()->default(null);
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
