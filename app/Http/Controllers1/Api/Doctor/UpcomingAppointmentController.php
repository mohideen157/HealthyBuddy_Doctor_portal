<?php

namespace App\Http\Controllers\Api\Doctor;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\Model\Doctor\DoctorAppointments;
use App\Model\Doctor\DoctorProfile;
use App\Model\Appointment\AppointmentDetails;
use App\Model\Appointment\AppointmentCallStatus;

use App\Model\User\CancelRescheduleCount;
use App\Model\Appointment\CancelFeeSlabs;
use App\Model\Appointment\RescheduleFeeSlabs;

use App\Model\Patient\PatientCredits;
use App\Model\Patient\PatientCreditLogs;

use App\Model\AdminSettings;
use App\Model\Payment;
use App\Helpers\Helper;

use DB;
use URL;
use Carbon\Carbon;
use Mail;

class UpcomingAppointmentController extends Controller
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

			$appointments = DoctorAppointments::where('doctor_id', $user->id)
												//->whereRaw('CONCAT(date, " " ,time_start) > DATE_SUB(NOW() , INTERVAL 10 MINUTE)')
												->orderBy('date')
												->orderBy('time_start')
												->get();

			$return_arr = array();

			foreach ($appointments as $app) {
				$det = AppointmentDetails::where('appointment_id', $app->id)
											->where('appointment_type', 1)
											->first();

				if (empty($det)) {
					continue;
				}

				$reports = $det->appointmentPatientReports;

				$a_reports = array();
				foreach ($reports as $report) {
					$arr = array(
						'id' => $report->id,
						'type' => $report->type,
						'path' => URL::to('/').$report->path
					);
					array_push($a_reports, $arr);
				}

				$height = $det->patient_height_feet;
				if ($det->patient_height_inches > 0) {
					$height .= '.'.$det->patient_height_inches;
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

				
				$pat_user = User::find($app->patient_id);

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
					'shedct_id' => $app->shdct_appt_id,
					'date' => $app->date,
					'time' => $app->time_start,
					'time_end' => $app->time_end,
					'datetime' => Carbon::parse($app->date.' '.$app->time_start)->toAtomString(),
					'start_in' => Carbon::parse($app->date.' '.$app->time_start)->diffForHumans(Carbon::now(), true),
					'type' => $app->consultation_type,
					'patient' => array(
						'name' => $det->patient_name,
						'gender' => $det->patient_gender,
						'height' => $height,
						'blood_group' => $det->patient_blood_group,
						'weight' => $det->patient_weight,
						'purpose' => $det->patient_purpose,
						'medications' => ($det->patient_medications)?$det->patient_medications:'',
						'allergies' => ($det->patient_allergies)?$det->patient_allergies:'',
						'reports' => $a_reports,
						'image' => URL::to('/').$pat_user->profile_image,
						'shedct_id' => $pat_user->shdct_user_id
					),
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

			if ($appointment->doctor_id != $user->id) {
				return response()->json(['success' => false, 'error' => 'not_allowed', 'message' => 'Unauthorized<br />You are trying to access an appointment which belongs to other doctor']);
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
				$call_status->reason = 'Cancelled By Doctor';
				$call_status->details = $request->reason;
				$call_status->user_id = $user->id;
				$call_status->save();

				// Refund credits to user
				$consultation_fee = $appointment->consultation_price;

				$user_cancel_resc_count = CancelRescheduleCount::where('user_id', $user->id)->first();
				if (!$user_cancel_resc_count) {
					$user_cancel_resc_count = new CancelRescheduleCount();
					$user_cancel_resc_count->user_id = $user->id;
					$user_cancel_resc_count->cancel_count = 0;
					$user_cancel_resc_count->reschedule_count = 0;
					$user_cancel_resc_count->save();
				}

				$user_cancel_resc_count->cancel_count = $user_cancel_resc_count->cancel_count + 1;
				$user_cancel_resc_count->save();

                $payment_details = Payment::where('appointment_id', $appointment->id)->first();
				$discounted_price = $payment_details->total_price - $payment_details->discount;

				//$refund_amount = $consultation_fee;
                //sumit
				$refund_amount = $discounted_price;
				if ($refund_amount < 0) {
					$refund_amount = 0;
				}
				//sumit  
				$credits = PatientCredits::where('patient_id', $appointment->patient_id)->first();
				if (!$credits) {
					$credits = new PatientCredits();
					$credits->patient_id = $appointment->patient_id;
					$credits->credits = 0;
					$credits->save();
				}

				$credits->credits = $credits->credits + $refund_amount;
				$credits->save();

				$credit_log = new PatientCreditLogs();
				$credit_log->patient_id = $appointment->patient_id;
				$credit_log->remarks = "Refund for doctor cancelled Appointment ID - ".$appointment->shdct_appt_id;
				$credit_log->type = 'Credit';
				$credit_log->delta = $refund_amount;
				$credit_log->transaction_date = Carbon::now()->toDateTimeString();
				$credit_log->save();

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
					 ->withSubject('Appointment Cancelled')
					 ->withBody('Appointment ID: '.$appointment->shdct_appt_id.' has been cancelled')
					 ->regarding($appointment)
					 ->deliver();

			$pat_user->newNotification()
					 ->withType('AppointmentCancelled')
					 ->withSubject('Appointment Cancelled By Doctor')
					 ->withBody('Dr. '.$doctor->name.' has cancelled appointment ID: '.$appointment->shdct_appt_id)
					 ->regarding($appointment)
					 ->deliver();

			// Send Mail
			$sendemail = Mail::send('emails.doctor.appointmentCancelled', array('doctor_name' => $doctor->name, 'appt_id' => $appointment->shdct_appt_id), function ($message) use ($doc_user)
			{
				$message->to($doc_user->email, $doc_user->name);
				$message->subject('SheDoctr - Appointment Cancelled');
			});

			$sendemail = Mail::send('emails.patient.appointmentCancelledByDoctor', array('doctor_name' => $doctor->name, 'appt_id' => $appointment->shdct_appt_id), function ($message) use ($pat_user)
			{
				$message->to($pat_user->email, $pat_user->name);
				$message->subject('SheDoctr - Appointment Cancelled');
			});

			// Send SMS
			$msgtxt = 'We regret to inform you that your appointment ID: '.$appointment->shdct_appt_id.' has been cancelled by the Doctor due to emergency. Thank you';

			$msgData = array(
				'recipient_no' => $doc_user->mobile_no,
				'msgtxt' => $msgtxt
			);

			$sendsms = Helper::sendSMS($msgData);

			$msgtxt = 'We regret to inform you that your appointment ID: '.$appointment->shdct_appt_id.' has been cancelled by the Doctor due to emergency. Thank you';

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
