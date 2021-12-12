<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CratePatientHealtProfileTableAgain extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_health_profile', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('patient_id')->unsigned()->index();
            $table->string('parent_key');
            $table->string('child_key')->nullable();
            $table->string('value')->nullable();
            $table->string('unit')->nullable();
            $table->longText('extra_info')->nullable();

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
        //
    }
}
