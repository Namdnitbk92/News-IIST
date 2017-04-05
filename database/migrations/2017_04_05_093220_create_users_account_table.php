<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_account', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id');
            $table->string('account_name')->unique();
            $table->string('password');
            $table->string('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_account', function (Blueprint $table) {
            Schema::dropIfExists('users_account');
        });
    }
}
