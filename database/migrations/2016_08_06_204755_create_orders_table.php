<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');

            $table->string('shdct_id')->unique();

            $table->integer('user_id');

            $table->string('order_type'); // Lab Test or Medicine
            $table->text('address');
            $table->string('prescription');
            $table->string('status');

            $table->date('deliver_by')->nullable();
            $table->date('delivered_on')->nullable();

            $table->text('remarks')->nullable();

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
        Schema::drop('orders');
    }
}
