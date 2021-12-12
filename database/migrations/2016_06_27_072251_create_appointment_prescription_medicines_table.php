<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointmentPrescriptionMedicinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointment_prescription_medicines', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('prescription_id');
            $table->string('medicine_name');
            $table->string('medicine_type');
            $table->string('morning')->nullable();
            $table->string('afternoon')->nullable();
            $table->string('evening')->nullable();
            $table->string('night')->nullable();
            $table->string('note')->nullable();
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
        Schema::drop('appointment_prescription_medicines');
    }
}
