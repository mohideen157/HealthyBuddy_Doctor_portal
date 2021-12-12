<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointmentStatusTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('appointment_call_status', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('appointment_id');
			$table->integer('status'); // 0 => Fail, 1 => Success
			$table->string('reason');
			$table->string('details');
			$table->integer('user_id')->nullable();
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
		Schema::drop('appointment_call_status');
	}
}
