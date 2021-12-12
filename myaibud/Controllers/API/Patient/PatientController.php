<?php

namespace Myaibud\Controllers\API\Patient;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Resources\PatientDetailsResource;
use App\Http\Resources\PatientProfileResource;
use App\Medication;
use App\Model\Patient\PatientProfile;
use App\Model\Patient\PatientHhi;
use App\Model\Patient\HeatRateTest;
use App\Model\Patient\BloodPressure;
use App\Model\Patient\HeartRate;
use App\User;
use App\Model\DietPlan;
use Auth, Log;
use Exception;
use App\Model\Sleep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Myaibud\Traits\ProfileScoring;
use Validator;
use App\Model\History;
class PatientController extends Controller
{
	use ProfileScoring;

	public function getProfileImage()
	{
		$patient = Auth::user();

		if (!empty($patient->profile_image) ) {
			//$extension = pathinfo( glob( public_path() . '/images/' . $patient->id  . '.*')[0])['extension'];
			return  response()->json([
				'success' => true,
				'image_url' => url('/' .$patient->profile_image)
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
			$this->removeOldProfileImage($patient->profile_image);
			// dd($patient->profile_image);
			$extension = $profileImage->getClientOriginalExtension();
			// we have an image, get the image data
			// $data = base64_encode(file_get_contents($_FILES['app_image']['tmp_name']));
			$fileName = time() . $patient->id . '.' . $extension;

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
		$path = public_path().'/';
		$file_pattern = $path . $patientId;
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
		$data['age'] = Helper::age(@$data['dob']);
		$data['name'] = $patient->name;
		$data['image_url'] = '';
		if (!empty(glob( public_path() . '/images/' . $patient->id  . '.*') ) ) {
			$extension = pathinfo( glob( public_path() . '/images/' . $patient->id  . '.*')[0])['extension'];
			$data['image_url']= url('/images/' . $patient->id . '.' . $extension);
		}
		if($patient->id == '268'){	
		   $data['covid19_enabled'] = false;
		}else{
			$data['covid19_enabled'] = true;
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
           
		if ($patient->patientProfile()->count() == 0 ) {
			if ($patient->patientProfile()->create($request->all())) {
				$this->calculateBmiScore($patient->patientProfile());
			}
		}else{
			 //if($request->dob!='' && $request->gender!='')
			 //{
               if ($patient->patientProfile()->update($request->all())) {
			   $this->calculateBmiScore($patient->patientProfile());
		       }
			 //}
			  
		}
		
		return response()->json(['success' => true, 'message' => 'Profile Created']);
	}
 public function Heratrate(Request $request)
 {
 	$validator = Validator::make($request->all(), [
			'heart_rate' => 'required',
			'date' => 'required',
		]);

		if($validator->fails()){
			$errors = collect($validator->messages())->flatten()->toArray();
			return response()->json(['success' => false, 'message' => 'Validation Failed', 'validation' => $errors]);
		}
  	
	  	try {
             $HeartRate=new History;
             //$HeartRate->status=1;
             $HeartRate->user_id=Auth::id();
             $HeartRate->hr=$request->heart_rate;
             $HeartRate->date=$request->date;
             $HeartRate->save();
	  		 
	  		return response()->json(['success' => true, 'data' =>$HeartRate]);
	  	} catch (Exception $e) {
	  		//dd($e);
	  		return response()->json(['success' => false, 'message' => 'Some thing wrong.']);
	  	}
 }
 public function getheartrate(Request $request)
 {
	 try {
	 	$authid=Auth::id();
	 	$HeartRate=HeartRate::where('patient_id',$authid)->orderby('date','ASC')->get();
	 	$max=HeartRate::where('patient_id',$authid)->max('heart_rate');
	 	$min=HeartRate::where('patient_id',$authid)->min('heart_rate');
	 	//dd($HeartRate);
	 	$heartarry=[];
	 	 
	 	$iteam=[];
	 	foreach ($HeartRate as $key => $value) {
	 		 
	 		$iteam[]=$value->heart_rate;
	 		$avg=array_sum($iteam)/count($iteam);
	 		 
	 		$heartarry[$value->date]=array('max'=>$max,'min'=>$min,'avg'=>(int)$avg,'heart_rate'=>$value->heart_rate);
	 	}
	 	return response()->json(['success' => true, 'data' =>$heartarry]);
	 } catch (Exception $e) {
	  		return response()->json(['success' => false, 'message' => 'Some thing wrong.']);
	  	}
 	 
 }
    
 public function Heratratetest(Request $request)
  {
    $validator = Validator::make($request->all(), [
			'status' => 'required',
			'start_time' => 'required',
			'end_time' => 'required',
			 
		]);

		if($validator->fails()){
			$errors = collect($validator->messages())->flatten()->toArray();
			return response()->json(['success' => false, 'message' => 'Validation Failed', 'validation' => $errors]);
		}
  	
	  	try {
	  		
	  		$HeatRateTest=HeatRateTest::where('patient_id',Auth::id())->first();
	  		if(is_null($HeatRateTest))
	  		{
             $HeatRateTest=new HeatRateTest;
             $HeatRateTest->status=$request->status;
             $HeatRateTest->patient_id=Auth::id();
             $HeatRateTest->start_time=$request->start_time;
             $HeatRateTest->end_time=$request->end_time;
             $HeatRateTest->save();
	  		}else{
             $HeatRateTest->status=$request->status;
             $HeatRateTest->start_time=$request->start_time;
             $HeatRateTest->end_time=$request->end_time;
             $HeatRateTest->save();
	  		}
	  		return response()->json(['success' => true, 'data' =>$HeatRateTest]);
	  	} catch (Exception $e) {
	  		return response()->json(['success' => false, 'message' => 'Some thing wrong.']);
	  	}
  }

  public function getheartratetest(Request $request){
  
  	try {
	  		
	  		$HeatRateTest=HeatRateTest::where('patient_id',Auth::id())->first();
	  		return response()->json(['success' => true, 'data' =>$HeatRateTest]);
	  	} catch (Exception $e) {
	  		return response()->json(['success' => false, 'message' => 'Some thing wrong.']);
	  	}
  }
  public function Sleephistory(Request $request){
  	
	try {
			
		  $Sleep=Sleep::where('patient_id',Auth::id())->latest()->get();
			return response()->json(['success' => true, 'data' =>$Sleep]);
		} catch (Exception $e) {
			return response()->json(['success' => false, 'message' => 'Some thing wrong.']);
		}
  }
  public function getsleep(Request $request){
  	
	try {
			
		  $Sleep=Sleep::where('patient_id',Auth::id())->latest()->first();
			return response()->json(['success' => true, 'data' =>$Sleep]);
		} catch (Exception $e) {
			return response()->json(['success' => false, 'message' => 'Some thing wrong.']);
		}
  }

  public function Sleep(Request $request)
  {
	 
	$validator = Validator::make($request->all(), [
		   'sleep_houre' => 'required',
		   'light_sleep' => 'required',
		   'deep_slip' => 'required',
		   'awake' => 'required',
		   'date'=>'required'
			
	   ]);

	   if($validator->fails()){
		   $errors = collect($validator->messages())->flatten()->toArray();
		   return response()->json(['success' => false, 'message' => 'Validation Failed', 'validation' => $errors]);
	   }

	 
	   try {
		   $Sleep=Sleep::where('patient_id',Auth::id())
						->where('date',$request->date)->first();
		   if(is_null($Sleep))
		   {
			 $Sleep= new Sleep;
			 $Sleep->sleep_houre=$request->sleep_houre;
			 $Sleep->light_sleep=$request->light_sleep;
			 $Sleep->deep_slip=$request->deep_slip;
			 $Sleep->awake=$request->awake;
			 $Sleep->patient_id=Auth::id();
			 $Sleep->date=$request->date;
			 $Sleep->save();
		   }else{
			 $Sleep->sleep_houre=$request->sleep_houre;
			 $Sleep->light_sleep=$request->light_sleep;
			 $Sleep->deep_slip=$request->deep_slip;
			 $Sleep->awake=$request->awake;
			 $Sleep->patient_id=Auth::id();
			 $Sleep->date=$request->date;
			 $Sleep->save();
		   }
		   return response()->json(['success' => true, 'data' =>$Sleep]);
	   } catch (Exception $e) {
		   return response()->json(['success' => false, 'message' => 'Some thing wrong.']);
	   }
  }
  public function getbloodpressure(Request $request){
  	
  	try {
	  		
	  	  $blood=BloodPressure::where('patient_id',Auth::id())->latest()->first();
	  		return response()->json(['success' => true, 'data' =>$blood]);
	  	} catch (Exception $e) {
	  		return response()->json(['success' => false, 'message' => 'Some thing wrong.']);
	  	}
  }
   
   public function bloodpressure(Request $request)
   {
      $validator = Validator::make($request->all(), [
			'blood_pressure_val' => 'required',
			//'spo2' => 'required',
			//'fatigue' => 'required',
			'date'=>'required'
			 
		]);

		if($validator->fails()){
			$errors = collect($validator->messages())->flatten()->toArray();
			return response()->json(['success' => false, 'message' => 'Validation Failed', 'validation' => $errors]);
		}

      
		try {
			$BloodPressure=History::where('user_id',Auth::id())
			                                 ->where('date',$request->date)->first();
			if(is_null($BloodPressure))
			{
              $BloodPressure= new History;
              $BloodPressure->bp=$request->blood_pressure_val;
              //$BloodPressure->spo2=$request->spo2;
              //$BloodPressure->fatigue=$request->fatigue;
              $BloodPressure->user_id=Auth::id();
              $BloodPressure->date=$request->date;
              $BloodPressure->save();
			}else{
              $BloodPressure->bp=$request->blood_pressure_val;
             // $BloodPressure->spo2=$request->spo2;
              //$BloodPressure->fatigue=$request->fatigue;
              $BloodPressure->user_id=Auth::id();
              $BloodPressure->date=$request->date;
              $BloodPressure->save();
			}
			return response()->json(['success' => true, 'data' =>$BloodPressure]);
		} catch (Exception $e) {
			return response()->json(['success' => false, 'message' => 'Some thing wrong.']);
		}
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

	public function get_hhi()
    {
	    $id=Auth::id();
		$today=date('Y-m-d H:s:i');
         $beforeday=date('Y-m-d H:s:i',strtotime('-30 day'));
         $hhi= PatientHhi::select('id','hhi','created_at as date')->where('patient_id',$id)->whereBetween('created_at',[$beforeday,$today])->get();
            $HHI=[];
            $temp=[];
            foreach ($hhi as $key => $value) {
                
               $HHI[$key]['date']= date('d-M',strtotime($value->date));
               $HHI[$key]['hhi']=$value->hhi;
               $temp[]=$value->hhi;
               $avg=array_sum($temp)/count($temp);
               $HHI[$key]['avg']=round($avg,2);

			}
			if(count($HHI)>0)
			{
				return response()->json(['status' => true, 'status code' => 200, 'data' => $HHI]);
			}else{
				return response()->json(['status' => true, 'status code' => 404, 'message' => 'Not Containt Found']);
			}
    }

    public function dietplanlist(Request $request)
    {
    	$validator = Validator::make($request->all(), [
			'user_id' => 'required',
			 
		]);

		if($validator->fails()){
			$errors = collect($validator->messages())->flatten()->toArray();
			return response()->json(['success' => false, 'message' => 'Validation Failed', 'validation' => $errors]);
		}
		try{
            $data=DietPlan::with('user')->where('user_id',$request->user_id)->get();

		}catch(Exception $e)
		{
           return response()->json(['success' => false, 'message' => 'Some thing wrong.']);
		}
		return response()->json(['success' => true, 'message' => 'diet Plan','data'=>$data]);
    }
}