<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class BankTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bank_arr = array(  'Allahabad Bank',
							'Andhra Bank',
							'Axis Bank',
							'Bank of Bahrain and Kuwait',
							'Bank of Baroda - Corporate Banking',
							'Bank of Baroda - Retail Banking',
							'Bank of India',
							'Bank of Maharashtra',
							'Canara Bank',
							'Central Bank of India',
							'City Union Bank',
							'Corporation Bank',
							'Deutsche Bank',
							'Development Credit Bank',
							'Dhanlaxmi Bank',
							'Federal Bank',
							'HDFC Bank',
							'ICICI Bank',
							'IDBI Bank',
							'Indian Bank',
							'Indian Overseas Bank',
							'IndusInd Bank',
							'ING Vysya Bank',
							'Jammu and Kashmir Bank',
							'Karnataka Bank Ltd',
							'Karur Vysya Bank',
							'Kotak Bank',
							'Laxmi Vilas Bank',
							'Oriental Bank of Commerce',
							'Punjab National Bank - Corporate Banking',
							'Punjab National Bank - Retail Banking',
							'Punjab &amp; Sind Bank',
							'Shamrao Vitthal Co-operative Bank',
							'South Indian Bank',
							'State Bank of Bikaner &amp; Jaipur',
							'State Bank of Hyderabad',
							'State Bank of India',
							'State Bank of Mysore',
							'State Bank of Patiala',
							'State Bank of Travancore',
							'Syndicate Bank',
							'Tamilnad Mercantile Bank Ltd.',
							'UCO Bank',
							'Union Bank of India',
							'United Bank of India',
							'Vijaya Bank',
							'Yes Bank Ltd'
				);

			foreach ($bank_arr as $bank) {
				DB::table('banks')->insert([
		            'bank' => $bank,
		        	'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
		        	'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
		    	]);
			}
    }
}
