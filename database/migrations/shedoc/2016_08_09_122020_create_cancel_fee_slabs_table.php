<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCancelFeeSlabsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cancel_fee_slabs', function (Blueprint $table) {
			$table->increments('id');

			$table->integer('from')->unique();
			$table->integer('to')->unique();

			$table->integer('fee');

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
		Schema::drop('cancel_fee_slabs');
	}
}
