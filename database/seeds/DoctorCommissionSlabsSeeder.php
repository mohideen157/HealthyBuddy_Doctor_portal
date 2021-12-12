<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DoctorCommissionSlabsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('doctor_commission_slabs')->insert([
			'key' => 'Default',
			'value' => 5,
			'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
			'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
		]);
    }
}
