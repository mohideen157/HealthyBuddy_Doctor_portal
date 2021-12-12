<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoctorDocumentsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('doctor_documents', function (Blueprint $table) {
			$table->increments('id');

			$table->integer('doctor_id');

			$table->string('medical_degree')->nullable();
			$table->boolean('medical_degree_verified')->default(0);
			$table->string('medical_degree_reject_reason')->nullable();

			$table->string('government_id')->nullable();
			$table->boolean('government_id_verified')->default(0);
			$table->string('government_id_reject_reason')->nullable();

			$table->string('medical_registration_certificate')->nullable();
			$table->boolean('medical_registration_certificate_verified')->default(0);
			$table->string('medical_registration_certificate_reject_reason')->nullable();

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
		Schema::drop('doctor_documents');
	}
}
