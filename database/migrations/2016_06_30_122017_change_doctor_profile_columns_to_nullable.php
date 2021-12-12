<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeDoctorProfileColumnsToNullable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('doctor_profile', function ($table) {
			$table->string('prefix', 10)->nullable()->change();
			$table->string('gender')->nullable()->change();
			$table->integer('experience')->default(0)->change();
			$table->longText('self_details')->nullable()->change();
			$table->integer('slot_repeat_all_days')->default(0)->change();
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
