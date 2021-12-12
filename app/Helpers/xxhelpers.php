<?php

namespace App\Helpers;

use App\Jobs\SendEmailJob;
use App\Model\AssignDoctor;
use App\Model\History;
use App\Model\PasswordResetCodes;
use App\Model\Patient\PatientProfile;
use App\Model\Patient\BloodPressure;

use App\Model\Tenant\OrganisationDetail;
use App\Model\UserRole;
use App\ProfileQuestion;
use App\User;
use Carbon\Carbon;
use Config;
use Illuminate\Support\Str;
use JWTAuth;
use Log;
use DB;
use DateTime;
use Mail;
use Myaibud\Models\Patient\PatientHealthProfile;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class Helper{

	public static function sendSMS($data){
		try{

			$mobileno =  urlencode($data['recipient_no']);
			$msgtext = rawurlencode($data['msgtxt']);
			$profileid = urlencode("20092076");
			$pwd = urlencode("123456");
			$senderid = "C2P";
			$smstype = "13";

			// Prepare data for POST request
			$data = "user=" . $profileid . "&pwd=" . $pwd . "&senderid=" . $senderid . "&mobileno=" . $mobileno . "&msgtext=" . $msgtext . "&smstype" . $smstype;
		
			// Send the GET request with cURL
			$ch = curl_init("http://sms.smscanvas.com/sendurlcomma.aspx?". $data);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($ch);
			curl_close($ch);
			return true;
	
		}
		catch(Exception $e){
			return false;
		}
	}
	public static function sendMail($mobile,$otp)
	{		
		 
		   $user=User::where('mobile_no',$mobile)->first();
		   $user->otp=$otp;
		   
		   if($user->email!='')
		   {
			    
				Mail::send('email', ['user' => $user], function ($message) use ($user) {
				$message->to($user->email, $user->email)
				->subject('OTP validation');
				$message->from('info@cover2protect.com',' Cover2protect');
				});
		   }
 
          if (Mail::failures()) {
            return response()->Fail('Sorry! Please try again latter');
          }else{
            return response()->json('Yes, You have sent email to GMAIL from LARAVEL !!');
          }
		 
		
		 
	}
	
	public static function apk($mobile,$data)
	{		
		 
		   $user=User::where('mobile_no',$mobile)->first();
		  
		   
		   if($user->email!='')
		   {
			    
				Mail::send('apk', ['user' => $user,'data'=>$data], function ($message) use ($user,$data) {
				$message->to($user->email, $user->email)
				->subject('information');
				$message->from('info@cover2protect.com',' Cover2protect');
				});
		   }
  
		 
	}

	public static function isUserLoggedIn(){
		try {
			if (! $user = JWTAuth::parseToken()->authenticate()) {
				return false;
			}
			else{
				return $user;
			}
		}
		catch (TokenExpiredException $e) {
			return false;
		}
		catch (TokenInvalidException $e) {
			return false;
		}
		catch (JWTException $e) {
			return false;
		}
		catch (Exception $e) {
			return false;
		}
	}

	public static function getUserRoleID($role){
		$user_role = UserRole::where('user_role', $role)->first();
		return $user_role->id;
	}

	// json decode
	public static function decode($data)
	{
		return json_decode($data);
	}

	//status message
	public static function status_message($status, $name , $type)
	{
		if($status){
			alert()->success('Success', $name.' '.$type.' '.'Successfully');
		}
		else{
			alert()->error('Failed', 'Failed To '.$type.' '.$name );
		}
	}

	public static function send_welcome_and_reset_password_email($user)
	{
        $token = uniqid();
        $expiry = Carbon::now()->addMinutes(30)->toDateTimeString();

        $uniqid = array(['token' => $token, 'expiry' => $expiry ]);
        $uniqid = encrypt($uniqid);

        PasswordResetCodes::updateOrCreate([
            'user_id' => $user->id,
        ],
        [
            'code' => $uniqid,
        ]);

        dispatch(new SendEmailJob($user, $token));
	}

	public static function patient_profile($user, $parent_key, $child_key = null, $date = null)
	{
		$health = PatientHealthProfile::where('patient_id', $user->id)
								->where('parent_key', $parent_key)
								->where('child_key', $child_key)
                                ->when(!is_null($date), function($query) use ($date){
                                    $query->whereDate('created_at', '<=', $date)
                                    	->latest();
                                })
                                ->when(is_null($date), function($query){
                                    $query->where('active', 1);
                                })
                                ->first();

		return $health;
	}

	public static function patient_profile_collection($user, $parent_key, $child_key = null, $date = null)
	{
		$health = PatientHealthProfile::where('patient_id', $user->id)
								->where('parent_key', $parent_key)
								->where('child_key', $child_key)
                                ->when(!is_null($date), function($query) use ($date){
                                    $query->whereDate('created_at', '<=', $date)
                                    	->latest();
                                })
                                ->when(is_null($date), function($query){
                                    $query->where('active', 1);
                                });

		return $health;
	}

	public static function getAlcoholConsumption($id, $date = null){
		$user = PatientHealthProfile::select('child_key','value','extra_info')
									->where('patient_id', $id)
									->where('parent_key', 'alcohol')
									->whereNotNull('child_key')
									->when(is_null($date), function($query){
										$query->where('active', 1);
									})
									->when(!is_null($date), function($query) use ($date){
										$query->whereDate('created_at', $date);
									})
									->get();
		return $user;
	}
	public static function get_synched_id($user_id, $date = null)
	{
		$data = History::whereUserId($user_id)
						->when(!is_null($date), function($query) use ($date){
							$query->whereDate('created_at', $date);
						})
						->first();

		if($data){
			return $data->synched;
		}
	}

	// Function to find the date when user updated its profile
	public static function patient_health_profile_changed_date($id){
		$profile_changed_date = PatientHealthProfile::selectRaw('DATE(created_at) as created_at')
													->where('parent_key', '!=', 'nutrition')
                                                    ->wherePatientId($id)
                                                    ->distinct('created_at')
                                                    ->get();

        $profile_changed_date = $profile_changed_date->map(function($date){
            $date->date = date('Y-m-d', strtotime($date->created_at));
            return $date;
        });

        $profile_changed_date = $profile_changed_date->pluck('date')->toArray();

        return $profile_changed_date;
	}

	public static function nutrition_change_date($id){
		$nutrition = PatientHealthProfile::select('value')
											->where('parent_key', 'nutrition')
                                            ->wherePatientId($id)
                                            ->distinct('value')
                                            ->pluck('value')
                                            ->toArray();
        return $nutrition;
	}

	public static function patient_history_change_date($id){
		$history = History::selectRaw('DATE(date) as date')
							->whereUserId($id)
							->distinct('date')
							->pluck('date')
							->toArray();

		return $history;
	}

	public static function get_bp($id, $date = null)
	{
		//$date=date('Y-m-d');
		$datas = Self::blood_pressure($id, $date);

		$add = [];
		$diastolic_avg = [];
		$bp_avgerage = [];
		$dia_average = [];
		for($i=0; $i<count($datas); $i++){
			$j = $i;
			$count = ++$j;

			$all_bp = str::before($datas[$i]['bp'], '/');
			$add[] = $all_bp;
			$output = array_sum($add);
			$bp_vag = ($output/$count);

			$all_diastolic = str::after($datas[$i]['bp'], '/');
			$diastolic_avg[] = $all_diastolic;
			$diastolic_output = array_sum($diastolic_avg);
			$dia_avg = ($diastolic_output/(int)$count);
			
			array_push($bp_avgerage, $bp_vag);
			array_push($dia_average, $dia_avg);
		}
		
		$systolic = [];
		$diastolic = [];
		$date = [];
		$sy_average = [];
		foreach ($datas as $key => $data) {
			array_push($systolic, (Str::before($data->bp, '/')));
			array_push($diastolic, (Str::after($data->bp, '/')));
			array_push($date, date('d,M Y', strtotime($data->date)));
		}

		$result = [];
		array_push($result, [$systolic, $diastolic, $date, $bp_avgerage, $dia_average]);

		return $result;
	}

	public static function get_hr($id, $date = null)
	{
		$datas = Self::get_history($id, $date);

		$hr_avg = [];
		$hr_average = [];
		for($i=0; $i<count($datas); $i++){
			$j = $i;
			$count = ++$j;

			$all_hr = $datas[$i]['hr'];
			$hr_avg[] = $all_hr;
			$output = array_sum($hr_avg);
			$hr = ($output/$count);

			array_push($hr_average, $hr);
		}

		$hr = [];
		$date = [];

		foreach ($datas as $data) {
			array_push($hr, $data->hr);
			array_push($date, date('d,M Y', strtotime($data->date)));
		}

		$result = [];
		array_push($result , [$hr, $date,$hr_average]);

		return $result;
	}

	public static function get_arrhythmia($id, $date = null)
	{

		$datas = Self::get_history($id, $date);

		$arrhythmia_avg = [];
		$arrhythmia_average = [];
		for($i=0; $i<count($datas); $i++){
			$j = $i;
			$count = ++$j;

			$all_arrhythmia = $datas[$i]['arrhythmia'];
			$arrhythmia_avg[] = $all_arrhythmia;
			$output = array_sum($arrhythmia_avg);
			$arrhythmia = ($output/$count);

			array_push($arrhythmia_average, $arrhythmia);
		}

		$arrhythmia = [];
		$date = [];

		foreach ($datas as $data) {
			array_push($arrhythmia, $data->arrhythmia);
			array_push($date, date('d,M Y', strtotime($data->date)));
		}

		$result = [];
		array_push($result , [$arrhythmia, $date, $arrhythmia_average]);

		return $result;
	}


	public static function get_arterial_age($id, $date = null){

		$datas = Self::get_history($id, $date);
		$arterial_avg = [];
		$arterial_average = [];

		for($i=0; $i<count($datas); $i++){
			$j = $i;
			$count = ++$j;

			$all_arterial = $datas[$i]['artrialage'];
			$arterial_avg[] = $all_arterial;
			$output = array_sum($arterial_avg);
			$arterial = ($output/$count);

			array_push($arterial_average, $arterial);
		}

		$arterial_age = [];
		$date = [];

		foreach ($datas as $data) {
			array_push($arterial_age, $data->artrialage);
			array_push($date, date('d,M Y', strtotime($data->date)));
		}

		$result = [];
		array_push($result , [$arterial_age, $date, $arterial_average]);

		return $result;
	}

	public static function get_afib($id, $date = null){

		$datas = Self::get_history($id, $date);
		$afib_avg = [];
		$afib_average = [];

		for($i=0; $i<count($datas); $i++){
			$j = $i;
			$count = ++$j;
			$all_afib = $datas[$i]['afib'];
			$afib_avg[] = $all_afib;
			$output = array_sum($afib_avg);
			$afib = ($output/$count);

			array_push($afib_average, $afib);
		}

		$afib = [];
		$date = [];

		foreach ($datas as $data) {
			array_push($afib, $data->afib);
			array_push($date, date('d,M Y', strtotime($data->date)));
		}

		$result = [];
		array_push($result , [$afib, $date, $afib_average]);

		return $result;
	}

	public static function get_rpwv($id, $date = null){

		$datas = Self::get_history($id, $date);
		$rpwv_avg = [];
		$rpwv_average = [];

		for($i=0; $i<count($datas); $i++){
			$j = $i;
			$count = ++$j;
			$all_rpwv = $datas[$i]['rpwv'];
			$rpwv_avg[] = $all_rpwv;
			$output = array_sum($rpwv_avg);
			$rpwv= ($output/$count);
			array_push($rpwv_average, $rpwv);
		}

		$rpwv = [];
		$date = [];

		foreach ($datas as $data) {
			array_push($rpwv, $data->rpwv);
			array_push($date, date('d,M Y', strtotime($data->date)));
		}

		$result = [];
		array_push($result , [$rpwv, $date, $rpwv_average]);

		return $result;
	}

	public static function get_calories($id, $date = null){
		if($date){
			$from_date = date("Y-m-d", strtotime($date. "-1 month"));
		}
		else{
			$from_date = Carbon::today()->subMonth(1)->toDateString();
		}

		$nutritions = PatientHealthProfile::select('id', 'parent_key', 'value', 'extra_info')
											->whereIn('parent_key', ['nutrition'])
											->wherePatientId($id)
											->when(is_null($date), function($query) use($from_date){
												$query->whereDate('value', '>=', $from_date);
											})
											->when(!is_null($date), function($query) use($from_date, $date){
												$query->whereDate('value', '>=', $from_date)
												->whereDate('value', '<=', $date);
											})
											->get()
											->sortBy('value')
											->groupBy('value');

		$padometer_excercises = PatientHealthProfile::select('extra_info', DB::raw('DATE(created_at) as date'))
											->whereIn('parent_key', ['pado-meter', 'excercise'])
											->wherePatientId($id)
											->when(is_null($date), function($query) use($from_date){
												$query->whereDate('created_at', '>=', $from_date);
											})
											->when(!is_null($date), function($query) use($from_date, $date){
												$query->whereDate('created_at', '>=', $from_date)
												->whereDate('created_at', '<=', $date);
											})
											->get()
											->sortBy('date')
											->groupBy('date');
											

		$caloriesTarget = PatientHealthProfile::whereParentKey('calories')
												->whereChildKey('target')
												->where('value','!=','')
												->where('value','!=','null')
												->wherePatientId($id) 
												->get();
			//	dd($caloriesTarget);								
	    
		if (count($caloriesTarget)) {
			foreach ($caloriesTarget as $key => $value) {
				$target[$value->value] = $value->unit;
			}
		} else {
			$target = '1900';
		}
		 //dd($target);
           
       	// if($caloriesTarget){
       	// 	$target = $target;
       	// }else{
       	// 	$target = '1900';
       	// }


		$date = [];
		$data = [];

		$calories_target = [];
		$calories_gained = [];
		$calories_burned = [];
		$period = [];

		foreach ($nutritions as $key => $value) {
			$key = date('Y-m-d', strtotime($key));
			array_push($date, $key);
		}
      
		foreach ($padometer_excercises as $key => $value) {
			$key = date('Y-m-d', strtotime($key));
			array_push($date, $key);
		}
		  
		foreach ($caloriesTarget as $key => $value) {
			$key = date('Y-m-d', strtotime($value->value));
			array_push($date, $key);
			$dd[]=$value->value;
		}
		 
		// arrage the array into accesnding order
		$date = array_unique($date);
		usort($date, "Self::sort_date");
		//dd($date,$target);
		// error_reporting(0);
	   // dd($date);
		foreach ($date as $date) {
			$nutrition = $nutritions[$date] ?? [];
			$padometer_excercise = $padometer_excercises[$date] ?? [];
			$total_calories_gained = 0;
			$total_calories_burned = 0;

			foreach ($nutrition as $nutrition) {
				$extra_info = json_decode($nutrition->extra_info,  true);
				$total_calories_gained += (float)$extra_info['calories'];
			}

			foreach ($padometer_excercise as $pe) {
				$extra_info = json_decode($pe->extra_info, true);
				$total_calories_burned += $extra_info['calories'];
			}
			if (array_key_exists(date('Y-m-d', strtotime($date)),(array)$target))
			{
			array_push($period, date('d-M', strtotime($date)));
			array_push($calories_gained, $total_calories_gained);
			array_push($calories_burned, $total_calories_burned);
			array_push($calories_target, $target[date('Y-m-d', strtotime($date))]);
			} else {

				array_push($period, date('d-M', strtotime($date)));
				array_push($calories_gained, $total_calories_gained);
				array_push($calories_burned, $total_calories_burned);
				array_push($calories_target, 0);

			}
			
		}

		array_push($data, [$period, $calories_gained, $calories_burned, $calories_target]);
		//dd($data);
		return $data;
	}

	public static function sort_date($a, $b){
		return strtotime($a) - strtotime($b);
	}

	public static function get_history($id, $date){	
		if($date){
			$from_date = date("Y-m-d", strtotime($date. "-1 month"));
			$datas = History::whereUserId($id)
							->whereDate('date', '>=', $from_date)
							->whereDate('date', '<=', $date)
							->orderBy('date')
							->get();
		}
		else{
			$date = Carbon::today()->subMonth(1)->toDateString();
			$datas = History::whereUserId($id)
						->whereDate('date', '>=', $date)
						->orderBy('date')
						->get();
		}
		return $datas;
	}
    public static function  blood_pressure($id, $date)
       
    {
       
    	if($date){
			$from_date = date("Y-m-d", strtotime($date. "-1 month"));

			$datas = BloodPressure::where('patient_id',$id)
							->whereDate('date', '>=', $from_date)
							->whereDate('date', '<=', $date)
							->orderBy('date')
							->get();

		}
		else{
			$date = Carbon::today()->subMonth(1)->toDateString();
			$datas = BloodPressure::where('patient_id',$id)
						->whereDate('date', '>=', $date)
						->orderBy('date')
						->get();
		}
		return $datas;
    }
	public static function patient_hra_band_data($id)
	{
		$data = History::whereUserId($id)
						->get()
						->sortByDesc('date')
						->first();
		return $data;
	}

	public static function filter_by_afib($org = []){

		$users = Self::filter_patients($org);

		$users = $users->filter(function($user){
			$history = $user->history->toArray();
			if(!empty($history)){
				if($history[0]['afib'] > 1)
					return $user;
			}
		});

        return $users;
	}


	public static function filter_by_arrhythmia($org = []){
		$users = Self::filter_patients($org);

        $users = $users->filter(function($user){
            $history = $user->history->toArray();
			if(!empty($history)){
				if($history[0]['arrhythmia'] > 0)
					return $user;
			}
        });

       return $users;
	}


	public static function filter_abnormal($org = []){
		$users = Self::filter_patients($org);

        $users = $users->filter(function($user){
            $history = $user->history->toArray();
			if(!empty($history)){
				$systolic = Str::before($history[0]['bp'], '/');
	            $diastolic = Str::after($history[0]['bp'], '/');

	            if($history[0]['afib'] > 1 || $history[0]['arrhythmia'] > 1 || $history[0]['hr'] > 100 || $history[0]['hr'] < 70 || $systolic > 140 || $diastolic > 90 || $systolic < 90 || $diastolic < 60)
	                return $user;
			}
        });

        return $users;
	}


	public static function filter_patients($org){
		$users = User::with(['history' => function($query){
						$query->orderByDesc('date')->first();
					}])
					->when(!empty($org), function($q) use ($org){
						$q->whereIn('organisation_id', $org);
					})
					->whereUserRole(4)
					->whereActive(1)
					->get();

		return $users;
	}

	public static function tenant_organisation($id){
		$organisation_ids = OrganisationDetail::whereParentUserId($id)
                                                ->pluck('user_id')
                                                ->toArray();
        return $organisation_ids;

	}

	//Get id of all organisation under a doctor
	public static function doctor_organisation($id){
		return AssignDoctor::where('doctor_user_id', $id)
                    ->pluck('org_user_id')->toArray();

	}


	public static function patient_profile_percentage($user_id)
	{
		$data = PatientProfile::select('gender','height_cm','blood_group','weight_kg','occupation','dob','national_id')
								->where('patient_id', $user_id)->first();

		if($data){
			$data = $data->toArray();
			$total_count = count($data);
			$data = collect($data);

			$data = $data->filter(function($value, $key){
				return $value != Null;
			});

			$data = $data->count();

			$percentage = round(($data/ $total_count) * 100);

			$percentage = ($percentage < 100) ? $percentage : 100.0;

			return $percentage;
		}

		return 0;
	}

	public static function patientHealthProfile($user_id){

		$parent_key = ['diet-type', 'travel-national', 'travel-international', 'cup-of-vegetables', 'cereals-qty', 'fruits',
					   'fast-food', 'drinks', 'vigorus-physical-activity', 'moderate-physical-activity', 'light-physical-activity',
					   'smoking', 'diebetic', 'blood-cholestrol', 'blood-pressure', 'cardiovascular-or-stroke', 'disease', 'allergy',
					   'medication', 'hereditary', 'alcohol'
					];

		$count = PatientHealthProfile::where('patient_id', $user_id)
                                    ->whereActive(1)
                                    ->whereIn('parent_key', $parent_key)
                                    ->get()
                                    ->unique('parent_key')
                                    ->count();

        $percentage = round(($count/count($parent_key))*100);
        $percentage = ($percentage < 100) ? $percentage : 100;

        return $percentage;
	}

	public static function get_user_organisation($user)
	{
		$id = $user->organisation_id;

		if($id){
			$user = User::find($id);

			if($user){
				return $user->name;
			}
		}
		else{
			return NULL;
		}
	}

	public static function get_user_tenant($user)
	{
		$org_id = $user->organisation_id;

		if($org_id){
			$org_details =  OrganisationDetail::with('parent_user')->whereUserId($org_id)->first();

			if($org_details){
				return $tenant_name = $org_details->parent_user->name;
			}
			return NULL;
		}
		else{
			return NULL;
		}
	}

	public static function age($dob)
	{
		$dob = Carbon::parse($dob)->age;
		if($dob){
			return $dob;;
		}
		return '-';
	}

	public static function date_format($date, $format = 'd M, Y')
	{
		return date($format, strtotime($date));
	}
}