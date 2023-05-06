<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateauthAccessTokensTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'auth_access_tokens';

    /**
     * Run the migrations.
     * @table oauth_access_tokens
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->nullable()->default(null);
            $table->unsignedInteger('client_id');
            $table->string('name')->nullable()->default(null);
            $table->text('scopes')->nullable()->default(null);
            $table->tinyInteger('revoked');
            $table->dateTime('expires_at')->nullable()->default(null);

            $table->index(["user_id"], 'auth_access_tokens_user_id_index');
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
