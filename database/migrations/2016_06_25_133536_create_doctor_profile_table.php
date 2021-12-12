<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoctorProfileTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('doctor_profile', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('doctor_id');
			$table->string('prefix');
			$table->string('gender');
			$table->string('registration_no');
			$table->integer('experience');
			$table->longText('self_details');
			$table->boolean('slot_repeat_all_days');
			$table->boolean('is_verified')->default(0);
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
		Schema::drop('doctor_profile');
	}
}
