<?php

namespace App\Http\Controllers\Api\Patient;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\Model\Doctor\DoctorProfile;
use App\Model\Doctor\DoctorAppointments;
use App\Model\Appointment\AppointmentDetails;
use App\Model\Doctor\DoctorTimeSlots;
use App\Model\Appointment\AppointmentCallStatus;

use App\Model\Appointment\TempAppointment;
use App\Model\Appointment\AppointmentPatientReports;

use App\Model\User\CancelRescheduleCount;
use App\Model\Appointment\RescheduleFeeSlabs;
use App\Model\Appointment\CancelFeeSlabs;

use App\Model\Patient\PatientCredits;
use App\Model\Patient\PatientCreditLogs;
use App\Model\AdminSettings;
use App\Model\Payment;

use App\Helpers\Helper;

use DB;
use URL;
use File;
use Carbon\Carbon;
use Mail;

class UpcomingAppointmentsController extends Controller
{
	private $settings;

	/**
	 * Instantiate a new AdminDoctorController instance.
	 *
	 * @return void
	 */
	public function __construct(){
		$settings = AdminSettings::all();
		$arr = array();
		foreach ($settings as $value) {
			$arr[$value->key] = $value->value;
		}
		$this->settings = $arr;
	}
	
	public function index(){
		try{
			$user = Helper::isUserLoggedIn();

			if (!$user) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => "Unauthorized"], 401);
			}
			
			  

			$appointments = DoctorAppointments::where('patient_id', $user->id)
												//->whereRaw('CONCAT(date, " " ,time_start) > DATE_SUB(NOW() , INTERVAL 10 MINUTE)')
												->orderBy('date')
												->orderBy('time_start')
												->get();
												
										

			$return_arr = array();

			$free_cancel_allowed = 1;
			$free_reschedule_allowed = 1;
			if (array_key_exists('free_cancel_allowed', $this->settings)) {
				$free_cancel_allowed = (int)$this->settings['free_cancel_allowed'];
			}
			if (array_key_exists('free_reschedule_allowed', $this->settings)) {
				$free_reschedule_allowed = (int)$this->settings['free_reschedule_allowed'];
			}

			$user_cancel_resc_count = CancelRescheduleCount::where('user_id', $user->id)->first();
			if (!$user_cancel_resc_count) {
				$user_cancel_resc_count = new CancelRescheduleCount();
				$user_cancel_resc_count->user_id = $user->id;
				$user_cancel_resc_count->cancel_count = 0;
				$user_cancel_resc_count->reschedule_count = 0;
				$user_cancel_resc_count->save();
			}

			$cancel_free = ($user_cancel_resc_count->cancel_count < $free_cancel_allowed)?true:false;
			$reschedule_free = ($user_cancel_resc_count->reschedule_count < $free_reschedule_allowed)?true:false;

			foreach ($appointments as $app) {
				$det = AppointmentDetails::where('appointment_id', $app->id)
											->where('appointment_type', 1)
											->first();

				if (empty($det)) {
					continue;
				}

				$st = true;
				$st_arr = array();
				$status = $app->appointmentCallStatus;
				$st_text = '';
				if (!$status) {
					$st = false;
				}
				else{
					continue;
					/*if ($status->status == 1) {
						$st_text = 'Ended';
						continue;
					}
					else{
						if (strpos($status->reason, 'Cancel') === false) {
							$st_text = 'Failed';
							continue;
						}
						else{
							$st_text = 'Cancelled';
						}
					}

					$st_arr = array(
						'success' => ($status->status == 1)?true:false,
						'reason' => $status->reason,
						'details' => $status->details,
						'status' => $st_text
					);*/
				}

				$consultation_fee = $app->consultation_price;
				$cancel_fee = CancelFeeSlabs::where('from', '<=', $consultation_fee)->where('to', '>=', $consultation_fee)->value('fee');
				$reschedule_fee = RescheduleFeeSlabs::where('from', '<=', $consultation_fee)->where('to', '>=', $consultation_fee)->value('fee');
				
				$doc_profile = DoctorProfile::where('doctor_id', $app->doctor_id)->first();

		$to_time = strtotime($app->date.' '.$app->time_end);
		$from_time = strtotime($app->date.' '.$app->time_start);
		$interval =  round(abs($to_time - $from_time) / 60,2);
		$interval = ($interval - 5);

		$exis = strtotime($app->date.' '.$app->time_start);
		$cur = strtotime(date('Y-m-d H:i:s', strtotime("-".$interval." min")));

		if($exis > $cur)
		{
				$arr = array(
					'id' => $app->id,
					'shdct_id' => $app->shdct_appt_id,
					'date' => $app->date,
					'time' => $app->time_start,
					'time_end' => $app->time_end,
					'datetime' => Carbon::parse($app->date.' '.$app->time_start)->toAtomString(),
					'start_in' => Carbon::parse($app->date.' '.$app->time_start)->diffForHumans(Carbon::now(), true),
					'type' => $app->consultation_type,
					'patient_name' => $det->patient_name,
					'doctor' => array(
						'id' => $doc_profile->doctor_id,
						'name' => 'Dr. '.$doc_profile->name,
						'shdct_id' => $doc_profile->userData->shdct_user_id,
						'specialty' => ($doc_profile->specialty)?$doc_profile->specialty->specialty->specialty:false,
						'slug' => $doc_profile->slug
					),
					'cancel_free' => $cancel_free,
					'reschedule_free' => $reschedule_free,
					'cancel_fee' => ($cancel_fee)?$cancel_fee:0,
					'reschedule_fee' => ($reschedule_fee)?$reschedule_fee:0,
					'cancelled' => $st,
					'status' => $st_arr
				);

				array_push($return_arr, $arr);
				}
			}
			return response()->json(['success' => true, 'data' => $return_arr]);
		}
		catch(Exception $e){
			return response()->json(['success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"], 500);
		}
	}

	public function rescheduleAppointment(Request $request){
		try{
			$user = Helper::isUserLoggedIn();

			if (!$user) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => "Unauthorized"], 401);
			}

			if (!$request->has('appointment_id')) {
				return response()->json(['success' => false, 'error' => 'validation_error', 'message' => 'Did not get the appointment id']);
			}

			$appointment = DoctorAppointments::find($request->appointment_id);

			if (!$appointment) {
				return response()->json(['success' => false, 'error' => 'not_found', 'message' => 'We could not find the appointment']);
			}

			if ($appointment->patient_id != $user->id) {
				return response()->json(['success' => false, 'error' => 'not_allowed', 'message' => 'Unauthorized<br />You are trying to access an appointment which belongs to other patient']);
			}

			$expiry = (int)$this->settings['booking_cancel_buffer'];
			$expiry = $expiry*60;
			$t = Carbon::parse($appointment->date.' '.$appointment->time_start)->subSeconds($expiry);
			if ($t->isPast()) {
				return response()->json(['success' => false, 'error' => 'not_allowed', 'message' => 'Appointment can only be cancelled atmost '.(int)$this->settings['booking_cancel_buffer'].' minutes before the appointment time']);
			}

			$call_status = AppointmentCallStatus::where('appointment_id', $appointment->id)->count();
			if ($call_status > 0) {
				return response()->json(['success' => false, 'error' => 'already_exists', 'message' => 'Either this appointment has already been cancelled or is completed<br />Please reload the page to get updated status']);
			}

			// Create new booking with same details as previous booking
			$timeslot = $request->appointment_data['selectedSlot'];
			$doctor_id = $request->doctor_id;
			$user_id = $user->id;

			$expiry = (int)$this->settings['booking_buffer'];
			$expiry = $expiry*60;

			$dt = date('Y-m-d H:i:s', $timeslot);
			$dt = Carbon::parse($dt)->subSeconds($expiry);
			if ($dt->isPast()) {
				return response()->json(array('success' => false, 'error' => 'booking_not_allowed', 'message' => "You need to book slot atleast 10 mins before the slot time"));
			}

			$slot_available = true;

			// Find Time Slot
			$t = date('Y-m-d H:i:s', $timeslot);

			$t = Carbon::parse($t);
			$date = $t->toDateString();
			$time = $t->toTimeString();

			if ($t->isPast()) {
				return response()->json(array('success' => false, 'error' => 'slot_time_passed', 'message' => "Slot Time Passed"));
			}

			$doc_timeslot_id = DoctorTimeSlots::where('doctor_id', $doctor_id)
										->where('date', $date)
										->where('time_start', $time)
										->value('id');
			
			if (!$doc_timeslot_id || $doc_timeslot_id == NULL) {
				return response()->json(array('success' => false, 'error' => 'slot_not_found', 'message' => "Slot already booked<br />Please choose a different time slot"));
			}

			$temp_appointment_ids = TempAppointment::where('user_id', $user_id)->pluck('id');
			if ($temp_appointment_ids) {
				AppointmentDetails::whereIn('appointment_id', $temp_appointment_ids)
									->where('appointment_type', 0)
									->delete();
			}
			// Remove all temp slots for that user
			TempAppointment::where('user_id', $user_id)->delete();

			// Check Slot Availability
			$slot_in_temp = TempAppointment::where('slot_id', $doc_timeslot_id)->count();

			if ($slot_in_temp > 0) {
				$slot_details = TempAppointment::where('slot_id', $doc_timeslot_id)->first();

				if ($slot_details->status == 1) {
					$expiry = (int)$this->settings['payment_pending_booking_expiry'];
				}
				else if($slot_details->status == 0){
					$expiry = (int)$this->settings['temp_booking_expiry'];
				}
				else{
					$expiry = 15;
				}
				
				$expiry = $expiry*60;

				$t = Carbon::parse($slot_details->updated_at)->addSeconds($expiry);
				if ($t->isPast()) {
					$slot_details->delete();
					// Slot Available
					$slot_available = true;
				}
				else{
					$slot_available = false;
				}
			}

			if (!$slot_available) {
				return response()->json(array('success' => false, 'error' => 'slot_unavailable', 'message' => "Slot already booked<br />Please choose a different time slot"));
			}

			try{
				DB::beginTransaction();

				// Create a temp booking
				$temp_booking = new TempAppointment();
				$temp_booking->doctor_id = $doctor_id;
				$temp_booking->user_id = $user_id;
				$temp_booking->slot_id = $doc_timeslot_id;
				$temp_booking->consultation_type = $request->appointment_data['callDetails']['type'];
				$temp_booking->consultation_price = $request->appointment_data['callDetails']['price'];
				$temp_booking->status = 0;
				$temp_booking->save();

				$app_details = AppointmentDetails::where('appointment_id', $appointment->id)->where('appointment_type', 1)->first();


				// Copy Details of old booking to new booking
				$ad = new AppointmentDetails();
				$ad->appointment_id = $temp_booking->id;
				$ad->appointment_type = 0;
				$ad->patient_type = $app_details->patient_type;
				$ad->patient_name = $app_details->patient_name;
				$ad->patient_gender = $app_details->patient_gender;
				$ad->patient_height_feet = $app_details->patient_height_feet;
				$ad->patient_height_inches = $app_details->patient_height_inches;
				$ad->patient_blood_group = $app_details->patient_blood_group;
				$ad->patient_weight = $app_details->patient_weight;
				$ad->patient_purpose = $app_details->patient_purpose;

				if ($app_details->patient_allergies) {
					if ($app_details->patient_allergies != '') {
						$ad->patient_allergies = $app_details->patient_allergies;
					}
				}

				if ($app_details->patient_medications) {
					if ($app_details->patient_medications != '') {
						$ad->patient_medications = $app_details->patient_medications;
					}
				}

				$ad->save();

				$appointment_details_id = $ad->id;

				foreach ($app_details->appointmentPatientReports as $file) {
					$main_path = 'uploads/patients/';
					$inner_path = $user->shdct_user_id.'/'.$appointment_details_id.'/'.'patient_reports/';

					$filename = basename(public_path().$file->path);

					$new_path = $main_path.$inner_path.$filename;

					//The name of the directory that we need to create.
					$directoryName = public_path($main_path.$inner_path);
					 
					//Check if the directory already exists.
					if(!is_dir($directoryName)){
						//Directory does not exist, so lets create it.
						mkdir($directoryName, 0755, true);
					}

					if (File::copy(public_path($file->path), public_path($new_path))){
						$pr = new AppointmentPatientReports();
						$pr->appointment_details_id = $appointment_details_id;
						$pr->type = $file->type;
						$pr->path = '/'.$new_path;
						$pr->save();
					}
				}

				// Change status of booking to payment pending
				$temp_booking->status = 1;
				$temp_booking->save();

				// Cancel the current appointment
				$call_status = new AppointmentCallStatus();
				$call_status->appointment_id = $appointment->id;
				$call_status->status = 0;
				$call_status->reason = 'Cancelled By Patient';
				$call_status->details = 'Rescheduled';
				$call_status->user_id = $user->id;
				$call_status->save();


				// Add credits to user
				$consultation_fee = $appointment->consultation_price;

				$free_cancel_allowed = 1;
				$free_reschedule_allowed = 1;
				if (array_key_exists('free_cancel_allowed', $this->settings)) {
					$free_cancel_allowed = (int)$this->settings['free_cancel_allowed'];
				}
				if (array_key_exists('free_reschedule_allowed', $this->settings)) {
					$free_reschedule_allowed = (int)$this->settings['free_reschedule_allowed'];
				}

				$user_cancel_resc_count = CancelRescheduleCount::where('user_id', $user->id)->first();
				if (!$user_cancel_resc_count) {
					$user_cancel_resc_count = new CancelRescheduleCount();
					$user_cancel_resc_count->user_id = $user->id;
					$user_cancel_resc_count->cancel_count = 0;
					$user_cancel_resc_count->reschedule_count = 0;
					$user_cancel_resc_count->save();
				}

				$reschedule_free = ($user_cancel_resc_count->reschedule_count < $free_reschedule_allowed)?true:false;
				if (!$reschedule_free) {
					$reschedule_fee = RescheduleFeeSlabs::where('from', '<=', $consultation_fee)->where('to', '>=', $consultation_fee)->value('fee');
				}
				else{
					$reschedule_fee = 0;
				}

				$user_cancel_resc_count->reschedule_count = $user_cancel_resc_count->reschedule_count + 1;
				$user_cancel_resc_count->save();

				//sumit
                $payment_details = Payment::where('appointment_id', $appointment->id)->first();
				$discounted_price = $payment_details->total_price - $payment_details->discount;
				$refund_amount = $discounted_price - $reschedule_fee;
				if ($refund_amount < 0) {
					$refund_amount = 0;
				}
				//sumit
				
				//$refund_amount = $consultation_fee-$reschedule_fee;

				$credits = PatientCredits::where('patient_id', $user->id)->first();
				if (!$credits) {
					$credits = new PatientCredits();
					$credits->patient_id = $user->id;
					$credits->credits = 0;
					$credits->save();
				}

				$credits->credits = $credits->credits + $refund_amount;
				$credits->save();

				$credit_log = new PatientCreditLogs();
				$credit_log->patient_id = $user->id;
				$credit_log->remarks = "Refund for rescheduling Appointment ID - ".$appointment->shdct_appt_id;
				$credit_log->type = 'Credit';
				$credit_log->delta = $refund_amount;
				$credit_log->transaction_date = Carbon::now()->toDateTimeString();
				$credit_log->save();

				// Open The slot for booking
				$timeslot = new DoctorTimeSlots();
				$timeslot->doctor_id = $appointment->doctor_id;
				$timeslot->date = $appointment->date;
				$timeslot->time_start = $appointment->time_start;

				$t = Carbon::parse($appointment->date.' '.$appointment->time_start);

				$timeslot->time_end = $t->addSeconds(15*60)->toTimeString();
				$timeslot->save();

				DB::commit();
			}
			catch(Exception $e){
				DB::rollBack();
				return response()->json(['success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"], 500);
			}
		}
		catch(Exception $e){
			return response()->json(['success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"], 500);
		}

		$pat_user = User::find($appointment->patient_id);
		$doc_user = User::find($appointment->doctor_id);
		$doctor = DoctorProfile::where('doctor_id', $appointment->doctor_id)->first();

		// Add Notification
		$doc_user->newNotification()
				 ->withType('AppointmentRescheduled')
				 ->withSubject('Appointment Rescheduled By Patient')
				 ->withBody('Appointment ID: '.$appointment->shdct_appt_id.' has been rescheduled by the patient')
				 ->regarding($appointment)
				 ->deliver();

		$pat_user->newNotification()
				 ->withType('AppointmentRescheduled')
				 ->withSubject('Appointment Rescheduled')
				 ->withBody('Appointment ID: '.$appointment->shdct_appt_id.' has been rescheduled')
				 ->regarding($appointment)
				 ->deliver();

		// Send Mail
		$sendemail = Mail::send('emails.doctor.appointmentRescheduledByPatient', array('appt_id' => $appointment->shdct_appt_id), function ($message) use ($doc_user)
		{
			$message->to($doc_user->email, $doc_user->name);
			$message->subject('SheDoctr - Appointment Rescheduled');
		});

		$sendemail = Mail::send('emails.patient.appointmentRescheduled', array('appt_id' => $appointment->shdct_appt_id), function ($message) use ($pat_user)
		{
			$message->to($pat_user->email, $pat_user->name);
			$message->subject('SheDoctr - Appointment Rescheduled');
		});

		// Send SMS
		$msgtxt = 'Appointment ID: '.$appointment->shdct_appt_id.' has been rescheduled. You will receive confirmation of new appointment shortly';

		$msgData = array(
			'recipient_no' => $doc_user->mobile_no,
			'msgtxt' => $msgtxt
		);

		$sendsms = Helper::sendSMS($msgData);

		$msgtxt = 'Appointment ID: '.$appointment->shdct_appt_id.' has been rescheduled';

		$msgData = array(
			'recipient_no' => $pat_user->mobile_no,
			'msgtxt' => $msgtxt
		);

		$sendsms = Helper::sendSMS($msgData);

		return response()->json(['success' => true, 'data' => ['temp_booking_id' => $temp_booking->id]]);
	}

	public function cancelAppointment(Request $request){
           
		try{
			$user = Helper::isUserLoggedIn();

			if (!$user) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => "Unauthorized"], 401);
			}

			if (!$request->has('appointment_id')) {
				return response()->json(['success' => false, 'error' => 'validation_error', 'message' => 'Did not get the appointment id']);
			}

			if (!$request->has('reason')) {
				return response()->json(['success' => false, 'error' => 'validation_error', 'message' => 'Did not get reason for cancelling the appointment']);
			}

			$appointment = DoctorAppointments::find($request->appointment_id);

			if (!$appointment) {
				return response()->json(['success' => false, 'error' => 'not_found', 'message' => 'We could not find the appointment']);
			}

			if ($appointment->patient_id != $user->id) {
				return response()->json(['success' => false, 'error' => 'not_allowed', 'message' => 'Unauthorized<br />You are trying to access an appointment which belongs to other patient']);
			}

			$expiry = (int)$this->settings['booking_cancel_buffer'];
			$expiry = $expiry*60;
			$t = Carbon::parse($appointment->date.' '.$appointment->time_start)->subSeconds($expiry);
			if ($t->isPast()) {
				return response()->json(['success' => false, 'error' => 'not_allowed', 'message' => 'Appointment can only be cancelled atmost '.(int)$this->settings['booking_cancel_buffer'].' minutes before the appointment time']);
			}

			$call_status = AppointmentCallStatus::where('appointment_id', $appointment->id)->count();
			if ($call_status > 0) {
				return response()->json(['success' => false, 'error' => 'already_exists', 'message' => 'Either this appointment has already been cancelled or is completed<br />Please reload the page to get updated status']);
			}

			try{
				DB::beginTransaction();

				$call_status = new AppointmentCallStatus();
				$call_status->appointment_id = $appointment->id;
				$call_status->status = 0;
				$call_status->reason = 'Cancelled By Patient';
				$call_status->details = $request->reason;
				$call_status->user_id = $user->id;
				$call_status->save();

				// Refund credits to user
				$consultation_fee = $appointment->consultation_price;

				$free_cancel_allowed = 1;
				$free_reschedule_allowed = 1;
				if (array_key_exists('free_cancel_allowed', $this->settings)) {
					$free_cancel_allowed = (int)$this->settings['free_cancel_allowed'];
				}

				$user_cancel_resc_count = CancelRescheduleCount::where('user_id', $user->id)->first();
				if (!$user_cancel_resc_count) {
					$user_cancel_resc_count = new CancelRescheduleCount();
					$user_cancel_resc_count->user_id = $user->id;
					$user_cancel_resc_count->cancel_count = 0;
					$user_cancel_resc_count->reschedule_count = 0;
					$user_cancel_resc_count->save();
				}

				$cancel_free = ($user_cancel_resc_count->cancel_count < $free_cancel_allowed)?true:false;
				if (!$cancel_free) {
					$cancel_fee = CancelFeeSlabs::where('from', '<=', $consultation_fee)->where('to', '>=', $consultation_fee)->value('fee');
				}
				else{
					$cancel_fee = 0;
				}

				$user_cancel_resc_count->cancel_count = $user_cancel_resc_count->cancel_count + 1;
				$user_cancel_resc_count->save();

                //sumit code starts
				$payment_details = Payment::where('appointment_id', $appointment->id)->first();
				$discounted_price = $payment_details->total_price - $payment_details->discount;
			 	//sumit code starts

				//$refund_amount = $consultation_fee-$cancel_fee;
                //sumit
				$refund_amount = $discounted_price-$cancel_fee;
				if ($refund_amount < 0) {
					$refund_amount = 0;
				}
				//sumit
				
				$credits = PatientCredits::where('patient_id', $user->id)->first();
				if (!$credits) {
					$credits = new PatientCredits();
					$credits->patient_id = $user->id;
					$credits->credits = 0;
					$credits->save();
				}

				$credits->credits = $credits->credits + $refund_amount;
				$credits->save();

				$credit_log = new PatientCreditLogs();
				$credit_log->patient_id = $user->id;
				$credit_log->remarks = "Refund for cancelling Appointment ID - ".$appointment->shdct_appt_id;
				$credit_log->type = 'Credit';
				$credit_log->delta = $refund_amount;
				$credit_log->transaction_date = Carbon::now()->toDateTimeString();
				$credit_log->save();

				// Open The slot for booking
				$timeslot = new DoctorTimeSlots();
				$timeslot->doctor_id = $appointment->doctor_id;
				$timeslot->date = $appointment->date;
				$timeslot->time_start = $appointment->time_start;

				$t = Carbon::parse($appointment->date.' '.$appointment->time_start);

				$timeslot->time_end = $t->addSeconds(15*60)->toTimeString();
				$timeslot->save();

				DB::commit();
			}
			catch(Exception $e){
				DB::rollBack();
				return response()->json(['success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"], 500);
			}

			$pat_user = User::find($appointment->patient_id);
			$doc_user = User::find($appointment->doctor_id);
			$doctor = DoctorProfile::where('doctor_id', $appointment->doctor_id)->first();

			// Add Notification
			$doc_user->newNotification()
					 ->withType('AppointmentCancelled')
					 ->withSubject('Appointment Cancelled By Patient')
					 ->withBody('Appointment ID: '.$appointment->shdct_appt_id.' has been cancelled by the patient')
					 ->regarding($appointment)
					 ->deliver();

			$pat_user->newNotification()
					 ->withType('AppointmentCancelled')
					 ->withSubject('Appointment Cancelled')
					 ->withBody('Appointment ID: '.$appointment->shdct_appt_id.' has been cancelled')
					 ->regarding($appointment)
					 ->deliver();

			// Send Mail
			$sendemail = Mail::send('emails.doctor.appointmentCancelledByPatient', array('appt_id' => $appointment->shdct_appt_id), function ($message) use ($doc_user)
			{
				$message->to($doc_user->email, $doc_user->name);
				$message->subject('SheDoctr - Appointment Cancelled');
			});

			$sendemail = Mail::send('emails.patient.appointmentCancelled', array('appt_id' => $appointment->shdct_appt_id), function ($message) use ($pat_user)
			{
				$message->to($pat_user->email, $pat_user->name);
				$message->subject('SheDoctr - Appointment Cancelled');
			});

			// Send SMS
			$msgtxt = 'Appointment ID: '.$appointment->shdct_appt_id.' has been cancelled by the patient';

			$msgData = array(
				'recipient_no' => $doc_user->mobile_no,
				'msgtxt' => $msgtxt
			);

			$sendsms = Helper::sendSMS($msgData);

			$msgtxt = 'Appointment ID: '.$appointment->shdct_appt_id.' has been cancelled.';

			$msgData = array(
				'recipient_no' => $pat_user->mobile_no,
				'msgtxt' => $msgtxt
			);

			$sendsms = Helper::sendSMS($msgData);
				
			return response()->json(['success' => true, 'message' => 'Appointment Cancelled']);
		}
		catch(Exception $e){
			return response()->json(['success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"], 500);
		}
	}
}
