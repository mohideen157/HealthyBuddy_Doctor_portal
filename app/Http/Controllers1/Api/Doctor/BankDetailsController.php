<?php

namespace App\Http\Controllers\Api\Doctor;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\Doctor\DoctorBankDetails;

use App\Helpers\Helper;

use Validator;
use Crypt;

class BankDetailsController extends Controller
{
	public function index(){
		try{
			$user = Helper::isUserLoggedIn();

			if (!$user) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => "Unauthorized"], 401);
			}

			$return_arr = array();
			
			$bank_details = DoctorBankDetails::where('doctor_id', $user->id)->first();

			if (isset($bank_details)) {
				$return_arr = array(
					'bname' => $bank_details->bname,
					'bank_name' => $bank_details->bank_name,
					'account_type' => $bank_details->account_type,
					'ifsc' => $bank_details->ifsc,
					'account_no' => Crypt::decrypt($bank_details->account_no)
				);
			}

			return response()->json(['success' => true, 'data' => $return_arr]);
		}
		catch(Exception $e){
			return response()->json(['success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"], 500);
		}
	}

	public function create(Request $request){
		try{
			$user = Helper::isUserLoggedIn();

			if (!$user) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => "Unauthorized"], 401);
			}

			$validator = Validator::make($request->all(),[
				'bname' => 'required',
				'bank_name' => 'required',
				'ifsc' => 'required',
				'account_type' => 'required',
				'account_no' => 'required',
			]);

			if ($validator->fails()) {
				return response()->json(['success' => false, 'error' => 'validation_error', 'message' => "Did not get proper input"]);
			}

			$bank_details = DoctorBankDetails::where('doctor_id', $user->id)->first();

			if (isset($bank_details)) {
				return response()->json(['success' => false, 'error' => 'bank_already_added', 'message' => "A bank is already added to your account.<br />Please remove it to add a new account"]);
			}

			$bank_details = new DoctorBankDetails();
			$bank_details->doctor_id = $user->id;
			$bank_details->bname = $request->bname;
			$bank_details->bank_name = $request->bank_name;
			$bank_details->account_type = $request->account_type;
			$bank_details->ifsc = $request->ifsc;
			$bank_details->account_no = Crypt::encrypt($request->account_no);

			$bank_details->save();

			$return_arr = array(
				'bname' => $request->bname,
				'bank_name' => $request->bank_name,
				'account_type' => $request->account_type,
				'ifsc' => $request->ifsc,
				'account_no' => $request->account_no
			);

			return response()->json(['success' => true, 'data' => $return_arr, 'message' => 'Bank Details Saved']);

		}
		catch(Exception $e){
			return response()->json(['success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"], 500);
		}
	}

	public function delete(){
		try{
			$user = Helper::isUserLoggedIn();

			if (!$user) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => "Unauthorized"], 401);
			}

			$bank_details = DoctorBankDetails::where('doctor_id', $user->id)->delete();

			return response()->json(['success' => true, 'message' => 'Bank Details Removed']);
		}
		catch(Exception $e){
			return response()->json(['success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"], 500);
		}
	}
}
