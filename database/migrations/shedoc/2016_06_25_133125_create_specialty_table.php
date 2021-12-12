<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpecialtyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('specialty', function (Blueprint $table) {
            $table->increments('id');
            $table->string('specialty')->unique();
            $table->string('image');
            $table->string('details');
            $table->integer('parent')->default(0); // Specialty ID Heirarchical Relation
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
        Schema::drop('specialty');
    }
}
