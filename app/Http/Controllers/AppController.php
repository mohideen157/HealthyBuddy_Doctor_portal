<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Model\Specialty;
use App\Model\Symptom;
use App\Model\SymptomSpecialty;
use App\Model\MedicineType;
use App\Model\Language;
use App\Model\AdminSettings;
use App\Model\Doctor\DoctorProfile;
use App\Model\Doctor\DoctorSpecialty;
use App\Model\Doctor\DoctorSubSpecialty;
use App\Model\Doctor\DoctorConsultationPrices;
use App\Model\HealthTip;
use App\Model\LabTest;
use App\Model\UploadType;
use App\Model\Appointment\TempAppointment;
use App\Model\Doctor\DoctorTimeSlots;
use App\Model\Doctor\DoctorAppointments;
use App\Model\PromoCodeBanner;
use App\Model\Bank;

use Validator;
use Carbon\Carbon;
use DB;
use URL;
use Config;
use Exception;

use App\Helpers\Helper;

class AppController extends Controller
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

	public function getPromoCodes(){
		$promocodes = PromoCodeBanner::where('is_active', 1)->select('title', 'content')->get()->toArray();
		return response()->json(['success' => true, 'data' => $promocodes]);
	}
	
	public function getBanks(){
		$banks = Bank::all()->pluck('bank');
		return response()->json(['success' => true, 'data' => $banks]);
	}

	public function getLabTestsList(){
		$lab_tests = LabTest::all()->pluck('name');
		return response()->json(['success' => true, 'data' => $lab_tests]);
	}

	public function getSpecialties(){
		$specialities = Specialty::orderBy('specialty')->get();
		foreach ($specialities as $value) {
			if ($value->image && $value->image!= NULL  && $value->image != '') {
				$value->image = URL::to('/').$value->image;
			}
		}
		return response()->json(['success' => true, 'data' => $specialities]);
	}

	public function getSpecialtyTree(){
		$specialities = Specialty::all();
		$return_arr = array();
		foreach ($specialities as $value) {
			if (!array_key_exists($value->parent, $return_arr)) {
				$return_arr[$value->parent] = array();
			}

			if ($value->image && $value->image!= NULL  && $value->image != '') {
				$value->image = URL::to('/').$value->image;
			}

			array_push($return_arr[$value->parent], $value);
		}
		return response()->json(['success' => true, 'data' => $return_arr]);
	}

	public function getSpecialtyBySlug(Request $request){
		$specialty = [];

		if ($request->has('slug')) {
			$specialty = Specialty::findBySlug($request->slug); 

			if (!$specialty) {
				return response()->json(['success' => false, 'error' => 'specialty_not_found'], 404);
			}
		}

		return response()->json(['success' => true, 'data' => $specialty]);
	}

	public function getSymptoms(){
		$symptoms = Symptom::all();
		return response()->json(['success' => true, 'data' => $symptoms]);
	}

public function getSymptomsSpeciality(){
		$return_arr = array();
		$symptoms = Symptom::all();
		$return_arr['symptoms'] = $symptoms;
		
		$specialities = Specialty::orderBy('specialty')->get();
		foreach ($specialities as $value) {
			if ($value->image && $value->image!= NULL  && $value->image != '') {
				$value->image = URL::to('/').$value->image;
			}
		}
			$return_arr['speciality'] = $specialities;


		return response()->json(['success' => true, 'data' => $return_arr]);
	}

	public function getLangPriceMedicine(){
		$return_arr = array();
		$languages = Language::all();
		$return_arr['languages'] = $languages;
		$medicine_types = MedicineType::all();
		$return_arr['medicine_types'] = $medicine_types;

		$min_price = DoctorConsultationPrices::where('video_call_available', 1)->min('video_call_price');
			$max_price = DoctorConsultationPrices::where('video_call_available', 1)->max('video_call_price');
			$max_voice_price = DoctorConsultationPrices::where('voice_call_available', 1)->max('voice_call_price');
			$max_price = max($max_price,$max_voice_price);

			$ret_arr = [
				'min' => $min_price,
				'max' => $max_price
			];
		$return_arr['price_min_max'] = $ret_arr;


		return response()->json(['success' => true, 'data' => $return_arr]);
	}

	public function getMedicineType(){
		$medicine_types = MedicineType::all();
		return response()->json(['success' => true, 'data' => $medicine_types]);
	}

	public function getLanguages(){
		$languages = Language::all();
		return response()->json(['success' => true, 'data' => $languages]);
	}

	public function getConsultationPriceMinMax(){
		try{

			$min_price = DoctorConsultationPrices::where('video_call_available', 1)->min('video_call_price');
			$max_price = DoctorConsultationPrices::where('video_call_available', 1)->max('video_call_price');
			$max_voice_price = DoctorConsultationPrices::where('voice_call_available', 1)->max('voice_call_price');
			$max_price = max($max_price,$max_voice_price);

			$ret_arr = [
				'min' => $min_price,
				'max' => $max_price
			];

			return response()->json(['success' => true, 'data' => $ret_arr]);
		}
		catch(Exception $e){
			return response()->json(array('success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"));
		}		
	}

	public function getUploadTypes(){
		try{
			$types = UploadType::all()->pluck('type')->toArray();
			array_push($types, 'Other');
			return response()->json(['success' => true, 'data' => $types]);
		}
		catch(Exception $e){
			return response()->json(array('success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"));
		}
	}

	public function getArticles(Request $request){
		
		$count = 5;
		$doctor_slug = '';
		$doctor_id = 0;
		$health_tips = array();

		$search_by_doctor = false;

		if ($request->has('count')) {
			$count = $request->count;
		}

		if ($count > 5 || $count == 0) {
			$count = 5;
		}

		// Find Doctor ID From Doctor Slug
		if ($request->has('doctor_slug') && $request->doctor_slug != '' && (!is_int($request->doctor_slug))) {
			$search_by_doctor = true;
			$doctor_slug = $request->doctor_slug;
			$doctor = DoctorProfile::findBySlug($doctor_slug);
			if ($doctor) {
				$doctor_id = $doctor->doctor_id;
			}

			// If Doctor Not Found Return NUll
			if (!isset($doctor_id)) {
				return response()->json(['success' => true, 'data' => []]);
			}
		}

		// If Doctor Found
		if ($search_by_doctor) {
			$health_tips = HealthTip::where('doctor_id', $doctor_id)
										->where('active', 1)
										->take($count)
										->orderBy('id', 'desc')
										->get();
		}
		// If Return All Doctor Articles
		else{
			$health_tips = HealthTip::where('active', 1)->take($count)->orderBy('id', 'desc')->get();
		}

		foreach ($health_tips as $value) {
			if ($value->image && $value->image!= NULL  && $value->image != '') {
				$value->image = URL::to('/').$value->image;
			}			
		}

		return response()->json(['success' => true, 'data' => $health_tips]);
	}

	public function getAllArticles(){
		try{
			$articles = HealthTip::where('active', 1)->orderBy('id', 'desc')->get();

			$return_arr = array();
			foreach ($articles as $tip) {
				$doctor = DoctorProfile::where('doctor_id', $tip->doctor_id)->first();

				$arr = array(
					'title' => $tip->title,
					'image' => ($tip->image?URL::to('/').$tip->image:false),
					'slug' => $tip->slug,
					'posted_at' => $tip->created_at->toAtomString(),
					'added_by' => 'Dr. '.$doctor->name
				);

				array_push($return_arr, $arr);
			}

			return response()->json(['success' => true, 'data' => $return_arr]);
		}
		catch(Exception $e){
			return response()->json(['success' => true,'error' => 'server_error', 'message' => 'Something went wrong while trying to get the article'], 500);
		}
	}

	public function getArticleBySlug(Request $request){
            
		try{
			if (!$request->has('article_slug')) {
				return response()->json(['success' => false, 'error' => 'validation_error', 'message' => 'Did not the article url']);
			}

			$article = HealthTip::findBySlug($request->article_slug);

			if (!isset($article)) {
				return response()->json(['success' => false, 'error' => 'not_found', 'message' => 'Article not found']);
			}

			if ($article->active != 1) {
				return response()->json(['success' => false, 'error' => 'not_found', 'message' => 'Article not found']);
			}
			
			$doctor = DoctorProfile::where('doctor_id', $article->doctor_id)->first();

			$return_arr = array(
				'title' => $article->title,
				'content' => nl2br($article->content),
				'image' => ($article->image?URL::to('/').$article->image:false),
				'posted_at' => $article->created_at->toAtomString(),
				'added_by' => 'Dr. '.$doctor->name
			);

			return response()->json(['success' => true, 'data' => $return_arr]);
		}
		catch(Exception $e){
			return response()->json(['success' => true,'error' => 'server_error', 'message' => 'Something went wrong while trying to get the article'], 500);
		}
	}

	public function getAppLink(Request $request){
		if ($request->has('platform')) {
			if ($request->platform == 'android') {
				$app_link = AdminSettings::where('key', 'android_app_link')
										->value('value');

				return response()->json(array('success' => true, 'data' => array('applink' => $app_link)));
			}
			else if ($request->platform == 'ios') {
				$app_link = AdminSettings::where('key', 'ios_app_link')
										->value('value');

				return response()->json(array('success' => true, 'data' => array('applink' => $app_link)));
			}
			else{
				return response()->json(array('success' => false, 'error' => 'incorrect_data' , 'message' => 'Unknown Platform'));
			}
		}
		else{
			return response()->json(array('success' => false, 'error' => 'incorrect_data' , 'message' => 'Platform not provided'));
		}
	}

	public function sendAppLink(Request $request){

		if ($request->has('mobile_no')) {
			$recipient_no = $request->mobile_no;

			 $app_link = Config::get('sheDoctr.webapp.url');
			//Please download the SheDoctr app using the following link : '.$app_link.' Thank you
			
			$msgtxt = 'Please download the SheDoctr app using the following link : '.$app_link.' Thank you';

			$msgData = array(
				'recipient_no' => $recipient_no,
				'msgtxt' => $msgtxt
			);

			$sendsms = Helper::sendSMS($msgData);

			if ($sendsms) {

				/*$sendsms = explode(',', $sendsms, 2);
				$sms_status = explode('=', $sendsms[0]);*/
				$sendsms = explode(':', $sendsms);
				//echo $sendsms[0] == 'MsgID';exit;

				//if ($sms_status[1] == '0' || $sms_status[1] == 0) {
				if ($sendsms[0] == 'MsgID') {
					return response()->json(array('success' => true, 'message' => 'Message Sent Successfully', 'data' => $msgData, 'smsData' => $sendsms));
				}
				else{
					return response()->json(array('success' => false, 'error' => 'sms_error' , 'message' => 'Unable to send SMS at the moment.<br />Please try again later', 'smsData' => $sendsms));
				}				
			}
			else{
				return response()->json(array('success' => false, 'error' => 'sms_error' , 'message' => 'Unable to send SMS at the moment.<br />Please try again later'));
			}

		}
		else{
			return response()->json(array('success' => false, 'error' => 'incorrect_data' , 'message' => 'Phone Number not provided'));
		}
	}

	public function getHomepageDoctors(){
		try{
			$return_arr = array();

			$doctors = DoctorProfile::where('show_on_homepage', 1)->get();

			foreach ($doctors as $d) {
				if ($d->userdata->active == 1) {
					$d_education = '';
					foreach ($d->education as $ded) {
						$d_education .= $ded->degree.', ';
					}

					$return_arr[] = array(
						'name' => $d->name,
						'experience' => $d->experience,
						'education' => preg_replace('/, $/', '', $d_education),
						'specialty' => ($d->specialty?$d->specialty->specialty->specialty:''),
						'specialty_slug' => ($d->specialty?$d->specialty->specialty->slug:''),
						'image' => URL::to('/').$d->userdata->profile_image,
						'doctor_slug' => $d->slug
					);
					
			
					
				}
			}
			

			return response()->json(['success' => true, 'data' => $return_arr, 'message' => 'Doctors Fetched']);
		}
		catch(Exception $e){
			return response()->json(array('success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"));
		}
	}

	public function getDoctorBySlug(Request $request){
		try{
			if (!$request->has('slug')) {
				return response()->json(array('success' => false, 'error' => 'validation_error', 'message' => "Something went wrong.<br />Please try again"), 400);
			}

			$doctor_slug = $request->slug;
			$doctor = DoctorProfile::findBySlug($doctor_slug);

			if (!$doctor) {
				return response()->json(array('success' => false, 'error' => 'doctor_not_found', 'message' => "Something went wrong.<br />Please try again"), 404);
			}

			$i = 0;

			$profile = $this->createDoctorProfile($doctor->doctor_id, $i);
                        if (!$profile) {
				return response()->json(array('success' => false, 'error' => 'doctor_not_found', 'message' => "Something went wrong.<br />Please try again"), 404);
			}


			$extra_info = $this->createDoctorExtraProfile($doctor->doctor_id);

			$return_arr = array(
				'profile' => $profile,
				'extra' => $extra_info
			);

			return response()->json(['success' => true, 'data' => $return_arr ,'message' => 'Doctor Profile']);
		}
		catch(Exception $e){
			return response()->json(array('success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"), 500);
		}		
	}


	public function searchDoctors(Request $request){
		try{
			$return_arr = array();

			/*$validator = Validator::make($request->all(),[
				'type'      => 'required',
				'id'     => 'required',
			]);

			if ($validator->fails()) {
				return response()->json(array('success' => false, 'error' => 'validation_error', 'message' => "Something went wrong.<br />Please try again"));
			}*/

			$start = 0;
			$limit = 10;

			if ($request->has('start')) {
				$start = $request->start;
			}
			if ($request->has('limit')) {
				$limit = $request->limit;
			}

			if ($request->has('type') && $request->has('id')) {
				if ($request->type == 'specialty') {
					// Search By Specialty
					// $doctor_main_spec = DoctorSpecialty::where('specialty_id', $request->id)->pluck('doctor_id');
					// $doctor_sub_spec = DoctorSubSpecialty::where('specialty_id', $request->id)->pluck('doctor_id');

					$doctor_main_spec = DB::table('doctor_specialty as d')
											->join('users as u', 'u.id', '=', 'd.doctor_id')
											->join('doctor_profile as dp', 'u.id', '=', 'dp.doctor_id')
											->where('d.specialty_id', $request->id)
											->orderBy('u.online', 'desc')
											->orderBy('dp.priority_doctor', 'desc')
											->orderBy('u.id', 'desc')
											->pluck('u.id');
					$doctor_main_spec = collect($doctor_main_spec);

					$doctor_sub_spec = DB::table('doctor_subspecialty as d')
											->join('users as u', 'u.id', '=', 'd.doctor_id')
											->join('doctor_profile as dp', 'u.id', '=', 'dp.doctor_id')
											->where('d.specialty_id', $request->id)
											->orderBy('u.online', 'desc')
											->orderBy('dp.priority_doctor', 'desc')
											->orderBy('u.id', 'desc')
											->pluck('u.id');
					$doctor_sub_spec = collect($doctor_sub_spec);

					$doctor = $doctor_main_spec->merge($doctor_sub_spec);

					$doctor = $doctor->unique();

					$doctor = $doctor->splice($start, $limit);
				}
				else if($request->type == 'symptom'){
					// Search By Symptom
					// Get Specialties for Symptom
					$doc_specialties = SymptomSpecialty::where('symptom_id', $request->id)->pluck('specialty_id');

					// Get DoctorIds for specialties
					// $doctor_main_spec = DoctorSpecialty::whereIn('specialty_id', $doc_specialties)->pluck('doctor_id');
					// $doctor_sub_spec = DoctorSubSpecialty::whereIn('specialty_id', $doc_specialties)->pluck('doctor_id');

					
					$doctor_main_spec = collect($doctor_main_spec);

					$doctor_sub_spec = DB::table('doctor_subspecialty as d')
											->join('users as u', 'u.id', '=', 'd.doctor_id')
											->join('doctor_profile as dp', 'd.doctor_id', '=', 'dp.doctor_id')
											->whereIn('d.specialty_id', $doc_specialties)
											->orderBy('u.online', 'desc')
											->orderBy('dp.priority_doctor', 'desc')
											->orderBy('u.id', 'desc')
											->pluck('u.id');
					$doctor_sub_spec = collect($doctor_sub_spec);

					$doctor = $doctor_main_spec->merge($doctor_sub_spec);

					$doctor = $doctor->unique();

					$doctor = $doctor->splice($start, $limit);
				}
				else{
					return response()->json(array('success' => false, 'error' => 'validation_error', 'message' => "Something went wrong.<br />Please try again"));
				}
			}
			elseif ($request->has('q')) {
				$query = $request->q;

				$specialty_list = Specialty::where('specialty', 'LIKE', '%'.$query.'%')->pluck('id');
				$symptom_list = Symptom::where('symptoms', 'LIKE', '%'.$query.'%')->pluck('id');

				$sym_specialties = SymptomSpecialty::whereIn('symptom_id', $symptom_list)->pluck('specialty_id');

				$specialty_list = collect($specialty_list);
				$sym_specialties = collect($sym_specialties);

				$all_specialties = $specialty_list->merge($sym_specialties);

				$all_specialties = $all_specialties->unique()->toArray();

				$doctor_main_spec = DB::table('doctor_specialty as d')
										->join('users as u', 'u.id', '=', 'd.doctor_id')
										->join('doctor_profile as dp', 'd.doctor_id', '=', 'dp.doctor_id')
										->whereIn('d.specialty_id', $all_specialties)
										->orderBy('u.online', 'desc')
										->orderBy('dp.priority_doctor', 'desc')
										->orderBy('u.id', 'desc')
										->pluck('u.id');
				$doctor_main_spec = collect($doctor_main_spec);

				$doctor_sub_spec = DB::table('doctor_subspecialty as d')
										->join('users as u', 'u.id', '=', 'd.doctor_id')
										->whereIn('d.specialty_id', $all_specialties)
										->join('doctor_profile as dp', 'd.doctor_id', '=', 'dp.doctor_id')
										->orderBy('u.online', 'desc')
										->orderBy('dp.priority_doctor', 'desc')
										->orderBy('u.id', 'desc')
										->pluck('u.id');
				$doctor_sub_spec = collect($doctor_sub_spec);

				$doctor = $doctor_main_spec->merge($doctor_sub_spec);

				$doctor = $doctor->unique();

				$doctor = $doctor->splice($start, $limit);
			}
			else{
				return response()->json(array('success' => false, 'error' => 'validation_error', 'message' => "Something went wrong.<br />Please try again"));
			}

			if (count($doctor) == 0) {
				return response()->json(['success' => true, 'data' => [], 'message' => 'No doctor found for given search criteria']);
			}

			$i = $start+1;
			foreach ($doctor as $doctor_id) {

				$ret = $this->createDoctorProfile($doctor_id, $i);

				if (is_array($ret)) {
					$return_arr[] = $ret;
				}

				$i++;
			}

			return response()->json(['success' => true, 'data' => $return_arr]);
		}
		catch(Exception $e){
			return response()->json(array('success' => false, 'error' => 'server_error', 'data' => $e->getMessage(), 'message' => "Something went wrong.<br />Please try again"));
		}
	}

public function searchDoctorsNew(Request $request){
		try{
			$return_arr = array();

			/*$validator = Validator::make($request->all(),[
				'type'      => 'required',
				'id'     => 'required',
			]);

			if ($validator->fails()) {
				return response()->json(array('success' => false, 'error' => 'validation_error', 'message' => "Something went wrong.<br />Please try again"));
			}*/

			$start = 0;
			$limit = 10;

			if ($request->has('start')) {
				$start = $request->start;
			}
			if ($request->has('limit')) {
				$limit = $request->limit;
			}

			// Filter by language
					 $lang = $request->language;
					 $var = explode(",",$lang);
					  if($lang != '') 
					  $lang_spec = Language::wherein('language', $var)->pluck('id');
					  else
					  $lang_spec = Language::pluck('id');

					// Filter by medicine type
					 $medicine = $request->medicine;
					 $var = explode(",",$medicine);
					  if($medicine != '') 
					  $medi_spec = MedicineType::wherein('medicine_type', $var)->pluck('id');
					  else
					  $medi_spec = MedicineType::pluck('id');

			//print_r($request);
			//exit;

			if ($request->has('type') && $request->has('id')) {

				if ($request->type == 'specialty') {
					
					

					
				   
					$doctor_main_spec = DB::table('doctor_specialty as d')
											->join('users as u', 'u.id', '=', 'd.doctor_id')
											->join('doctor_profile as dp', 'u.id', '=', 'dp.doctor_id')
											->join('doctor_languages as dl', 'u.id', '=', 'dl.doctor_id')
											->join('doctor_medicine_type as dmt', 'u.id', '=', 'dmt.doctor_id')
											->join('doctor_consultation_prices as dcp', 'u.id', '=', 'dcp.doctor_id')
											->wherein('dl.language_id', $lang_spec)
											->wherein('dmt.medicine_type_id', $medi_spec)
											//->where('dcp.video_call_price','<',$request->consultation)
											->whereBetween('dcp.video_call_price', [$request->consultation_min, $request->consultation_max])
											->orwhere('dcp.video_call_price','')
											
											
											->where('d.specialty_id', $request->id)
											->orderBy('u.online', 'desc')
											->orderBy('dp.priority_doctor', 'desc')
											->orderBy('u.id', 'desc')
											->pluck('u.id');
					$doctor_main_spec = collect($doctor_main_spec);


					$doctor_sub_spec = DB::table('doctor_subspecialty as d')
											->join('users as u', 'u.id', '=', 'd.doctor_id')
											->join('doctor_profile as dp', 'u.id', '=', 'dp.doctor_id')
											->join('doctor_languages as dl', 'u.id', '=', 'dl.doctor_id')
											->join('doctor_medicine_type as dmt', 'u.id', '=', 'dmt.doctor_id')
											->join('doctor_consultation_prices as dcp', 'u.id', '=', 'dcp.doctor_id')
											->where('d.specialty_id', $request->id)
											->wherein('dl.language_id', $lang_spec)
											->wherein('dmt.medicine_type_id', $medi_spec)
											//->where('dcp.video_call_price','>',$request->consultation)
											->whereBetween('dcp.video_call_price', [$request->consultation_min, $request->consultation_max])
											->orderBy('u.online', 'desc')
											->orderBy('dp.priority_doctor', 'desc')
											->orderBy('u.id', 'desc')
											->pluck('u.id');
					$doctor_sub_spec = collect($doctor_sub_spec);

					$doctor = $doctor_main_spec->merge($doctor_sub_spec);

					$doctor = $doctor->unique();
					

					$doctor = $doctor->splice($start, $limit);
				}
				else if($request->type == 'symptom'){
					// Search By Symptom
					// Get Specialties for Symptom
					$doc_specialties = SymptomSpecialty::where('symptom_id', $request->id)->pluck('specialty_id');

					// Get DoctorIds for specialties
					// $doctor_main_spec = DoctorSpecialty::whereIn('specialty_id', $doc_specialties)->pluck('doctor_id');
					// $doctor_sub_spec = DoctorSubSpecialty::whereIn('specialty_id', $doc_specialties)->pluck('doctor_id');

					$doctor_main_spec = DB::table('doctor_specialty as d')
											->join('users as u', 'u.id', '=', 'd.doctor_id')
											->join('doctor_profile as dp', 'd.doctor_id', '=', 'dp.doctor_id')
											->join('doctor_medicine_type as dmt', 'u.id', '=', 'dmt.doctor_id')
											->join('doctor_consultation_prices as dcp', 'u.id', '=', 'dcp.doctor_id')
											->wherein('dl.language_id', $lang_spec)
											->wherein('dmt.medicine_type_id', $medi_spec)
											->where('dcp.video_call_price','<',$request->consultation)
											->whereIn('d.specialty_id', $doc_specialties)
											->orderBy('u.online', 'desc')
											->orderBy('dp.priority_doctor', 'desc')
											->orderBy('u.id', 'desc')
											->pluck('u.id');
					$doctor_main_spec = collect($doctor_main_spec);

					$doctor_sub_spec = DB::table('doctor_subspecialty as d')
											->join('users as u', 'u.id', '=', 'd.doctor_id')
											->join('doctor_profile as dp', 'd.doctor_id', '=', 'dp.doctor_id')
											->join('doctor_medicine_type as dmt', 'u.id', '=', 'dmt.doctor_id')
											->join('doctor_consultation_prices as dcp', 'u.id', '=', 'dcp.doctor_id')
											->wherein('dl.language_id', $lang_spec)
											->wherein('dmt.medicine_type_id', $medi_spec)
											->where('dcp.video_call_price','>',$request->consultation)
											->whereIn('d.specialty_id', $doc_specialties)
											->orderBy('u.online', 'desc')
											->orderBy('dp.priority_doctor', 'desc')
											->orderBy('u.id', 'desc')
											->pluck('u.id');
					$doctor_sub_spec = collect($doctor_sub_spec);

					$doctor = $doctor_main_spec->merge($doctor_sub_spec);

					$doctor = $doctor->unique();

					$doctor = $doctor->splice($start, $limit);
				}
				else{
					return response()->json(array('success' => false, 'error' => 'validation_error', 'message' => "Something went wrong.<br />Please try again"));
				}
			}
			elseif ($request->has('q')) {

				$query = $request->q;

				$specialty_list = Specialty::where('specialty', 'LIKE', '%'.$query.'%')->pluck('id');
				$symptom_list = Symptom::where('symptoms', 'LIKE', '%'.$query.'%')->pluck('id');

				$sym_specialties = SymptomSpecialty::whereIn('symptom_id', $symptom_list)->pluck('specialty_id');
				$specialty_list = collect($specialty_list);
				$sym_specialties = collect($sym_specialties);
	  //echo($sym_specialties);
				  $all_specialties = $specialty_list->merge($sym_specialties);

				//exit;

				$all_specialties = $all_specialties->unique()->toArray();


				$doctor_main_spec = DB::table('doctor_specialty as d')
										->join('users as u', 'u.id', '=', 'd.doctor_id')
										->join('doctor_profile as dp', 'd.doctor_id', '=', 'dp.doctor_id')
										->whereIn('d.specialty_id', $all_specialties)
										->orderBy('u.online', 'desc')
										->orderBy('dp.priority_doctor', 'desc')
										->orderBy('u.id', 'desc')
										//WHERE FIND_IN_SET($sub_category, sub_category_id) > 0
										->pluck('u.id');
				$doctor_main_spec = collect($doctor_main_spec);

				$doctor_sub_spec = DB::table('doctor_subspecialty as d')
										->join('users as u', 'u.id', '=', 'd.doctor_id')
										->whereIn('d.specialty_id', $all_specialties)
										->join('doctor_profile as dp', 'd.doctor_id', '=', 'dp.doctor_id')
										->orderBy('u.online', 'desc')
										->orderBy('dp.priority_doctor', 'desc')
										->orderBy('u.id', 'desc')
										->pluck('u.id');
				$doctor_sub_spec = collect($doctor_sub_spec);

				$doctor = $doctor_main_spec->merge($doctor_sub_spec);

				$doctor = $doctor->unique();

				$doctor = $doctor->splice($start, $limit);
			}
			else{
				return response()->json(array('success' => false, 'error' => 'validation_error', 'message' => "Something went wrong.<br />Please try again"));
			}

			if (count($doctor) == 0) {
				return response()->json(['success' => true, 'data' => [], 'message' => 'No doctor found for given search criteria']);
			}

			$i = $start+1;
			foreach ($doctor as $doctor_id) {

				$ret = $this->createDoctorProfile($doctor_id, $i);

				if (is_array($ret)) {
					$return_arr[] = $ret;
				}

				$i++;
			}

			return response()->json(['success' => true, 'data' => $return_arr]);
		}
		catch(Exception $e){
			return response()->json(array('success' => false, 'error' => 'server_error', 'data' => $e->getMessage(), 'message' => "Something went wrong.<br />Please try again"));
		}
	}

	public function getAllDoctors(Request $request){
		//try{
			$return_arr = array();

			$start = 0;
			$limit = 10;

			if ($request->has('start')) {
				$start = (int)$request->start;
			}
			if ($request->has('limit')) {
				$limit = (int)$request->limit;
			}

			// $doctor = DoctorProfile::skip($start)->take($limit)->pluck('doctor_id');
			$doctor = DB::table('doctor_profile as d')
							->join('users as u', 'u.id', '=', 'd.doctor_id')
							->where('u.active', 1)
							->orderBy('u.online', 'desc')
							->orderBy('d.priority_doctor', 'desc')
							->orderBy('u.id', 'desc')
							// ->skip($start)
							// ->take($limit)
							->pluck('u.id');

			$doctor = collect($doctor);
			$doctor = $doctor->unique();
			$doctor = $doctor->splice($start, $limit);

			// dd($doctor);
			$i = $start+1;
			foreach ($doctor as $doctor_id) {
				$ret = $this->createDoctorProfile($doctor_id, $i);

				if (is_array($ret)) {
					$return_arr[] = $ret;

					$i++;
				}
			}

			return response()->json(['success' => true, 'data' => $return_arr, 'message' => 'Doctors Found']);
		/*}
		catch(Exception $e){
			return response()->json(array('success' => false, 'error' => 'server_error', 'data' => $e, 'message' => "Something went wrong.<br />Please try again"));
		}*/
	}

	private function createDoctorProfile($id, $i){
		// Return Formatted Doctor Profile For Use in Frontend

		$d = DoctorProfile::where('doctor_id', $id)->first();
  //var_dump($d);
  //exit;              

		if ( $d->userdata->active != 1 ) {
			return false;
		}

		if ($d->userdata->profile_image_default) {
			return false;
		}

		if (!$d->signature) {
			return false;
		}

		$d_education = '';
		foreach ($d->education as $ded) {
			$d_education .= $ded->degree.', ';
		}

		$d_languages = array();
		$d_mother_tongue = '';
		$d_l_string = '';
		foreach ($d->languages as $dl) {
			$language = $dl->language;
			if ($dl->mother_tongue == 1) {
				$d_mother_tongue = array('id' => $language->id, 'name' => $language->language);
				array_push($d_languages, array('id' => $language->id, 'name' => $language->language));
			}
			else{
				$d_l_string .= $language->language.', ';
				array_push($d_languages, array('id' => $language->id, 'name' => $language->language));
			}
		}
		if (empty($d_languages)) {
			return false;
		}

		$d_consultation_prices = array();
		foreach ($d->consultationPrices as $dcp) {
			$d_consultation_prices = array(
				'id' => $dcp->id, 
				'video_call_price' => (int)$dcp->video_call_price, 
				'voice_call_price' => (int)$dcp->voice_call_price,
				'video_call_available' => ($dcp->video_call_available)?true:false,
				'voice_call_available' => ($dcp->voice_call_available)?true:false
			);
		}
		if (empty($d_consultation_prices)) {
			return false;
		}

		$d_specialty = array();
		if ($d->specialty->specialty) {
			$s = $d->specialty->specialty;
			$d_specialty = array(
				'id' => $s->id, 
				'name' => $s->specialty, 
				'slug' => $s->slug
			);
		}
		if (empty($d_specialty)) {
			return false;
		}
$doctor_sub_spec = DB::table('doctor_subspecialty as d')
																		->join('specialty as u', 'u.id', '=', 'd.specialty_id')
																		->where('d.doctor_id', $d->doctor_id)
																		->pluck('u.specialty');
 if(!empty($doctor_sub_spec))
    $doc_subsp= ", ".$doctor_sub_spec[0];
 else $doc_subsp='';														
		$d_medicine_type = array();
		if ($d->medicineType) {
			$mt = $d->medicineType->medicineType;
			$d_medicine_type = array(
				'id' => $mt->id, 
				'name' => $mt->medicine_type
			);
		}
		if (empty($d_medicine_type)) {
			return false;
		}

		$online = $this->doctorCallNowAvailable($d);
$doctor_slot = DB::table('doctor_slots as d')
																		
																		->where('d.doctor_id', $d->doctor_id)
																		->pluck('d.slot');

		/*$online_status = false;
		$online_timestamp = false;
		if ($online) {
			$online_status = true;
			$online_timestamp = $online;
		}*/
		if(!empty($doctor_slot))
			$doctor_slots = $doctor_slot[0];
		else
			$doctor_slots = 15;

		$return_arr = array(
			'counter' => $i,
			'id' => $d->doctor_id,
			'prefix' => $d->prefix,
			'name' => $d->name,
			'slug' => $d->slug,
			'online' => $online,
			// 'online_timestamp' => $online_timestamp,
			'experience' => $d->experience,
			'education' => preg_replace('/, $/', '', $d_education),
			'specialty' => $d_specialty,
                        'sub_specialty' => $doc_subsp,
                        'languages' => $d_languages,
			'languages_string' => preg_replace('/, $/', '', $d_l_string),
			'mother_tongue' => $d_mother_tongue,
			'medicine_type' => $d_medicine_type,
			'consultation_prices' => $d_consultation_prices,
			'image' => URL::to('/').$d->userdata->profile_image,
			'priority' => $d->priority_doctor,
			'slot' => $doctor_slots
		);

		return $return_arr;
	}

	private function createDoctorExtraProfile($id){
		$d = DoctorProfile::where('doctor_id', $id)->first();

		if ( $d->userdata->active != 1 ) {
			return false;
		}

		$d_education = array();
		foreach ($d->education as $ded) {
			array_push($d_education, $ded->degree.'-'.$ded->college_name.','.$ded->year);
		}

		$d_specialization = array();
		foreach ($d->specialization as $dsp) {
			$spec = $dsp->specialization;
			array_push($d_specialization, $spec);
		}

		$d_services = array();
		foreach ($d->services as $dsv) {
			$ser = $dsv->service;
			array_push($d_services, $ser);
		}

		$d_awards = array();
		foreach ($d->awards as $da) {
			array_push($d_awards, $da->name.','.$da->details.'-'.$da->year);
		}

		if (array_key_exists('show_doctor_address', $this->settings)) {
			$show_address = (int)$this->settings['show_doctor_address'];
		}
		else{
			$show_address = 0;
		}

		$d_location = false;
		if ($show_address == 1) {
			if ($d->location && $d->location->address_line_1 && $d->location->address_line_1 != '') {
				$d_location = $d->location->address_line_1;
				if ($d->location->address_line_2) {
					$d_location .= "\r\n".$d->location->address_line_2;
				}
				$d_location .= "\r\n".$d->location->city;
				$d_location .= "\r\n".$d->location->state;
				$d_location .= " - ".$d->location->pincode;
				/*$d_location = array(
					'address_line_1' => $d->location->address_line_1,
					'address_line_2' => $d->location->address_line_2,
					'state' => $d->location->state,
					'city' => $d->location->city,
					'pincode' => $d->location->pincode
				);*/
			}
		}

		$return_arr = array(
			'about' => $d->self_details,
			'education' => $d_education,
			'specialization' => $d_specialization,
			'services' => $d_services,
			'awards' => $d_awards,
			'registration_no' => $d->registration_no,
			'address' => nl2br($d_location)
		);

		return $return_arr;
	}

	private function doctorCallNowAvailable($doctor){
		try{
			// Check if online
			if ($doctor->userData->online == 1) {
				return true;
			}
			return false;

			// Check if a slot is available within 15 mins of current time
			/*$dt = time();

			$interval=15*60;
			$last = $dt - $dt % $interval;
			$next = $last + $interval;

			$time = strftime('%H:%M:%S', $next);

			$dt = Carbon::now();
			$date = $dt->toDateString();

			$doc_timeslot_id = DoctorTimeSlots::where('doctor_id', $doctor->doctor_id)
												->where('date', $date)
												->where('time_start', $time)
												->value('id');

			if (!$doc_timeslot_id || $doc_timeslot_id == NULL) {
				return false;
			}

			$booking = DoctorAppointments::where('doctor_id', $doctor->doctor_id)
											->where('date', $date)
											->where('time_start', $time)
											->count();

			if ($booking > 0) {
				return false;
			}

			$temp_booking = TempAppointment::where('slot_id', $doc_timeslot_id)->count();

			if ($temp_booking > 0) {
				$slot_details = TempAppointment::where('slot_id', $doc_timeslot_id)->first();

				if ($slot_details->status == 1) {
					$expiry = (int)Config::get('sheDoctr.webapp.payment_pending_booking_expiry');
				}
				else if($slot_details->status == 0){
					$expiry = (int)Config::get('sheDoctr.webapp.temp_booking_expiry');
				}
				else{
					$expiry = 15;
				}
				
				$expiry = $expiry*60;

				$t = Carbon::parse($slot_details->updated_at);
				if ($t->isPast()) {
					$slot_details->delete();
				}
				else{
					return false;
				}
			}

			return $next;*/
		}
		catch(Exception $e){
			return false;
		}
	}
}
