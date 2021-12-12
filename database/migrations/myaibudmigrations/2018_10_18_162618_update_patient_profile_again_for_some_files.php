<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePatientProfileAgainForSomeFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('patient_profile', function (Blueprint $table) {
            $table->integer('weight_kg')->after('weight')->nullable();
            $table->integer('weight_pounds')->after('weight_kg')->nullable();
            $table->string('occupation')->after('weight_pounds')->nullable();
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
