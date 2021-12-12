<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_profile', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedinteger('patient_id');
            $table->string('gender');
            $table->integer('height_feet');
            $table->integer('height_inch');
            $table->string('blood_group');
            $table->integer('weight');
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
        Schema::drop('patient_profile');
    }
}
