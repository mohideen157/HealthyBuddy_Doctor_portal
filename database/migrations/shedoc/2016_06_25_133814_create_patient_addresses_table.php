<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('patient_id');
            $table->string('address_line_1');
            $table->string('address_line_2')->nullable();
            $table->string('state');
            $table->string('city');
            $table->string('pincode');
            $table->boolean('default');
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
        Schema::drop('patient_addresses');
    }
}
