<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCallFeedbackTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('appointment_call_feedback', function (Blueprint $table) {
			$table->increments('id');

			$table->integer('appointment_id');
			$table->integer('user_id');

			$table->integer('rating');

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
		Schema::drop('appointment_call_feedback');
	}
}
