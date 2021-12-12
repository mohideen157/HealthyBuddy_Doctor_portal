<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('notifications', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id');

			$table->string('type')->nullable(); // New Appointment , New User ...
			$table->string('subject')->nullable();
			$table->text('body')->nullable();

			$table->integer('object_id')->nullable(); // Reference object id. New appointment -> appointment_id
			$table->string('object_type')->nullable(); // Model of Object. If new appointment -> Appointment

			$table->boolean('is_read')->default(0);

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
		Schema::drop('notifications');
	}
}
