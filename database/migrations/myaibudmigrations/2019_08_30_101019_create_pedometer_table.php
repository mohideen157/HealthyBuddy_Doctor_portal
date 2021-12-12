<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePedometerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedometer', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('patient_id')->unsigned()->index();
            $table->string('date');
            $table->string('steps');
            $table->timestamps();
            $table->foreign('patient_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pedometer');
    }
}
