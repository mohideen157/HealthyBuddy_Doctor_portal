<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoctorConsultationPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_consultation_prices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('doctor_id');
            $table->integer('video_call_price');
            $table->boolean('video_call_available');
            $table->integer('voice_call_price');
            $table->boolean('voice_call_available');
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
        Schema::drop('doctor_consultation_prices');
    }
}
