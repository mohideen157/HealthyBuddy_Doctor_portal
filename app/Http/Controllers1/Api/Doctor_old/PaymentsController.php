<?php

namespace App\Http\Controllers\Api\Doctor;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Helpers\Helper;

use App\User;

use App\Model\Payments;

class PaymentsController extends Controller
{
	public function index(){
		try{
			$user = Helper::isUserLoggedIn();

			if (!$user) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => "Unauthorized"], 401);
			}

			$return_arr = array();

			$payments = Payments::where('doctor_id', $user->id)->orderBy('payment_date', 'desc')->get();

			foreach ($payments as $pay) {

				$arr = array(
					'date' => $pay->payment_date,
					'amount' => $pay->amount,
					'transaction_id' => $pay->transaction_id,
					'status' => $pay->status,
					'remarks' => nl2br($pay->remarks)
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
