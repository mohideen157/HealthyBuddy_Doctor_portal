<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointmentPrescriptionLabTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointment_prescription_lab_tests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('prescription_id');
            $table->string('lab_test');
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
        Schema::drop('appointment_prescription_lab_tests');
    }
}
