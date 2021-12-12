<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoctorAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_appointments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('shdct_appt_id')->unique();
            $table->integer('doctor_id');
            $table->integer('patient_id');
            $table->date('date');
            $table->time('time_start');
            $table->string('consultation_type');
            $table->integer('consultation_price');
            $table->string('transaction_id');
            $table->boolean('reminder_sent');
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
        Schema::drop('doctor_appointments');
    }
}
