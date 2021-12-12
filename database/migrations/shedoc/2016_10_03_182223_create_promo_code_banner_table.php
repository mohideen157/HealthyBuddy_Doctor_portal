<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromoCodeBannerTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('promo_code_banner', function (Blueprint $table) {
			$table->increments('id');

			$table->string('title');
			$table->longText('content')->nullable();
			$table->string('image')->nullable();

			$table->boolean('is_active');

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
		Schema::drop('promo_code_banner');
	}
}
