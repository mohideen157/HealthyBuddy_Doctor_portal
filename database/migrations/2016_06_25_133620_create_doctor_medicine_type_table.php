<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoctorMedicineTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_medicine_type', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('doctor_id');
            $table->integer('medicine_type_id');
            $table->timestamps();

            // $table->foreign('doctor_id')->references('id')->on('users');
            // $table->foreign('medicine_type_id')->references('id')->on('medicine_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('doctor_medicine_type');
    }
}
