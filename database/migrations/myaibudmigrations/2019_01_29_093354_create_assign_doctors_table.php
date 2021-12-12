<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssignDoctorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assign_doctors', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('doctor_user_id');
            $table->unsignedInteger('tenant_user_id');
            $table->unsignedInteger('org_user_id');
            $table->timestamps();

            $table->foreign('doctor_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('tenant_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('org_user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assign_doctors');
    }
}
