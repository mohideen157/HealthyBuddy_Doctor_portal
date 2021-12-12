<?php

namespace App\Http\Controllers\Api\Receptionist;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Helpers\Helper;

use App\Model\Doctor\DoctorReceptionist;

use App\User;

class DoctorStatusController extends Controller
{
    public function index(){
    	try{
			$user = Helper::isUserLoggedIn();

			if (!$user) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => "Unauthorized"], 401);
			}
			$return_arr = array();

			$doc_receptionist = DoctorReceptionist::where('receptionist_id', $user->id)->first();

			$doctor = User::find($doc_receptionist->doctor_id);

			$return_arr = array(
				'online' => $doctor->online,
				'doctor_id' => $doc_receptionist->doctor_id
			);

			return response()->json(['success' => true, 'data' => $return_arr]);
		}
		catch(Exception $e){
			return response()->json(['success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"], 500);
		}
    }

    public function update(Request $request){
    	try{
			$user = Helper::isUserLoggedIn();

			if (!$user) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => "Unauthorized"], 401);
			}

			if (!$request->has('status')) {
				return response()->json(['success' => false, 'error' => 'validation_error', 'message' => "Did not get the status to change to"]);
			}

			$doc_receptionist = DoctorReceptionist::where('receptionist_id', $user->id)->first();

			$doc_user = User::find($doc_receptionist->doctor_id);

			$doc_user->online = (int)$request->status;
			$doc_user->save();

			return response()->json(['success' => true, 'message' => 'Status Changed']);
		}
		catch(Exception $e){
			return response()->json(['success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"], 500);
		}
    }
}
