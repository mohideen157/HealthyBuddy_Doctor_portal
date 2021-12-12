<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCancelRescheduleCountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cancel_reschedule_count', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->unique();

            $table->integer('cancel_count')->default(0);
            $table->integer('reschedule_count')->default(0);

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
        Schema::drop('cancel_reschedule_count');
    }
}
