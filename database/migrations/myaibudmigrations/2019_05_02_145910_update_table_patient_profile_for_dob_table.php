<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTablePatientProfileForDobTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('patient_profile', function (Blueprint $table) {
            $table->dropColumn('age');
            $table->date('dob')->after('occupation')->nullable();
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
            $table->dropColumn('dob');
            $table->integer('age')->after('occupation')->nullable();
        });
    }
}
