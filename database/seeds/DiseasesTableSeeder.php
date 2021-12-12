<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DiseasesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('diseases')->insert(array(
            array(
                'name' => 'Tuberculosis',
                'slug' => 'Tuberculosis',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Diabetes mellitus',
                'slug' => 'Diabetes mellitus',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Hypertension',
                'slug' => 'Hypertension',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Ischemic heart disease',
                'slug' => 'Ischemic heart disease',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Malignancy',
                'slug' => 'Malignancy',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'mental illness',
                'slug' => 'mental illness',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Anemia',
                'slug' => 'Anemia',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Thrombocytopenia',
                'slug' => 'Thrombocytopenia',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Thlessemia',
                'slug' => 'Thlessemia',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Sickle cell anemia',
                'slug' => 'Sickle cell anemia',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Diarrhoea',
                'slug' => 'Diarrhoea',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Constipation',
                'slug' => 'Constipation',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Renal failure',
                'slug' => 'Renal failure',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Renal stone',
                'slug' => 'Renal stone',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Gall bladder stones',
                'slug' => 'Gall bladder stones',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Peptic ulcer',
                'slug' => 'Peptic ulcer',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'ulcerative colitis',
                'slug' => 'ulcerative colitis',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'GI bleed',
                'slug' => 'GI bleed',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Liver dysfunction',
                'slug' => 'Liver dysfunction',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Difficulty in swallowing',
                'slug' => 'Difficulty in swallowing',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'pancreatitis',
                'slug' => 'pancreatitis',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Gout',
                'slug' => 'Gout',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Arthritis',
                'slug' => 'Arthritis',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Glaucoma',
                'slug' => 'Glaucoma',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Epilepsy',
                'slug' => 'Epilepsy',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'stroke',
                'slug' => 'stroke',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'name' => 'asthma',
                'slug' => 'asthma',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
        ));
    }
}
