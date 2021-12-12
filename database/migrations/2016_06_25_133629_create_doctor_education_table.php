<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoctorEducationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_education', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('doctor_id');
            $table->string('degree');
            $table->integer('year');
            $table->string('college_name');
            $table->timestamps();

            // $table->foreign('doctor_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('doctor_education');
    }
}
