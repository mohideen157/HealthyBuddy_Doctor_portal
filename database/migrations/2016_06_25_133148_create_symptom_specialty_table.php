<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSymptomSpecialtyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('symptom_specialty', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('symptom_id');
            $table->integer('specialty_id');
            $table->timestamps();

            // $table->foreign('symptom_id')->references('id')->on('symptoms');
            // $table->foreign('specialty_id')->references('id')->on('specialty');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('symptom_specialty');
    }
}
