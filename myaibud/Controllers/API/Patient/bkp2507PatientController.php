<?php

namespace Myaibud\Controllers\API\Patient;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Resources\PatientDetailsResource;
use App\Http\Resources\PatientProfileResource;
use App\Medication;
use App\Model\Patient\PatientProfile;
use App\User;
use Auth, Log;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Myaibud\Traits\ProfileScoring;

class PatientController extends Controller
{
	use ProfileScoring;

	public function getProfileImage()
	{
		$patient = Auth::user();

		if (!empty(glob( public_path() . '/images/' . $patient->id  . '.*') ) ) {
			$extension = pathinfo( glob( public_path() . '/images/' . $patient->id  . '.*')[0])['extension'];
			return  response()->json([
				'success' => true,
				'image_url' => url('/images/' . $patient->id . '.' . $extension)
			]);
		}
		return  response()->json([
			'success' => true,
			'image_url' => 'No profile image found'
		]);
	}

	public function upsertProfileImage(Request $request)
	{
		$patient = Auth::user();

		$profileImage = $request->file('app_image'); 
		if ($profileImage) {

			$path = public_path().'/images/';
			$this->removeOldProfileImage($patient->id);
			
			$extension = $profileImage->getClientOriginalExtension();
			// we have an image, get the image data
			// $data = base64_encode(file_get_contents($_FILES['app_image']['tmp_name']));
			$fileName = $patient->id . '.' . $extension;

			if ($profileImage->move($path, $fileName)) {

				// Save image path in database
				$patient->profile_image = 'images/'.$fileName;
				$patient->save();

				return response()->json([
					'success' => true,
					'image_url' => url('/images/' . $fileName)
				]);
			} else {
				return response()->json([
					'success' => false,
					'message' => 'Cant upload profile image, try again later'
				]);
			}

		} else {
			return response()->json([
				'success' => false,
				'message' => 'Please select any image'
			]);
		}
	}

	
	public function removeOldProfileImage($patientId) 
	{
		$path = public_path().'/images/';
		$file_pattern = $path . $patientId . ".*";
		array_map( "unlink", glob( $file_pattern ) );
	}


	public function getProfile()
	{
		$patient = Auth::user();
		$data = [];
		$data['patient_id'] = '';
		if ($patient->patientProfile()->first()) {
			$data = $patient->patientProfile()->first()->toArray();
		}
		$data['age'] = Helper::age($data['dob']);
		$data['name'] = $patient->name;
		$data['image_url'] = '';
		if (!empty(glob( public_path() . '/images/' . $patient->id  . '.*') ) ) {
			$extension = pathinfo( glob( public_path() . '/images/' . $patient->id  . '.*')[0])['extension'];
			$data['image_url']= url('/images/' . $patient->id . '.' . $extension);
		}
		return  response()->json([
			'success' => true,
			'data' => $data
		]);
	}

	public function get_patient_info(Request $request){

		$data = array();
		$patientProfile = PatientProfile::wherePatientId(Auth::id())
										->first();

		if($patientProfile){
			if($request->key == 'height'){
				$data = [
					'height_feet' => $patientProfile->height_feet,
					'height_cm' => $patientProfile->height_cm
				];
			}
			elseif($request->key == 'weight'){
				$data = [
					'weight_kg' => $patientProfile->weight_kg,
					'weight_pounds' => $patientProfile->weight_pounds	
				];
			}
			elseif($request->key == 'blood-group'){
				$data = [
					'blood_group' => $patientProfile->blood_group
				];
			}
			elseif($request->key == 'occupation'){
				$data = [
					'occupation' => $patientProfile->occupation
				];
			}
			else{
				$data = [
					'national_id' => $patientProfile->national_id,
					'dob' => $patientProfile->dob,
					'gender' => $patientProfile->gender
				];
			}
			return response()->json(['success' => true, 'message' => 'Patient Info', 'data' => $data]);
		}	
		return response()->json(['success' => false, 'message' => 'No Containt Found']);
	}

	public function upsertProfile(Request $request)
	{
		$patient = Auth::user();
		if (!empty($request->name)) {
			$patient->name = $request->name;
			$patient->save(); 
		}
		$request->request->remove('name');

		if ($patient->patientProfile()->count() <= 0 ) {
			if ($patient->patientProfile()->create($request->all())) {
				$this->calculateBmiScore($patient->patientProfile());
			}
		}
		if ($patient->patientProfile()->update($request->all())) {
			$this->calculateBmiScore($patient->patientProfile());
		}
		return response()->json(['success' => true, 'message' => 'Profile Created']);
	}


	public function show_profile(){

		$patient = Auth::user();

		$heightIsThere = false;
		$weightIsThere = false;

		if($patient->patientProfile){
			if (!empty($patient->patientProfile->height_feet) ||
			!empty($patient->patientProfile->height_inch) ||
			!empty($patient->patientProfile->height_cm)  ) {
				$heightIsThere = true;
			}

			if (
			!empty($patient->patientProfile->weight_kg) ||
			!empty($patient->patientProfile->weight_pounds)) {
				$weightIsThere = true;
			}
			
			if ($heightIsThere && $weightIsThere) {
				return response()->json(['success' => false, 'data' => false]);
			} 
			else {
				return response()->json(['success' => true, 'data' => true]);
			}
		}

		return response()->json(['success' => true, 'data' => true]);
	}


	public function getPatientProfile($id){
		$patient = User::with([
								'patientProfile',
								'organistion:id,name',
								'patientHealthProfile',
						])
						->where('id', $id)
						->where('user_role', 4)
						->first();

		if(!empty($patient)){
			$patient = new PatientDetailsResource($patient);
			return response()->json(['status' => true, 'status code' => 200, 'message' => 'Patient Details', 'data' => $patient]);
		}
		return response()->json(['status' => true, 'status code' => 404, 'message' => 'Not Containt Found']);
	}
}