<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoctorLedgerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_ledger', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('doctor_id');
            $table->integer('appointment_id');

            $table->integer('shedoctr_fees');
            $table->integer('doctor_fees');

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
        Schema::drop('doctor_ledger');
    }
}
