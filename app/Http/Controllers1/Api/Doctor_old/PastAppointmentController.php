<?php

namespace App\Http\Controllers\Api\Doctor;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\Model\Doctor\DoctorAppointments;
use App\Model\Appointment\AppointmentDetails;

use App\Helpers\Helper;

use URL;
use Carbon\Carbon;

class PastAppointmentController extends Controller
{
    public function index(){
		try{
			$user = Helper::isUserLoggedIn();

			if (!$user) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => "Unauthorized"], 401);
			}

			$appointments = DoctorAppointments::where('doctor_id', $user->id)
												// ->whereRaw('CONCAT(date, " " ,time_start) <= DATE_SUB(NOW() , INTERVAL 10 MINUTE)')
												// ->whereRaw('CONCAT(date, " " ,time_start) <= NOW()')
												->orderBy('date', 'desc')
												->orderBy('time_start' ,'desc')
												->get();

			$return_arr = array();

			foreach ($appointments as $app) {
				$det = AppointmentDetails::where('appointment_id', $app->id)
											->where('appointment_type', 1)
											->first();

				if (empty($det)) {
					continue;
				}

				/*$date_time = $app->date.' '.$app->time_start;
				$dt = Carbon::parse($date_time);
				$now = Carbon::now()->addMinutes(10);

				if ($dt->diffInMinutes($now) < 10) {
					continue;
				}*/

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

				$status = $app->appointmentCallStatus;
				$st_text = '';
				$st_arr = array();
				if ($status) {
					if ($status->status == 1) {
						$st_text = 'Ended';
					}
					else{
						/*if (strpos($status->reason, 'Cancel') === false) {
							$st_text = 'Failed';
						}
						else{
							$st_text = 'Cancelled';
						}*/
						continue;
					}

					$st_arr = array(
						'success' => ($status->status == 1)?true:false,
						'reason' => $status->reason,
						'details' => $status->details,
						'status' => $st_text
					);
				}
				else{
					$date_time = $app->date.' '.$app->time_start;
					$dt = Carbon::parse($date_time);
					$now = Carbon::now();

					if ($now->diffInMinutes($dt, false) > -10) {
						continue;
					}
				}

				$prescription = $app->appointmentPrescription;
				$prescription_status = false;
				if ($prescription) {
					$prescription_status = true;
				}

				$pat_user = User::find($app->patient_id);

				$arr = array(
					'id' => $app->id,
					'shedct_id' => $app->shdct_appt_id,
					'date' => $app->date,
					'time' => $app->time_start,
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
					'status' => $st_arr,
					'prescription' => $prescription_status
				);

				array_push($return_arr, $arr);
			}
			return response()->json(['success' => true, 'data' => $return_arr]);
		}
		catch(Exception $e){
			return response()->json(['success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"], 500);
		}
	}
}
