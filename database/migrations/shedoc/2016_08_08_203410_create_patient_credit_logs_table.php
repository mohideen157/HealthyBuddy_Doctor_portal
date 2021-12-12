<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientCreditLogsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('patient_credit_logs', function (Blueprint $table) {
			$table->increments('id');

			$table->integer('patient_id');

			$table->string('remarks');
			$table->string('type'); // Credit or Debit
			$table->integer('delta');

			$table->dateTime('transaction_date');

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
		Schema::drop('patient_credit_logs');
	}
}
