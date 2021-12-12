<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointmentCallLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointment_call_logs', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('appointment_id')->unique();
            $table->integer('user_id');

            $table->dateTime('start');
            $table->dateTime('end');

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
        Schema::drop('appointment_call_logs');
    }
}
