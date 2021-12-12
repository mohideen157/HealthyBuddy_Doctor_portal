<?php

namespace App\Http\Controllers\Api\Doctor;

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

use App\Model\Notification;

use App\Helpers\Helper;

use URL;
use Carbon\Carbon;
use Validator;
use DB;
use PDF;
use Storage;
use Mail;

class PrescriptionController extends Controller
{
	public function index(Request $request){
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

			if ($appointment->doctor_id != $user->id) {
				return response()->json(['success' => false, 'error' => 'not_allowed', 'message' => 'Unauthorized<br />You are trying to access an appointment which belongs to other doctor']);
			}

			$prescription = $appointment->appointmentPrescription;

			if (!$prescription) {
				return response()->json(['success' => false, 'error' => 'not_found', 'message' => 'Prescription not added']);
			}

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
				'next_visit' => $prescription->next_visit,
				'lab_tests' => $p_labtests,
				'medicines' => $p_medicines,
				'date' => $prescription->created_at->toAtomString(),
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

			return response()->json(['success' => true, 'data' => $return_arr]);

		}
		catch(Exception $e){
			return response()->json(['success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"], 500);
		}
	}

	public function appointmentDoctorPatientDetails(Request $request){
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

			if ($appointment->doctor_id != $user->id) {
				return response()->json(['success' => false, 'error' => 'not_allowed', 'message' => 'Unauthorized<br />You are trying to access an appointment which belongs to other doctor']);
			}

			$doctor = DoctorProfile::where('doctor_id', $appointment->doctor_id)->first();

			$appointment_details = AppointmentDetails::where('appointment_id', $appointment->id)
														->where('appointment_type', 1)
														->first();

			$pat_user = User::find($appointment->patient_id);

			$return_arr = array(
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

			return response()->json(['success' => true, 'data' => $return_arr]);

		}
		catch(Exception $e){
			return response()->json(['success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"], 500);
		}
	}
	
	public function store(Request $request){
		try{
			$user = Helper::isUserLoggedIn();

			if (!$user) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => "Unauthorized"], 401);
			}

			if (!$request->has('appointment_id')) {
				return response()->json(['success' => false, 'error' => 'validation_error', 'message' => 'Did not get the appointment id']);
			}

			if (!$request->has('report')) {
				return response()->json(['success' => false, 'error' => 'validation_error', 'message' => 'Did not get the diagnosis report']);
			}

			$appointment = DoctorAppointments::find($request->appointment_id);

			if (!$appointment) {
				return response()->json(['success' => false, 'error' => 'not_found', 'message' => 'We could not find the appointment']);
			}

			if ($appointment->doctor_id != $user->id) {
				return response()->json(['success' => false, 'error' => 'not_allowed', 'message' => 'Unauthorized<br />You are trying to access an appointment which belongs to other doctor']);
			}

			try{
				DB::beginTransaction();

				$prescription = new AppointmentPrescription();
				$prescription->appointment_id = $appointment->id;
				$prescription->diagnosis_report = $request->report;
				if ($request->has('next_visit')) {
					$prescription->next_visit = Carbon::parse($request->next_visit)->toDateString();
				}
				$prescription->save();

				$prescription_id = $prescription->id;

				$lt_arr = array();
				if ($request->has('lab_tests')) {
					if (!empty($request->lab_tests)) {
						foreach ($request->lab_tests as $lt) {
							array_push($lt_arr, $lt);

							$lab_test = new AppointmentPrescriptionLabTest();
							$lab_test->prescription_id = $prescription_id;
							$lab_test->lab_test = $lt;
							$lab_test->save();
						}
					}
				}

				if ($request->has('other_lab_tests')) {
					$olt = explode(',', $request->other_lab_tests);
					foreach ($olt as $lt) {
						array_push($lt_arr, trim($lt));

						$lab_test = new AppointmentPrescriptionLabTest();
						$lab_test->prescription_id = $prescription_id;
						$lab_test->lab_test = trim($lt);
						$lab_test->save();
					}
				}

				$md_arr = array();
				if ($request->has('medicines')) {
					if (!empty($request->medicines)) {
						foreach ($request->medicines as $m) {
							if (array_key_exists('name', $m) && array_key_exists('type', $m)) {
								$arr = array(
									'name' => $m['name'],
									'type' => $m['type'],
									'morning' => '',
									'afternoon' => '',
									'evening' => '',
									'night' => '',
									'note' => ''
								);

								$medicine = new AppointmentPrescriptionMedicines();
								$medicine->prescription_id = $prescription_id;
								$medicine->medicine_name = $m['name'];
								$medicine->medicine_type = $m['type'];
								
								if (array_key_exists('morning', $m)) {
									$arr['morning'] = $m['morning'];

									$medicine->morning = $m['morning'];
								}

								if (array_key_exists('afternoon', $m)) {
									$arr['afternoon'] = $m['afternoon'];

									$medicine->afternoon = $m['afternoon'];
								}

								if (array_key_exists('evening', $m)) {
									$arr['evening'] = $m['evening'];

									$medicine->evening = $m['evening'];
								}

								if (array_key_exists('night', $m)) {
									$arr['night'] = $m['night'];

									$medicine->night = $m['night'];
								}

								if (array_key_exists('note', $m)) {
									$arr['note'] = $m['note'];

									$medicine->note = $m['note'];
								}

								array_push($md_arr, $arr);

								$medicine->save();
							}
						}
					}
				}

				$doctor = DoctorProfile::where('doctor_id', $appointment->doctor_id)->first();

				$appointment_details = AppointmentDetails::where('appointment_id', $appointment->id)
															->where('appointment_type', 1)
															->first();

				$pat_user = User::find($appointment->patient_id);

				$arr = array(
					'report' => $request->report,
					'next_visit' => ($request->has('next_visit'))?Carbon::parse($request->next_visit)->toFormattedDateString():NULL,
					'lab_tests' => $lt_arr,
					'medicines' => $md_arr,
					'date' => Carbon::now()->toFormattedDateString(),
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

				$path = $appointment->shdct_appt_id.'.pdf';

				$pdf = PDF::loadView('pdf.prescription', $arr);

				Storage::disk('prescriptions')->put($path, $pdf->output());
				
				$prescription->file_path = $path;
				$prescription->save();

				DB::commit();
			}
			catch(Exception $e){
				DB::rollBack();
				return response()->json(array('success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"), 500);
			}

			// Add Notification
			$pat_user->newNotification()
					 ->withType('PrescriptionAdded')
					 ->withSubject('Prescription Added By Doctor')
					 ->withBody('Dr. '.$doctor->name.' has added the prescription for appointment ID: '.$appointment->shdct_appt_id)
					 ->regarding($prescription)
					 ->deliver();

			// Send Mail
			$sendemail = Mail::send('emails.patient.prescriptionAdded', array('doctor_name' => $doctor->name, 'appt_id' => $appointment->shdct_appt_id), function ($message) use ($pat_user)
			{
				$message->to($pat_user->email, $pat_user->name);
				$message->subject('SheDoctr - Prescription Added');
			});

			// Send SMS
			$msgtxt = 'Dr. '.$doctor->name.' has added a prescription for your appointment ID: '.$appointment->shdct_appt_id.' Please check prescriptions tab in your dashboard';

			$msgData = array(
				'recipient_no' => $pat_user->mobile_no,
				'msgtxt' => $msgtxt
			);

			$sendsms = Helper::sendSMS($msgData);

			return response()->json(['success' => true, 'message' => 'Prescription Saved']);
		}
		catch(Exception $e){
			return response()->json(['success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"], 500);
		}
	}

	public function preview(Request $request){			
		try{
			$user = Helper::isUserLoggedIn();

			if (!$user) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => "Unauthorized"], 401);
			}

			if (!$request->has('appointment_id')) {
				return response()->json(['success' => false, 'error' => 'validation_error', 'message' => 'Did not get the appointment id']);
			}

			if (!$request->has('report')) {
				return response()->json(['success' => false, 'error' => 'validation_error', 'message' => 'Did not get the diagnosis report']);
			}

			$appointment = DoctorAppointments::find($request->appointment_id);

			if (!$appointment) {
				return response()->json(['success' => false, 'error' => 'not_found', 'message' => 'We could not find the appointment']);
			}

			if ($appointment->doctor_id != $user->id) {
				return response()->json(['success' => false, 'error' => 'not_allowed', 'message' => 'Unauthorized<br />You are trying to access an appointment which belongs to other doctor']);
			}

			$lt_arr = array();
			if ($request->has('lab_tests')) {
				if (!empty($request->lab_tests)) {
					foreach ($request->lab_tests as $lt) {
						array_push($lt_arr, $lt);
					}
				}
			}

			if ($request->has('other_lab_tests')) {
				$olt = explode(',', $request->other_lab_tests);
				foreach ($olt as $lt) {
					array_push($lt_arr, trim($lt));
				}
			}

			$md_arr = array();
			if ($request->has('medicines')) {
				if (!empty($request->medicines)) {
					foreach ($request->medicines as $m) {
						if (array_key_exists('name', $m) && array_key_exists('type', $m)) {
							$arr = array(
								'name' => $m['name'],
								'type' => $m['type'],
								'morning' => '',
								'afternoon' => '',
								'evening' => '',
								'night' => '',
								'note' => ''
							);
							
							if (array_key_exists('morning', $m)) {
								$arr['morning'] = $m['morning'];
							}

							if (array_key_exists('afternoon', $m)) {
								$arr['afternoon'] = $m['afternoon'];
							}

							if (array_key_exists('evening', $m)) {
								$arr['evening'] = $m['evening'];
							}

							if (array_key_exists('night', $m)) {
								$arr['night'] = $m['night'];
							}

							if (array_key_exists('note', $m)) {
								$arr['note'] = $m['note'];
							}

							array_push($md_arr, $arr);
						}
					}
				}
			}

			$doctor = DoctorProfile::where('doctor_id', $appointment->doctor_id)->first();

			$appointment_details = AppointmentDetails::where('appointment_id', $appointment->id)
														->where('appointment_type', 1)
														->first();

			$pat_user = User::find($appointment->patient_id);

			$arr = array(
				'report' => $request->report,
				'next_visit' => ($request->has('next_visit'))?Carbon::parse($request->next_visit)->toFormattedDateString():NULL,
				'lab_tests' => $lt_arr,
				'medicines' => $md_arr,
				'date' => Carbon::now()->toFormattedDateString(),
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
			$pdf = PDF::loadView('pdf.prescription', $arr);
			return $pdf->stream('presciption.pdf');
		}
		catch(Exception $e){
			return response()->json(['success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"], 500);
		}
	}
}