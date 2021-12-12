<?php

namespace App\Http\Controllers\Api\Patient;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\Model\Doctor\DoctorProfile;
use App\Model\Doctor\DoctorAppointments;
use App\Model\Appointment\AppointmentDetails;
use App\Model\Doctor\DoctorConsultationPrices;

use App\Helpers\Helper;

use URL;
use Carbon\Carbon;

class PastAppointmentsController extends Controller
{
    public function index(){
		try{
			$user = Helper::isUserLoggedIn();

			if (!$user) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => "Unauthorized"], 401);
			}

			$appointments = DoctorAppointments::where('patient_id', $user->id)
												//->whereRaw('CONCAT(date, " " ,time_start) <= NOW()')
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

				$status = $app->appointmentCallStatus;
				$st_text = '';
				$st_arr = array();
				$stat = true;
				if ($status) {
					if ($status->status == 1) {
						$st_text = 'Completed';
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
					/*$stat = false;
					$date_time = $app->date.' '.$app->time_start;
					$dt = Carbon::parse($date_time);
					$now = Carbon::now();

					if ($now->diffInMinutes($dt, false) > -10) {
						continue;
					}*/
					continue;
				}

				$prescription = $app->appointmentPrescription;
				$prescription_status = false;
				if ($prescription) {
					$prescription_status = true;
				}

				$doc_profile = DoctorProfile::where('doctor_id', $app->doctor_id)->first();
                                $doc_image = User::where('id', $app->doctor_id)->first();
                                $doc_consult = DoctorConsultationPrices::where('doctor_id', $app->doctor_id)->first();
                                $doc_image = User::where('id', $app->doctor_id)->first();


				$arr = array(
					'id' => $app->id,
					'shdct_id' => $app->shdct_appt_id,
					'date' => $app->date,
					'time' => $app->time_start,
					'datetime' => Carbon::parse($app->date.' '.$app->time_start)->toAtomString(),
					'type' => $app->consultation_type,
					'patient_name' => $det->patient_name,
					'doctor' => array(
'doc_id' => $app->doctor_id,
'video_call_price' => $doc_consult->video_call_price,
'voice_call_price' => $doc_consult->voice_call_price,
'video_call_available' => $doc_consult->video_call_available,
'voice_call_available' => $doc_consult->voice_call_available,
'profile_image' => $doc_image->profile_image,
						'name' => 'Dr. '.$doc_profile->name,
						'shdct_id' => $doc_profile->userData->shdct_user_id,
						'specialty' => ($doc_profile->specialty)?$doc_profile->specialty->specialty->specialty:false,
						'slug' => $doc_profile->slug,
						'specialty_slug' => ($doc_profile->specialty)?$doc_profile->specialty->specialty->slug:false,
						'active' => $doc_profile->userData->active
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
