<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\User;

/*use App\Model\Doctor\DoctorAppointments;
use App\Model\Appointment\AppointmentDetails;
use App\Model\Appointment\AppointmentCallStatus;*/

use App\Model\Appointment\AppointmentPrescription;
use App\Model\Doctor\DoctorProfile;

use Mail;
use Log;
use App\Helpers\Helper;
use Carbon\Carbon;

class AppointmentFollowUpReminder extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'reminder:followup';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Send email and sms reminder to patient having follow up date the next day';

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
	public function handle()
	{
		$dt = Carbon::now()->addDay()->toDateString();
		$prescriptions = AppointmentPrescription::where('next_visit', $dt)->get();

		foreach ($prescriptions as $pres) {
			$app = $pres->appointment;
			$doc = $app->doctor_id;
			$doc_user = User::find($doc);
			$doc_profile = DoctorProfile::where('doctor_id', $app->doctor_id)->first();

			if (!$doc_profile) {
				continue;
			}

			$patient = User::find($app->patient_id);

			if ($patient) {
				Mail::send('emails.reminders.appointmentFollowUpReminder', array('doctor_name' => $doc_profile->name), function ($message) use ($patient)
				{
					$message->to($patient->email, $patient->name);
					$message->subject('SheDoctr - Follow Up Reminder');
				});

				// Send SMS
				$msgtxt = "Dr. ".$doc_profile->name.' has recommended you for a follow up appointment tomorrow. Please book an appointment to schedule your follow up.';

				$msgData = array(
					'recipient_no' => $patient->mobile_no,
					'msgtxt' => $msgtxt
				);

				$sendsms = Helper::sendSMS($msgData);
			}
		}
		
		// Log::info('The appointment follow up reminders were sent successfully!');
		// $this->info("Reminders Sent");
	}
}