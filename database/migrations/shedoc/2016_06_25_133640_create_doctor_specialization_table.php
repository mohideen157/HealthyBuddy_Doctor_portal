<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoctorSpecializationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_specialization', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('doctor_id');
            $table->string('specialization');
            $table->timestamps();

            // $table->foreign('doctor_id')->references('id')->on('users');
            // $table->foreign('specialization_id')->references('id')->on('doc_specialization');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('doctor_specialization');
    }
}
