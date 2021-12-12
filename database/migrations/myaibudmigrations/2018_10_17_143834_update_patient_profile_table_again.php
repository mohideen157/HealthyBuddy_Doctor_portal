<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePatientProfileTableAgain extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('patient_profile', function (Blueprint $table) {
            $table->integer('age')->after('weight')->nullable();
            $table->string('national_id')->after('age')->nullable();
            $table->string('app_image')->after('national_id')->nullable();
            $table->string('web_image')->after('app_image')->nullable();
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
