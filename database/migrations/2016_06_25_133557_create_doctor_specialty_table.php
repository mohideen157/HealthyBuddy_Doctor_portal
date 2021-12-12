<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoctorSpecialtyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_specialty', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('doctor_id')->unique();
            $table->string('specialty_id');
            $table->timestamps();

            // $table->foreign('doctor_id')->references('id')->on('users');
            // $table->foreign('specialty_id')->references('id')->on('specialty');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('doctor_specialty');
    }
}
