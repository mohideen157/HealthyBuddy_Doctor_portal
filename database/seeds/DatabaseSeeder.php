<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserRolesTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(BankTableSeeder::class);
        $this->call(AdminSettingsSeeder::class);
        $this->call(DoctorCommissionSlabsSeeder::class);
        $this->call(AllergiesTableSeeder::class);
        $this->call(MedicationsTableSeeder::class);
        $this->call(DiseasesTableSeeder::class);
    }
}
