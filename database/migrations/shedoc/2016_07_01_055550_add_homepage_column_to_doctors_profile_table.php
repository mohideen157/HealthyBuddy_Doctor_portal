<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHomepageColumnToDoctorsProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doctor_profile', function ($table) {
            $table->boolean('show_on_homepage')->after('slot_repeat_all_days')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('doctor_profile', function ($table) {
            $table->dropColumn('show_on_homepage');
        });
    }
}
