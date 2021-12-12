<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AdminSettingsSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$insert_value = array(
			array(
				'key' => 'password_reset_code_expiry',
				'description' => 'Password reset code expiry',
				'value' => '60'
			),
			array(
				'key' => 'verification_code_expiry',
				'description' => 'Email and Mobile Verification Code Expiry',
				'value' => '60'
			),
			array(
				'key' => 'advance_booking_limit',
				'description' => 'Time Slots that are 15 min away will not be shown for booking',
				'value' => '15'
			),
			array(
				'key' => 'temp_booking_expiry',
				'description' => 'Temporary booking created will be invalid after the set time',
				'value' => '15'
			),
			array(
				'key' => 'payment_pending_booking_expiry',
				'description' => 'Temporary booking will be invalid if payment is not done within this time',
				'value' => '10'
			),
			array(
				'key' => 'booking_buffer',
				'description' => 'When the request for temp booking comes in if only this minutes is left, the booking will be rejected',
				'value' => '5'
			),
			array(
				'key' => 'booking_cancel_buffer',
				'description' => 'Booking cannot be cancelled if only this minutes are left',
				'value' => '60'
			),
			array(
				'key' => 'shedct_fee',
				'description' => 'Percentage fee for she doctr',
				'value' => '5'
			),
			array(
				'key' => 'upload_file_count_limit',
				'description' => 'Max number of uploads allowed for patient in my uploads',
				'value' => '10'
			),
			array(
				'key' => 'max_delivery_address_count',
				'description' => 'Max number of delivery addresses patient can save',
				'value' => '2'
			),
			array(
				'key' => 'free_cancel_allowed',
				'description' => 'Maximum number of times a patient can cancel an appointment for free',
				'value' => '1'
			),
			array(
				'key' => 'free_reschedule_allowed',
				'description' => 'Maximum number of times a patient can reschedule an appointment for free',
				'value' => '1'
			)
		);

		foreach ($insert_value as $s) {
			DB::table('admin_settings')->insert([
				'key' => $s['key'],
				'description' => $s['description'],
				'value' => $s['value'],
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
			]);
		}
	}
}
