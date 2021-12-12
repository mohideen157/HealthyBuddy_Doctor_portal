<?php

namespace App\Http\Controllers\Api\Doctor;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Helpers\Helper;

use App\User;
use App\Model\Doctor\DoctorAppointments;
use App\Model\Appointment\AppointmentCallStatus;
use App\Model\Doctor\DoctorLedger;

use App\Model\AdminSettings;

use Carbon\Carbon;

class LedgerController extends Controller
{

	private $settings;

	/**
	 * Instantiate a new AdminDoctorController instance.
	 *
	 * @return void
	 */
	/*public function __construct(){
		$settings = AdminSettings::all();
		$arr = array();
		foreach ($settings as $value) {
			$arr[$value->key] = $value->value;
		}
		$this->settings = $arr;
	}*/


	public function index(){
		try{
			$user = Helper::isUserLoggedIn();

			if (!$user) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => "Unauthorized"], 401);
			}

			$return_arr = array();

			// $shedct_fee = (int)$this->settings['shedct_fee'];

			$appointments = DoctorAppointments::where('doctor_id', $user->id)->orderBy('date', 'desc')->get();

			foreach ($appointments as $app) {
				$pat_user = User::find($app->patient_id);

				$status = $app->appointmentCallStatus;

				$st_text = '';
				$od = '';

				if (!$status) {
					$od = 'Upcoming Appointment';
				}
				else{
					if ($status->status == 1) {
						$st_text = 'Successfully Completed';
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

				$cp = $app->consultation_price;

				$doc_ledger = DoctorLedger::where('doctor_id', $user->id)->where('appointment_id', $app->id)->first();
				$shp = $doc_ledger->shedoctr_fees;
				$docp = $doc_ledger->doctor_fees;

				$arr = array(
					'appointment_id' => $app->shdct_appt_id,
					'date' => $app->date,
					'date_time' => Carbon::parse($app->date.' '.$app->time_start)->toAtomString(),
					'patient_id' => $pat_user->shdct_user_id,
					'transaction_id' => $app->transaction_id,
					'consultation_type' => $app->consultation_type,
					'patient_rs' => $cp,
					'shedoctr_rs' => $shp,
					'doctor_rs' => $docp,
					'other_details' => $od
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