<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoctorSignaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_signature', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('doctor_id');
            $table->string('image_type');
            $table->binary('image');
            $table->string('image_size');
            $table->string('image_name');
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
        Schema::drop('doctor_signature');
    }
}
