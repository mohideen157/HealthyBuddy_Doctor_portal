<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVerificationColumnsToUsersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function ($table) {
			$table->boolean('email_verified')->after('email')->default(0);
			$table->boolean('mobile_verified')->after('mobile_no')->default(0);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function ($table) {
			$table->dropColumn('email_verified');
			$table->dropColumn('mobile_verified');
		});
	}
}
