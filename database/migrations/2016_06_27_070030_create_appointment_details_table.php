<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointmentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointment_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('appointment_id');
            $table->boolean('appointment_type'); // 0 => Temp, 1 => Fixed
            $table->string('patient_type'); // User or Another Person
            $table->string('patient_name');
            $table->string('patient_gender');
            $table->string('patient_height_feet');
            $table->string('patient_height_inches');
            $table->string('patient_blood_group');
            $table->string('patient_weight');
            $table->string('patient_medications')->nullable();
            $table->string('patient_allergies')->nullable();
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
        Schema::drop('appointment_details');
    }
}
