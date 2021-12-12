<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('payments', function (Blueprint $table) {
			$table->increments('id');

			$table->integer('doctor_id');

			$table->integer('amount');

			$table->string('transaction_id');
			$table->string('status');

			$table->text('remarks');

			$table->date('payment_date');

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
		Schema::drop('payments');
	}
}
