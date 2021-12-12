<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\User;
use App\Model\Doctor\DoctorAppointments;
use App\Model\Appointment\AppointmentDetails;
use App\Model\Appointment\AppointmentCallStatus;
use App\Model\Doctor\DoctorProfile;

use Mail;
use Log;
use Carbon\Carbon;
use App\Helpers\Helper;

class AppointmentReminder extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'reminder:appointment';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Send email and sms reminders to doctor and patient having an appointment within next 5 minutes';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle(){
		$appointments = DoctorAppointments::whereRaw('CONCAT(date, " " ,time_start) > NOW()')
											->whereRaw('CONCAT(date, " " ,time_start) < DATE_ADD(NOW() , INTERVAL 5 MINUTE)')
											->where('reminder_sent', 0)
											->orderBy('date')
											->orderBy('time_start')
											->get();
											
		foreach ($appointments as $app) {
			$status = $app->appointmentCallStatus;

			$time = Carbon::parse($app->date.' '.$app->time_start);
			$time_string = $time->format('g:i A');

			if (!$status) {
				$det = AppointmentDetails::where('appointment_id', $app->id)
												->where('appointment_type', 1)
												->first();

				$doc = $app->doctor_id;
				$doc_user = User::find($doc);
				$doc_profile = DoctorProfile::where('doctor_id', $app->doctor_id)->first();
				if (!$doc_profile) {
					continue;
				}

				$pat = $app->patient_id;
				$pat_user = User::find($pat);

				if ($doc_user && $pat_user) {
					Mail::send('emails.appointmentReminder', array('name' => $det->patient_name, 'appointment_id' => $app->shdct_appt_id), function ($message) use ($doc_user)
					{
						$message->to($doc_user->email, $doc_user->name);
						$message->subject('SheDoctr - Appointment Reminder');
					});

					// Send SMS
					// $msgtxt = "Your appointment with ".$det->patient_name." starts in 5 minutes";
					$msgtxt = "Your ".$time_string." appointment with ".$det->patient_name." is about to start. Please login to your dashboard to attend the call.";

					$msgData = array(
						'recipient_no' => $doc_user->mobile_no,
						'msgtxt' => $msgtxt
					);

					$sendsms = Helper::sendSMS($msgData);

					Mail::send('emails.appointmentReminder', array('name' => 'Dr. '.$doc_profile->name, 'appointment_id' => $app->shdct_appt_id), function ($message) use ($pat_user)
					{
						$message->to($pat_user->email, $pat_user->name);
						$message->subject('SheDoctr - Appointment Reminder');
					});

					// $msgtxt = "Your appointment with Dr. ".$doc_profile->name." starts in 5 minutes";
					$msgtxt = "Your ".$time_string." appointment with Dr. ".$doc_profile->name." is about to start. Please login to your dashboard to attend the call.";

					$msgData = array(
						'recipient_no' => $pat_user->mobile_no,
						'msgtxt' => $msgtxt
					);

					$sendsms = Helper::sendSMS($msgData);

					$app->reminder_sent = 1;
					$app->save();
				}
			}
		}

		// Log::info('The appointment reminders were sent successfully!');
		// $this->info('The appointment reminders were sent successfully!');
	}
}
