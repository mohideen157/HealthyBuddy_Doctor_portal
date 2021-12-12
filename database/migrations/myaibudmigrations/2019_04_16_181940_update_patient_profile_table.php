<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePatientProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('patient_profile', function (Blueprint $table) {
            $table->string('height_feet', 10)->change();
            $table->string('height_inch', 10)->change();
            $table->string('height_cm', 10)->change();
            $table->string('bmi', 10)->change();
            $table->string('bmi_score', 10)->change();
            $table->string('weight', 10)->change();
            $table->string('weight_kg', 10)->change();
            $table->string('weight_pounds', 10)->change();

            $table->foreign('patient_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('patient_profile', function (Blueprint $table) {
            $table->integer('height_feet')->change();
            $table->integer('height_inch')->change();
            $table->integer('height_cm')->change();
            $table->integer('bmi')->change();
            $table->integer('bmi_score')->change();
            $table->integer('weight')->change();
            $table->integer('weight_kg')->change();
            $table->integer('weight_pounds')->change();

            $table->dropForeign('patient_profile_patient_id_foreign');
        });
    }
}
