<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('shdct_user_id')->unique();
            $table->integer('user_role');
            $table->string('name');
            $table->string('email');
            $table->string('mobile_no');
            $table->string('password');
            $table->boolean('online')->default(0);
            $table->boolean('active')->default(1);
            $table->integer('referred_by')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
