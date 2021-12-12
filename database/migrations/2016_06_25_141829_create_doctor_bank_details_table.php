<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoctorBankDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_bank_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('doctor_id');
            $table->string('bank_name');
            $table->string('account_type');
            $table->string('ifsc');
            $table->longText('account_no');
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
        Schema::drop('doctor_bank_details');
    }
}
