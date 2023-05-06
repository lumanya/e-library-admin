<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'transactions';

    /**
     * Run the migrations.
     * @table transactions
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('transaction_id');
            $table->integer('user_id');
            $table->dateTime('datetime')->nullable()->default(null);
            $table->double('discount')->nullable()->default('0');
            $table->double('total_amount')->nullable()->default('0');
            $table->integer('payment_type');
            $table->string('txn_id', 100)->nullable()->default(null);
            $table->string('payment_status', 20)->nullable()->default(null);
            $table->text('other_transaction_detail')->nullable()->default(null);
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
