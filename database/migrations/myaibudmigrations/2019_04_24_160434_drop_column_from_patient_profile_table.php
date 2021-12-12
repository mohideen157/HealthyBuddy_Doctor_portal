<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropColumnFromPatientProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('patient_profile', function (Blueprint $table) {
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
            $table->dropColumn('dob');
            $table->dropColumn('weight');
            $table->dropColumn('app_image');
            $table->dropColumn('web_image');
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
            $table->string('first_name');
            $table->string('last_name');
            $table->date('dob');
            $table->integer('weight');
            $table->string('app_image')->after('national_id')->nullable();
            $table->string('web_image')->after('app_image')->nullable();
        });
    }
}
