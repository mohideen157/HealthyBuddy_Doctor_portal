<?php

namespace App\Http\Controllers\Api\Doctor;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\Model\Doctor\DoctorAppointments;
use App\Model\Doctor\DoctorProfile;
use App\Model\Doctor\DoctorAwards;
use App\Model\Doctor\DoctorEducation;
use App\Model\Doctor\DoctorLanguages;
use App\Model\Doctor\DoctorLocation;
use App\Model\Doctor\DoctorMedicineType;
use App\Model\Doctor\DoctorServices;
use App\Model\Doctor\DoctorSpecialization;
use App\Model\Doctor\DoctorSpecialty;
use App\Model\Doctor\DoctorSubSpecialty;

use App\Helpers\Helper;

use Validator;
use Carbon\Carbon;
use URL;

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
			$file->move(public_path().'/uploads/doctors/'.$user->id.'/', $image_path);

			$user->profile_image = '/uploads/doctors/'.$user->id.'/'.$image_path;
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

			$doctor_profile = DoctorProfile::where('doctor_id', $user->id)->first();

			$doc_arr = array();
			if ($doctor_profile->documents) {
				$documents = $doctor_profile->documents;
				
				$doc_arr = array(
					'degree' => ($documents->medical_degree)?URL::to('/').$documents->medical_degree:false,
					'degree_verified' => $documents->medical_degree_verified?'Verified':($documents->medical_degree_reject_reason?'Rejected':'Under Review'),
					'medical_degree_reject_reason' => $documents->medical_degree_reject_reason,
					'government_id' => ($documents->government_id)?URL::to('/').$documents->government_id:false,
					'government_id_verified' => $documents->government_id_verified?'Verified':($documents->government_id_reject_reason?'Rejected':'Under Review'),
					'government_id_reject_reason' => $documents->government_id_reject_reason,
					'medical_registration_certificate' => ($documents->medical_registration_certificate)?URL::to('/').$documents->medical_registration_certificate:false,
					'medical_registration_certificate_verified' => $documents->medical_registration_certificate_verified?'Verified':($documents->medical_registration_certificate_reject_reason?'Rejected':'Under Review'),
					'medical_registration_certificate_reject_reason' => $documents->medical_registration_certificate_reject_reason,
				);
			}

			$doc_profile_complete = true;
			if (!$doctor_profile->prefix
				|| !$doctor_profile->name
				|| !$doctor_profile->gender
				|| !$doctor_profile->experience
				|| !$doctor_profile->self_details
				|| !$doctor_profile->location
				|| !$doctor_profile->specialty
				|| !$doctor_profile->medicineType
				|| count($doctor_profile->languages) == 0
				|| count($doctor_profile->education) == 0
				// || count($doctor_profile->awards) == 0
				// || count($doctor_profile->services) == 0
				|| count($doctor_profile->specialization) == 0) {
				$doc_profile_complete = false;
			}

			$prescription_pending = false;

			$appointment = DoctorAppointments::where('doctor_id', $user->id)
												->whereRaw('CONCAT(date, " " ,time_start) <= now()')
												->whereHas('appointmentCallStatus', function($query){
													$query->where('status', 1);
												})
												->has('appointmentPrescription', '<', 1)
												->first();

			if ($appointment) {
				$prescription_pending = array(
					'id' => $appointment->id
				);
			}
//print_r($doctor_profile->specialty);exit;
			$return_arr = array(
				'prefix' => $doctor_profile->prefix,
				'name' => $doctor_profile->name,
				'shedct_id' => $user->shdct_user_id,
				'profile_image' => URL::to('/').$user->profile_image,
				'profile_image_default' => ($user->profile_image_default?true:false),
				'signature_uploaded' => ($doctor_profile->signature?true:false),
				'consultation_time_fees' => (count($doctor_profile->consultationPrices) > 0?true:false),
				'bank_details' => (count($doctor_profile->bankDetails) > 0)?true:false,
				'online' => $user->online,
				'specialty' => ($doctor_profile->specialty?$doctor_profile->specialty->specialty->specialty:false),
				'profile_complete' => $doc_profile_complete,
				'registration_no' => $doctor_profile->registration_no,
				'is_verified' => ($doctor_profile->is_verified?true:false),
				'documents' => $doc_arr,
				'prescription_pending' => $prescription_pending
			);

			return response()->json(['success' => true, 'data' => $return_arr, 'message' => 'Doctor Short Profile']);
		}
		catch(Exception $e){
			return response()->json(['success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"], 500);
		}
	}

	public function statusToggle(Request $request){
		try{
			$user = Helper::isUserLoggedIn();

			if (!$user) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => "Unauthorized"], 401);
			}

			if (!$request->has('status')) {
				return response()->json(['success' => false, 'error' => 'validation_error', 'message' => "Did not get the status to change to"]);
			}

			$user->online = (int)$request->status;
			$user->save();

			return response()->json(['success' => true, 'message' => 'Status Changed']);
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

			$doctor = DoctorProfile::where('doctor_id', $user->id)->first();

			$d_languages = array();
			$d_mother_tongue = '';
			foreach ($doctor->languages as $dl) {
				$language = $dl->language;
				if ($dl->mother_tongue == 1) {
					$d_mother_tongue = $language->id;
				}
				else{
					array_push($d_languages, $language->id);
				}
			}

			$d_address_line_1 = '';
			$d_address_line_2 = '';
			$d_state = '';
			$d_city = '';
			$d_pincode = '';
			if ($doctor->location) {
				$d_address_line_1 = $doctor->location->address_line_1;
				$d_address_line_2 = $doctor->location->address_line_2;
				$d_state = $doctor->location->state;
				$d_city = $doctor->location->city;
				$d_pincode = $doctor->location->pincode;
			}

			$d_specialty = '';
			if ($doctor->specialty) {
				if ($doctor->specialty->specialty) {
					$d_specialty = $doctor->specialty->specialty->id;
				}
			}

			$d_subspecialty = array();
			if ($doctor->subspecialty) {
				foreach ($doctor->subspecialty as $dsp) {
					if ($dsp->specialty) {
						array_push($d_subspecialty, $dsp->specialty->id);
					}					
				}
			}

			$d_medicine_type = '';
			if ($doctor->medicineType) {
				if ($doctor->medicineType->medicineType) {
					$d_medicine_type = $doctor->medicineType->medicineType->id;
				}
			}

			$d_education = array();
			if ($doctor->education) {
				$d_education = $doctor->education;
			}

			$d_specialization = array();
			if ($doctor->specialization) {
				foreach ($doctor->specialization as $dsp) {
					array_push($d_specialization, $dsp->specialization);
				}
			}

			$d_services = array();
			if ($doctor->services) {
				foreach ($doctor->services as $ds) {
					array_push($d_services, $ds->service);
				}
			}

			$d_awards = array();
			if ($doctor->awards) {
				$d_awards = $doctor->awards;
			}

			$return_arr = array(
				'id' => $doctor->doctor_id,
				'email' => $doctor->userdata->email,
				'mobile' => $doctor->userdata->mobile_no,
				'prefix' => $doctor->prefix,
				'name' => $doctor->name,
				'registration_no' => $doctor->registration_no,
				'gender' => $doctor->gender,
				'self_details' => $doctor->self_details,
				'experience' => $doctor->experience,
				'specialty' => $d_specialty,
				'subspecialty' => $d_subspecialty,
				'languages' => $d_languages,
				'mother_tongue' => $d_mother_tongue,
				'medicine_type' => $d_medicine_type,
				'address_line_1' => $d_address_line_1,
				'address_line_2' => $d_address_line_2,
				'state' => $d_state,
				'city' => $d_city,
				'pincode' => $d_pincode,				
				'education' => $d_education,
				'specialization' => $d_specialization,
				'services' => $d_services,
				'awards' => $d_awards
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

			$d = DoctorProfile::where('doctor_id', $user->id)->first();

			if ($request->has('prefix')) {
				$d->prefix = $request->prefix;
			}
			if ($request->has('name')) {
				$d->name = $request->name;
			}
			if ($request->has('gender')) {
				$d->gender = $request->gender;
			}
			if ($request->has('experience')) {
				$d->experience = $request->experience;
			}
			if ($request->has('self_details')) {
				$d->self_details = $request->self_details;
			}

			$d->save();

			// Update Specialty
			if ($request->has('specialty')) {
				if ($d->specialty) {
					$sp = DoctorSpecialty::find($d->specialty->id);
				}
				else{
					$sp = new DoctorSpecialty();
					$sp->doctor_id = $user->id;
				}
				$sp->specialty_id = $request->specialty;
				$sp->save();
			}
			

			// Update SubSpecialty
			if ($request->has('subspecialty')) {
				$d_subspecialty = array();
				foreach ($d->subspecialty as $value) {
					array_push($d_subspecialty, $value->specialty->id);
				}

				$subspecialty_to_add = array_diff($request->subspecialty, $d_subspecialty);
				$subspecialty_to_delete = array_diff($d_subspecialty, $request->subspecialty);

				if (!empty($subspecialty_to_delete)) {
					DoctorSubSpecialty::where('doctor_id', $user->id)
										->whereIn('specialty_id', $subspecialty_to_delete)
										->delete();
				}

				if (!empty($subspecialty_to_add)) {
					foreach ($subspecialty_to_add as $value) {
						$dsp = new DoctorSubSpecialty();
						$dsp->doctor_id = $user->id;
						$dsp->specialty_id = $value;
						$dsp->save();
					}
				}
			}

			// Update Medicine Type
			if ($request->has('medicine_type')) {
				if ($d->medicineType) {
					$mt = DoctorMedicineType::find($d->medicineType->id);
				}
				else{
					$mt = new DoctorMedicineType();
					$mt->doctor_id = $user->id;
				}
				$mt->medicine_type_id = $request->medicine_type;
				$mt->save();
			}

			// Update Location
			if ($request->has('address_line_1') && $request->has('state') && $request->has('city') && $request->has('pincode')) {
				if ($d->location) {
					$loc = DoctorLocation::find($d->location->id);
				}
				else{
					$loc = new DoctorLocation();
					$loc->doctor_id = $user->id;
				}
				$loc->address_line_1 = $request->address_line_1;
				if ($request->has('address_line_2')) {
					$loc->address_line_2 = $request->address_line_2;
				}
				else{
					$loc->address_line_2 = NULL;
				}
				$loc->state = $request->state;
				$loc->city = $request->city;
				$loc->pincode = $request->pincode;
				$loc->save();
			}

			// Update Languages
			if ($request->has('languages') && $request->has('mother_tongue')) {
				$d_languages = array();
				$d_mother_tongue = '';
				foreach ($d->languages as $dl) {
					$language = $dl->language;
					if ($dl->mother_tongue == 1) {
						$d_mother_tongue = $language->id;
						array_push($d_languages, $language->id);
					}
					else{
						array_push($d_languages, $language->id);
					}
				}

				$req_languages = $request->languages;
				if (!array_search($request->mother_tongue, $req_languages)) {
					array_push($req_languages, $request->mother_tongue);
				}

				if (empty($d_languages)) {
					foreach ($request->languages as $lid) {
						$lan = new DoctorLanguages();
						$lan->doctor_id = $user->id;	
						$lan->language_id = $lid;	
						if ($lid == $request->mother_tongue) {
							$lan->mother_tongue = 1;
						}
						else{
							$lan->mother_tongue = 0;
						}
						$lan->save();
					}
				}
				else{
					$languages_to_add = array_diff($req_languages, $d_languages);
					$languages_to_delete = array_diff($d_languages, $req_languages);

					if (!empty($languages_to_delete)) {
						DoctorLanguages::where('doctor_id', $user->id)
										->whereIn('language_id', $languages_to_delete)
										->delete();
					}

					if (!empty($languages_to_add)) {
						foreach ($languages_to_add as $lid) {
							$lan = new DoctorLanguages();
							$lan->doctor_id = $user->id;	
							$lan->language_id = $lid;
							$lan->mother_tongue = 0;
							$lan->save();
						}
					}

					$mt_change = false;
					if ($d_mother_tongue != (int)$request->mother_tongue) {
						// Remove Old Mother Tongue
						$lan = DoctorLanguages::where('doctor_id', $user->id)
												->where('language_id', $d_mother_tongue)
												->where('mother_tongue', 1)
												->first();
						if ($lan) {
							$lan->mother_tongue = 0;
							$lan->save();
						}

						// Update new mother tongue
						$lan = DoctorLanguages::where('doctor_id', $user->id)
												->where('language_id', (int)$request->mother_tongue)
												->where('mother_tongue', 0)
												->first();
						if ($lan) {
							$lan->mother_tongue = 1;
							$lan->save();
						}
					}
				}
			}

			// Update Education
			if ($request->has('education')) {
				$d_education = array();
				foreach ($d->education as $value) {
					array_push($d_education, $value->id);
				}

				$req_education = array();
				foreach ($request->education as $ed) {
					if (array_key_exists('id', $ed)) {
						array_push($req_education, $ed['id']);
						$ded = DoctorEducation::find($ed['id']);
					}
					else{
						$ded = new DoctorEducation();
						$ded->doctor_id = $user->id;
					}

					if (array_key_exists('degree', $ed) && $ed['degree'] != '' 
						&& array_key_exists('year', $ed) && $ed['year'] != '' 
						&& array_key_exists('college_name', $ed) && $ed['college_name'] != '') {

						$ded->degree = $ed['degree'];
						$ded->year = $ed['year'];
						$ded->college_name = $ed['college_name'];
						$ded->save();
					}				
				}

				$education_to_delete = array_diff($d_education, $req_education);
				if (!empty($education_to_delete)) {
					DoctorEducation::whereIn('id', $education_to_delete)->delete();
				}
			}

			// Update Awards
			if ($request->has('awards')) {
				$d_awards = array();
				foreach ($d->awards as $value) {
					array_push($d_awards, $value->id);
				}

				$req_awards = array();
				foreach ($request->awards as $aw) {
					if (array_key_exists('id', $aw)) {
						array_push($req_awards, $aw['id']);
						$daw = DoctorAwards::find($aw['id']);
					}
					else{
						$daw = new DoctorAwards();
						$daw->doctor_id = $user->id;
					}

					if (array_key_exists('name', $aw) && $aw['name'] != '' 
						&& array_key_exists('year', $aw) && $aw['year'] != '' 
						&& array_key_exists('details', $aw) && $aw['details'] != '') {
						
						$daw->name = $aw['name'];
						$daw->year = $aw['year'];
						$daw->details = $aw['details'];
						$daw->save();
					}				
				}

				$awards_to_delete = array_diff($d_awards, $req_awards);
				if (!empty($awards_to_delete)) {
					DoctorAwards::whereIn('id', $awards_to_delete)->delete();
				}
			}

			// Update Specialization
			if ($request->has('specialization')) {
				$d_specialization = array();
				foreach ($d->specialization as $value) {
					array_push($d_specialization, $value->specialization);
				}

				$specialization_to_add = array_diff($request->specialization, $d_specialization);
				$specialization_to_delete = array_diff($d_specialization, $request->specialization);

				if (!empty($specialization_to_delete)) {
					DoctorSpecialization::where('doctor_id', $user->id)
											->whereIn('specialization', $specialization_to_delete)
											->delete();
				}

				if (!empty($specialization_to_add)) {
					foreach ($specialization_to_add as $value) {
						$dsp = new DoctorSpecialization();
						$dsp->doctor_id = $user->id;
						$dsp->specialization = $value;
						$dsp->save();
					}
				}
			}

			// Update Services
			if ($request->has('services')) {
				$d_services = array();
				foreach ($d->services as $value) {
					array_push($d_services, $value->service);
				}

				$services_to_add = array_diff($request->services, $d_services);
				$services_to_delete = array_diff($d_services, $request->services);

				if (!empty($services_to_delete)) {
					DoctorServices::where('doctor_id', $user->id)
									->whereIn('service', $services_to_delete)
									->delete();
				}

				if (!empty($services_to_add)) {
					foreach ($services_to_add as $value) {
						$dsv = new DoctorServices();
						$dsv->doctor_id = $user->id;
						$dsv->service = $value;
						$dsv->save();
					}
				}
			}

			return response()->json(['success' => true, 'message' => 'Profile Updated']);
		}
		catch(Exception $e){
			return response()->json(['success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"], 500);
		}
	}
}