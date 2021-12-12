<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoctorAwardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_awards', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('doctor_id');
            $table->string('name');
            $table->integer('year');
            $table->string('details');
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
        Schema::drop('doctor_awards');
    }
}
