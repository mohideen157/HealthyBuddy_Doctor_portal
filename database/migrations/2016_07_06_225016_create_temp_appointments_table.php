<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTempAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temp_appointment_bookings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('doctor_id');
            $table->integer('user_id');
            $table->integer('slot_id');
            $table->string('consultation_type');
            $table->integer('consultation_price');
            $table->integer('status'); // 0 => Temp, 1 => Payment Pending
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
        Schema::drop('temp_appointment_bookings');
    }
}
