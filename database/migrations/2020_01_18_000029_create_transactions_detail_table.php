<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsDetailTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'transactions_detail';

    /**
     * Run the migrations.
     * @table transactions_detail
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('transaction_detail_id');
            $table->integer('transaction_id');
            $table->integer('book_id');
            $table->integer('user_id');
            $table->double('price')->nullable()->default('0');
            $table->double('discount')->nullable()->default('0');
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
