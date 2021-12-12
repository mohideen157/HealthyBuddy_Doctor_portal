<?php

namespace App\Http\Controllers\Api\Patient;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Helpers\Helper;

use App\Model\Patient\PatientCredits;
use App\Model\Patient\PatientCreditLogs;

use Carbon\Carbon;

class CreditsController extends Controller
{
	public function index(){
		try{
			$user = Helper::isUserLoggedIn();

			if (!$user) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => "Unauthorized"], 401);
			}

			$return_arr = array();

			$credit_logs = PatientCreditLogs::where('patient_id', $user->id)->orderBy('id', 'desc')->get();

			foreach ($credit_logs as $log) {
				$arr = array(
					'remarks' => $log->remarks,
					'type' => $log->type,
					'delta' => $log->delta,
					'date' => Carbon::parse($log->transaction_date)->toAtomString()
				);

				array_push($return_arr, $arr);
			}

			$total_credits = PatientCredits::where('patient_id', $user->id)->value('credits');

			return response()->json(['success' => true, 'data' => [ 'total_credits' => (int)$total_credits, 'history' => $return_arr ]]);
		}
		catch(Exception $e){
			return response()->json(['success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"], 500);
		}
	}
}
