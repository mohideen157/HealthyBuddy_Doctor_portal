<?php

namespace App\Http\Controllers\Api\Patient;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\Model\Patient\PatientProfile;
use App\Model\Patient\PatientAddress;

use App\Helpers\Helper;

use Validator;
use Carbon\Carbon;
use URL;
use DB;

class ProfileController extends Controller
{
    public function changeProfilePic(Request $request){
		try{
			$user = Helper::isUserLoggedIn();

			if (!$user) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => "Unauthorized"], 401);
			}

			if (!$request->hasFile('file')) {
				return response()->json(['success' => false, 'error' => 'validation_error', 'message' => "Did not get the file to save"]);
			}

			if (!$request->file('file')->isValid()) {
				return response()->json(['success' => false, 'error' => 'upload_error', 'message' => "Did not get a valid file"]);
			}

			$file = $request->file('file');

			$timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
			$image_path = $timestamp. '-' .$file->getClientOriginalName();
			$file->move(public_path().'/uploads/patients/'.$user->shdct_user_id.'/', $image_path);

			$user->profile_image = '/uploads/patients/'.$user->shdct_user_id.'/'.$image_path;
			$user->profile_image_default = 0;
			$user->save();

			return response()->json(['success' => true, 'data' => URL::to('/').$user->profile_image, 'message' => 'Profile Pic Changed']);
		}
		catch(Exception $e){
			return response()->json(['success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"], 500);
		}
	}

	public function shortProfile(){
		try{
			$user = Helper::isUserLoggedIn();

			if (!$user) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => "Unauthorized"], 401);
			}

			$return_arr = array();

			$patient_profile = PatientProfile::where('patient_id', $user->id)->first();
			

			if (!$patient_profile) {
				$name = $user->name;
			}
			else{
				$name = $patient_profile->first_name.' '.$patient_profile->last_name;
			}

			$return_arr = array(
				'name' => $name,
				'email' => $user->email,
				'shdct_id' => $user->shdct_user_id,
				'profile_image' => URL::to('/').$user->profile_image,
				'profile_image_default' => ($user->profile_image_default?true:false),
			);

			return response()->json(['success' => true, 'data' => $return_arr]);
		}
		catch(Exception $e){
			return response()->json(['success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"], 500);
		}
	}

	public function index(){
		try{
			$user = Helper::isUserLoggedIn();

			if (!$user) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => "Unauthorized"], 401);
			}

			$return_arr = array();

			$patient_profile = PatientProfile::where('patient_id', $user->id)->first();

			if ($patient_profile) {
				$address = $patient_profile->addresses()->default()->first();
				$p_address = false;
				if ($address) {
					$p_address = array(
						'line1' => $address->address_line_1,
						'line2' => $address->address_line_2,
						'state' => $address->state,
						'city' => $address->city,
						'pincode' => $address->pincode,
					);
				}

				$return_arr = array(
					'first_name' => $patient_profile->first_name,
					'last_name' => $patient_profile->last_name,
					'dob' => $patient_profile->dob,
					'email' => $user->email,
					'gender' => $patient_profile->gender,
					'height_feet' => $patient_profile->height_feet,
					'height_inch' => $patient_profile->height_inch,
					'blood_group' => $patient_profile->blood_group,
					'weight' => $patient_profile->weight,
					'address' => $p_address
				);
			}

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

			if (count($request->all()) <= 0) {
				return response()->json(['success' => false, 'error' => 'validation_error', 'message' => "Did not get any data to store"]);
			}
			/*if (!$request->has('first_name')
				&& !$request->has('last_name')
				&& !$request->has('dob')
				&& !$request->has('gender')
				&& !$request->has('height_feet')
				&& !$request->has('height_inch')
				&& !$request->has('blood_group')
				&& !$request->has('weight')
				&& !$request->has('address_line_1')
				&& !$request->has('address_line_2')
				&& !$request->has('state')
				&& !$request->has('city')
				&& !$request->has('pincode')) {
				return response()->json(['success' => false, 'error' => 'validation_error', 'message' => "Did not get any data to store"]);
			}*/

			/*$validator = Validator::make($request->all(),[
				'first_name' => 'required',
				'last_name' => 'required',
				'dob' => 'required',
				'gender' => 'required',
				'height_feet' => 'required',
				'height_inch' => 'required',
				'blood_group' => 'required',
				'weight' => 'required',
				'address_line_1' => 'required',
				'state' => 'required',
				'city' => 'required',
				'pincode' => 'required',
			]);

			if ($validator->fails()) {
				return response()->json(['success' => false, 'error' => 'validation_error', 'message' => "Did not get proper input"]);
			}*/

			try{
				DB::beginTransaction();

				$patient_profile = PatientProfile::where('patient_id', $user->id)->first();

				if (!$patient_profile) {
					$patient_profile = new PatientProfile();
					$patient_profile->patient_id = $user->id;
				}

				$save_profile = false;
				$save_address = false;

				if ($request->has('first_name')) {
					$patient_profile->first_name = $request->first_name;
				}
				else{
					$patient_profile->first_name = NULL;
				}

				if ($request->has('last_name')) {
					$patient_profile->last_name = $request->last_name;
				}
				else{
					$patient_profile->last_name = NULL;
				}

				if ($request->has('dob')) {
					$patient_profile->dob = Carbon::parse($request->dob)->toDateString();
				}
				else{
					$patient_profile->dob = NULL;
				}

				if ($request->has('gender')) {
					$patient_profile->gender = $request->gender;
				}
				else{
					$patient_profile->gender = NULL;
				}

				if ($request->has('height_feet')) {
					$patient_profile->height_feet = $request->height_feet;
				}
				else{
					$patient_profile->height_feet = NULL;
				}

				if ($request->has('height_inch')) {
					$patient_profile->height_inch = $request->height_inch;
				}
				else{
					$patient_profile->height_inch = NULL;
				}

				if ($request->has('blood_group')) {
					$patient_profile->blood_group = $request->blood_group;
				}
				else{
					$patient_profile->blood_group = NULL;
				}

				if ($request->has('weight')) {
					$patient_profile->weight = $request->weight;
				}
				else{
					$patient_profile->weight = NULL;
				}


				$address = PatientAddress::where('patient_id', $user->id)->where('default', 1)->first();

				if (!$address) {
					$address = new PatientAddress();
					$address->patient_id = $user->id;
					$address->default = 1;
				}

				if ($request->has('address_line_1')) {
					$address->address_line_1 = $request->address_line_1;
				}
				else{
					$address->address_line_1 = NULL;
				}

				if ($request->has('address_line_2')) {
					$address->address_line_2 = $request->address_line_2;
				}
				else{
					$address->address_line_2 = NULL;
				}

				if ($request->has('state')) {
					$address->state = $request->state;
				}
				else{
					$address->state = NULL;
				}

				if ($request->has('city')) {
					$address->city = $request->city;
				}
				else{
					$address->city = NULL;
				}

				if ($request->has('pincode')) {
					$address->pincode = $request->pincode;
				}
				else{
					$address->pincode = NULL;
				}

				$patient_profile->save();
				$address->save();

				DB::commit();
			}
			catch(Exception $e){
				DB::rollBack();
				return response()->json(array('success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"), 500);
			}

			return response()->json(['success' => true]);
		}
		catch(Exception $e){
			return response()->json(['success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"], 500);
		}
	}
}
