<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderMedicinesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_medicines', function (Blueprint $table) {
			$table->increments('id');

			$table->integer('order_id');

			$table->string('medicine_name');
			$table->string('medicine_type');
			$table->string('medicine_unit');
			$table->integer('medicine_qty');
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
		Schema::drop('order_medicines');
	}
}
