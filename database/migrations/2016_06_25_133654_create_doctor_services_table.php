<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoctorServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_services', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('doctor_id');
            $table->string('service');
            $table->timestamps();

            // $table->foreign('doctor_id')->references('id')->on('users');
            // $table->foreign('service_id')->references('id')->on('doc_services');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('doctor_services');
    }
}
