<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('users')->insert([
            'shdct_user_id' => 'SHDCTADMIN',
        	'user_role' => 1,
        	'name' => 'Admin',
        	'email' => 'admin@gmail.com',
        	'mobile_no' => '1234567890',
        	'password' => bcrypt('123456'),
        	'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        	'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
    	]);
    }
}
