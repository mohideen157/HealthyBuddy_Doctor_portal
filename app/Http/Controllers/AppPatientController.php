<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Model\Patient\PatientProfile;
use App\Model\Patient\PatientCredits;

use App\Helpers\Helper;

class AppPatientController extends Controller
{
    public function getPatientProfile(){
    	try{
    		$user = Helper::isUserLoggedIn();

			if (!$user) {
				return response()->json(array('success' => false, 'error' => 'auth_error', 'message' => "Unauthorized"), 401);
			}
			
			// If not patient return
			if ($user->userRole->user_role != 'patient') {
				return response()->json(['success' => false, 'error' => 'invalid_user', 'message' => 'You are not allowed to fetch patient profile']);
			}

			$ret = array(
				'name' => $user->name,
				'gender' => '',
				'height_feet' => '',
				'height_inches' => '',
				'blood_group' => '',
				'weight' => ''
			);

			$patient_profile = PatientProfile::where('patient_id', $user->id)->first();

			if (!$patient_profile) {
				return response()->json(['success' => true, 'data' => $ret, 'message' => 'Profile not yet created']);
			}

			$ret = array(
				'name' => $patient_profile->first_name.' '.$patient_profile->last_name,
				'gender' => $patient_profile->gender,
				'height_feet' => ($patient_profile->height_feet)?(int)$patient_profile->height_feet:NULL,
				'height_inches' => ($patient_profile->height_inch)?(int)$patient_profile->height_inch:NULL,
				'blood_group' => $patient_profile->blood_group,
				'weight' => $patient_profile->weight
			);

			return response()->json(['success' => true, 'data' => $ret, 'message' => 'Patient Profile']);			
    	}
    	catch(Exception $e){
    		return response()->json(array('success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"), 500);
    	}
    }

    public function getPatientCredits(){
    	try{
    		$user = Helper::isUserLoggedIn();

			if (!$user) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => "Unauthorized"], 401);
			}

			$credits = PatientCredits::where('patient_id', $user->id)->value('credits');

			if (!$credits) {
				$credits = 0;
			}

			return response()->json(['success' => true, 'data' => ['credits' => $credits] ]);
    	}
    	catch(Exception $e){
    		return response()->json(array('success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"), 500);
    	}
    }
}
