<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\Model\UserRole;
use App\Model\Doctor\DoctorProfile;
use App\Model\Doctor\DoctorAppointments;
use App\Model\Appointment\AppointmentCallStatus;
use App\Model\Payment;
use App\Model\Payments;
use App\Model\Doctor\DoctorLedger;
use App\Model\DoctorCommissionSlabs;

use App\Model\AdminSettings;

use Carbon\Carbon;

class AdminDoctorLedgerController extends Controller
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
		$return_arr = array();

		$active_doctors = DoctorProfile::join('users as u', 'u.id', '=', 'doctor_profile.doctor_id')
											->where('doctor_profile.is_verified', 1)
											->where('u.active', 1)
											->select('doctor_profile.*')
											->get();

		foreach ($active_doctors as $doc) {
			$doc_id = $doc->doctor_id;

			$total_doc_price = DoctorLedger::where('doctor_id', $doc_id)->whereHas('appointmentCallStatus', function($query){
				$query->where('status', 1);
			})->sum('doctor_fees');

			$payments = Payments::where('doctor_id', $doc_id)->where('status', 'Done')->sum('amount');

			$arr = array(
				'id' => $doc->doctor_id,
				'sh_id' => $doc->userData->shdct_user_id,
				'name' => $doc->name,
				'email' => $doc->userData->email,
				'mobile_no' => $doc->userData->mobile_no,
				'paid' => $payments,
				'pending' => $total_doc_price - $payments
			);

			array_push($return_arr, $arr);
		}

		return view('admin.ledger.index')->with(['data' => $return_arr]);
	}

	public function show($id){
		$doctor = DoctorProfile::where('doctor_id', $id)->first();

		if (!$doctor) {
			return redirect('admin/doctors/ledger')->with('error', 'Could not find the doctor');
		}

		$return_arr = array();

		$appointments = DoctorAppointments::where('doctor_id', $id)->orderBy('date', 'desc')->get();

		$total_doc_price = 0;

		foreach ($appointments as $app) {
			$pat_user = User::find($app->patient_id);

			$status = $app->appointmentCallStatus;

			$st_text = '';
			$od = '';

			if (!$status) {
				$od = 'Upcoming Appointment';
				$st_text = 'Upcoming';
			}
			else{
				if ($status->status == 1) {
					$st_text = 'Successfull';
				}
				else{
					if (strpos($status->reason, 'cancel') === false) {
						$st_text = 'Failed';
					}
					else{
						$st_text = 'Cancelled';
					}
				}

				$od = 'Call '.$st_text.'<br />';
				if ($status->status != 1) {
					$od .= 'Reason - '.$status->reason.'<br />';
					$od .= 'Details - '.$status->details;
				}
			}

			$payment_details = Payment::where('appointment_id', $app->id)->first();
			if ($payment_details) {
				$discounted_price = $payment_details->total_price - $payment_details->discount;
			}
			else{
				$discounted_price = $app->consultation_price;
			}

			$cp = $app->consultation_price;

			$doc_ledger = DoctorLedger::where('doctor_id', $id)->where('appointment_id', $app->id)->first();
			$shp = $doc_ledger->shedoctr_fees;
			$docp = $doc_ledger->doctor_fees;

			$arr = array(
				'appointment_id' => $app->shdct_appt_id,
				'date_time' => Carbon::parse($app->date.' '.$app->time_start),
				'patient_id' => $pat_user->shdct_user_id,
				'transaction_id' => $app->transaction_id,
				'consultation_type' => $app->consultation_type,
				'consultation_price' => $cp,
				'patient_rs' => $discounted_price,
				'shedoctr_rs' => $shp,
				'doctor_rs' => $docp,
				'other_details' => $od,
				'status' => $st_text
			);

			array_push($return_arr, $arr);
		}

		$total_paid_to_doctor = Payments::where('doctor_id', $id)->where('status', 'Done')->sum('amount');

		$status_arr = ['' => '', 'Successfull' => 'Success', 'Failed' => 'Failed', 'Cancelled' => 'Cancelled', 'Upcoming' => 'Upcoming'];
		$call_type_arr = ['' => '', 'voice' => 'Voice', 'video' => 'Video'];

		return view('admin.ledger.show')->with([
			'data' => $return_arr,
			'doctor' => $doctor,
			'status_arr' => $status_arr, 
			'call_type_arr' => $call_type_arr, 
			'total_paid_to_doctor' => $total_paid_to_doctor, 
			'total_pending_to_doctor' => $total_doc_price - $total_paid_to_doctor
		]);
	}

	public function createLedger(){
		$doctors = DoctorProfile::all();

		foreach ($doctors as $doc) {
			$doc_id = $doc->doctor_id;

			$shedct_fee = (int)$this->settings['shedct_fee'];
			$appointments = DoctorAppointments::where('doctor_id', $doc_id)->get();

			foreach ($appointments as $app) {
				$cp = $app->consultation_price;
				$shp = ($cp * $shedct_fee)/100;
				$docp = $cp - $shp;

				$ledger = new DoctorLedger();
				$ledger->doctor_id = $doc_id;
				$ledger->appointment_id = $app->id;
				$ledger->shedoctr_fees = $shp;
				$ledger->doctor_fees = $docp;
				$ledger->save();
			}
		}

		echo 'Done';
	}
}
