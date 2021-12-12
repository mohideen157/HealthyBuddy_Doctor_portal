<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('histories', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('afib')->nullable();
            $table->string('arrhythmia')->nullable();
            $table->string('artrialage')->nullable();
            $table->string('bp')->nullable();
            $table->string('hr')->nullable();
            $table->string('hrvlevel')->nullable();
            $table->string('rpwv')->nullable();
            $table->string('synched')->unique();
            $table->string('date')->nullable();
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
        Schema::dropIfExists('histories');
    }
}
