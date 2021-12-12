<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class MedicationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //medications

        DB::table('medications')->insert(array(
            array(
                'name' => 'Augmentin 625 Duo Tablet',
                'slug' => 'augmentin 625 duo tablet',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Aciloc 150 Tablet',
                'slug' => 'aciloc 150 tablet',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Ecosprin-AV 75 Capsule',
                'slug' => 'ecosprin-av 75 tablet',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Telma-AM Tablet',
                'slug' => 'telma-am tablet',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Azithral 500 Tablet',
                'slug' => 'azithral 500 tablet',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Asthalin 100mcg Inhaler',
                'slug' => 'asthral 100mcg inhaler',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Amicin 500mg Injection',
                'slug' => 'aminic 500mg injection',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Dynapar AQ Injection 1ml',
                'slug' => 'dynapar aq injection 1ml',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Allegra 120mg Tablet',
                'slug' => 'allegra 120mg tablet',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Human Actrapid 40IU/ml Solution',
                'slug' => 'human actrapid 40iu/ml solution',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Axcer 90mg Tablet',
                'slug' => 'axcer 90mg tablet',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Amlokind-AT Tablet',
                'slug' => 'amlokind-at tablet',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Aciloc 300 Tablet',
                'slug' => 'aciloc 300 tablet',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Amaryl M 2mg Tablet PR',
                'slug' => 'amaryl m 2mg tablet pr',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),

            array(
                'name' => 'Allegra 180mg Tablet',
                'slug' => 'allegra 180mg tablet',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Abhayrab Injection',
                'slug' => 'abhayrab injection',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Vaxigrip Adult Injection',
                'slug' => 'Vaxigrip adult injection',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Aerocort Rotacap',
                'slug' => 'aerocort rotacap',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Azee 500 Tablet',
                'slug' => 'azee 500 tablet',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Alburel 20% Solution for Infusion',
                'slug' => 'alburel 20% solution for infusion',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Amaryl M 1mg Tablet PR',
                'slug' => 'amaryl m 1mg tablet pr',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Amlopre-AT Tablet',
                'slug' => 'amlopres-at tablet',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Aciloc RD 20 Tablet',
                'slug' => 'aciloc rd 20 tablet',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Telmikind-AM Tablet',
                'slug' => 'telmikind-am tablet',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Augmentin 625 Duo Tablet',
                'slug' => 'augmentin 625 duo tablet',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Aciloc 150 Tablet',
                'slug' => 'aciloc 150 tablet',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Ecosprin-AV 75 Capsule',
                'slug' => 'ecosprin-av 75 capsule',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Telma-AM Tablet',
                'slug' => 'telma-am tablet',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Azithral 500 Tablet',
                'slug' => 'azithral 500 tablet',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Asthalin 100mcg Inhaler',
                'slug' => 'asthalin 200mcg inhaler',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Amicin 500mg Injection',
                'slug' => 'amicin 500mg injection',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Dynapar AQ Injection 1ml',
                'slug' => 'dynapar aq injection 1ml',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Allegra 120mg Tablet',
                'slug' => 'Allegra 120mg Tablet',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Human Actrapid 40IU/ml Solution',
                'slug' => 'Human Actrapid 40IU/ml Solution',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Axcer 90mg Tablet',
                'slug' => 'Axcer 90mg Tablet',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Amlokind-AT Tablet',
                'slug' => 'Amlokind-AT Tablet',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Aciloc 300 Tablet',
                'slug' => 'Aciloc 300 Tablet',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Amaryl M 2mg Tablet PR',
                'slug' => 'Amaryl M 2mg Tablet PR',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Allegra 180mg Tablet',
                'slug' => 'Allegra 180mg Tablet',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Abhayrab Injection',
                'slug' => 'Abhayrab Injection',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Vaxigrip Adult Injection',
                'slug' => 'Vaxigrip Adult Injection',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'slug' => 'Aerocort Rotcap',
                'name' => 'Aerocort Rotcap',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Azee 500 Tablet',
                'slug' => 'Azee 500 Tablet',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Alburel 20% Solution for Infusion',
                'slug' => 'Alburel 20% Solution for Infusion',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Augmentin 625 Duo Tablet',
                'slug' => 'Augmentin 625 Duo Tablet',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Aciloc 150 Tablet',
                'slug' => 'Aciloc 150 Tablet',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Ecosprin-Av 75 Capsule',
                'slug' => 'Ecosprin-Av 75 Capsule',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Telma-AM Tablet',
                'slug' => 'Telma-AM Tablet',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Azithral 500 Tablet',
                'slug' => 'Azithral 500 Tablet',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Asthral 10mcg Inhaler',
                'slug' => 'Asthral 10mcg Inhaler',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Amicin 500mg Injection',
                'slug' => 'Amicin 500mg Injection',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Dynapar AQ Injection 1ml',
                'slug' => 'Dynapar AQ Injection 1ml',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Augmentin 625 Duo Tablet',
                'slug' => 'Augmentin 625 Duo Tablet',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            
        ));
    }
}
