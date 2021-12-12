<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoctorLanguageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_languages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('doctor_id');
            $table->integer('language_id');
            $table->boolean('mother_tongue');
            $table->timestamps();

            // $table->foreign('doctor_id')->references('id')->on('users');
            // $table->foreign('language_id')->references('id')->on('languages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('doctor_languages');
    }
}
