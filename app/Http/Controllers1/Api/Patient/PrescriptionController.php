<?php

namespace App\Http\Controllers\Api\Patient;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\Model\Doctor\DoctorProfile;
use App\Model\Doctor\DoctorAppointments;
use App\Model\Appointment\AppointmentDetails;

use App\Model\Appointment\AppointmentPrescription;
use App\Model\Appointment\AppointmentPrescriptionLabTest;
use App\Model\Appointment\AppointmentPrescriptionMedicines;

use App\Helpers\Helper;

use URL;
use Carbon\Carbon;
use Validator;
use DB;
use PDF;
use Storage;

class PrescriptionController extends Controller
{
	public function index(){
		try{
			$user = Helper::isUserLoggedIn();

			if (!$user) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => "Unauthorized"], 401);
			}

			$return_arr = array();

			$appointments = DoctorAppointments::where('patient_id', $user->id)
												->whereRaw('CONCAT(date, " " ,time_start) <= now()')
												->orderBy('date', 'desc')
												->orderBy('time_start' ,'desc')
												->has('appointmentPrescription')
												->get();

			foreach ($appointments as $app) {
				$det = AppointmentDetails::where('appointment_id', $app->id)
											->where('appointment_type', 1)
											->first();

				if (empty($det)) {
					continue;
				}

				$doc_profile = DoctorProfile::where('doctor_id', $app->doctor_id)->first();

				$arr = array(
					'app_id' => $app->id,
					'shdct_id' => $app->shdct_appt_id,
					'datetime' => Carbon::parse($app->date.' '.$app->time_start)->toAtomString(),
					'patient_name' => $det->patient_name,
					'doctor' => array(
						'name' => 'Dr. '.$doc_profile->name,
						'specialty' => ($doc_profile->specialty)?$doc_profile->specialty->specialty->specialty:false,
					)
				);

				array_push($return_arr, $arr);
			}

			return response()->json(['success' => true, 'data' => $return_arr]);
		}
		catch(Exception $e){
			return response()->json(['success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"], 500);
		}
	}

    public function show($id){
    	try{
			$user = Helper::isUserLoggedIn();

			if (!$user) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => "Unauthorized"], 401);
			}

			$appointment = DoctorAppointments::find($id);

			if (!$appointment) {
				return response()->json(['success' => false, 'error' => 'not_found', 'message' => 'We could not find the appointment']);
			}

			if ($appointment->patient_id != $user->id) {
				return response()->json(['success' => false, 'error' => 'not_allowed', 'message' => 'Unauthorized<br />You are trying to access an appointment which belongs to other patient']);
			}

			$prescription = $appointment->appointmentPrescription;

			if (!$prescription) {
				return response()->json(['success' => false, 'error' => 'not_found', 'message' => 'Prescription not added']);
			}

			$filename = $prescription->file_path;

			if (Storage::disk('prescriptions')->has($filename)) {
				$file = storage_path('app/prescriptions/'.$filename);
				return response()->download($file);
			}
			else{
				$doctor = DoctorProfile::where('doctor_id', $appointment->doctor_id)->first();

				$appointment_details = AppointmentDetails::where('appointment_id', $appointment->id)
															->where('appointment_type', 1)
															->first();

				$lab_tests = $prescription->labtests;
				$p_labtests = array();
				foreach ($lab_tests as $lt) {
					array_push($p_labtests, $lt->lab_test);
				}

				$medicines = $prescription->medicines;
				$p_medicines = array();
				foreach ($medicines as $m) {
					$arr = array(
						'name' => $m->medicine_name,
						'type' => $m->medicine_type,
						'morning' => $m->morning,
						'afternoon' => $m->afternoon,
						'evening' => $m->evening,
						'night' => $m->night,
						'note' => $m->note
					);
					array_push($p_medicines, $arr);
				}

				$pat_user = User::find($appointment->patient_id);

				$return_arr = array(
					'report' => $prescription->diagnosis_report,
					'next_visit' => $prescription->next_visit?Carbon::parse($prescription->next_visit)->toFormattedDateString():NULL,
					'lab_tests' => $p_labtests,
					'medicines' => $p_medicines,
					'date' => $prescription->created_at->toFormattedDateString(),
					'doctor' => array(
						'name' => 'Dr. '.$doctor->name,
						'specialty' => $doctor->specialty->specialty->specialty,
						'registration_no' => $doctor->registration_no,
						'signature' => $doctor->signature->image
					),
					'patient' => array(
						'name' => $appointment_details->patient_name,
						'shedct_id' => $pat_user->shdct_user_id
					)
				);

				$pdf = PDF::loadView('pdf.prescription', $return_arr);
				$stream = $pdf->stream('presciption.pdf');

				return $stream;
			}
		}
		catch(Exception $e){
			return response()->json(['success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"], 500);
		}
    }
}
