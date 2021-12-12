<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderLabTestsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_lab_tests', function (Blueprint $table) {
			$table->increments('id');

			$table->integer('order_id');

			$table->string('test_name');
			$table->date('test_date');
			$table->time('test_time');
			$table->string('note')->nullable();

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
		Schema::drop('order_lab_tests');
	}
}
