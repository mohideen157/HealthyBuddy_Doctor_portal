<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedicalReportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_report', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('patient_id')->unsigned()->index();
            $table->integer('heart_rate');
            $table->string('bp');
            $table->string('sugar_fasting');
            $table->string('sugar_non_fasting');
            $table->string('triglycerides');
            $table->string('hdl_cholesterol');
            $table->string('ldl_cholesterol');
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
        Schema::dropIfExists('medical_report');
    }
}
