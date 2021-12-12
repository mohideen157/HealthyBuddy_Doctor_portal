<?php

namespace App\Http\Controllers;

//use GuzzleHttp\Client;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Model\AdminSettings;
use App\Model\Doctor\DoctorProfile;
use App\Model\Notification;
use App\Model\PasswordResetCodes;
use App\Model\Patient\PatientCreditLogs;
use App\Model\Patient\PatientCredits;
use App\Model\UserRole;
use App\Model\User\CancelRescheduleCount;
use App\Model\User\UserReferralCode;
use App\Model\VerificationCodes;
use App\User;
use Auth;
use Carbon\Carbon;
use Config;
use DB;
use Exception;
use Hash;
use JWTAuth;
use Mail;
use Socialite;
use App\Model\Medcheck\medcheckuser;
use App\Model\Medcheck\medcheckuserstable;
use App\Model\Medcheck\medcheckecgdata;
use App\Model\Medcheck\medcheckweightscale;
use App\Model\Medcheck\medcheckspo2;
use App\Model\Medcheck\medchecktemparature;
use App\Model\Medcheck\medcheckglucosedata;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use URL;
use Validator;

class MedcheckDb2DbSyncApiController extends Controller
{
    private $settings;

  /**
   * Instantiate a new MedcheckDb2DbSyncApiController instance.
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
    
    //MEDCHECK DATA Db2DbSync
  public function registermedcheckuser(Request $request){
        //echo 'registermedcheckuser-start-'.str_replace('+', '', $request['country_code']).$request['mobile_number'];
        $validator = Validator::make($request->all(), [
      'name' => 'nullable|max:255',
      'email' => 'nullable|email|max:255',
      'mobile_no' => 'required',
      'country_code' => 'required|numeric',
      'organisation_id' => 'nullable|exists:users,id',
      'password' => 'required'
    ]);

    if($validator->fails()){
      $errors = collect($validator->messages())->flatten()->toArray();
      return response()->json(['success' => false, 'message' => 'Validation Failed', 'validation' => $errors]);
    }

    // Check Whether Patient Mobile or Email Exists or Not.
    //$email_exists = User::whereEmail($request->email)
    //          ->whereUserRole(4)
    //          ->exists();

    $mobile_exists = User::whereMobileNo($request->country_code.$request->mobile_no)
              ->whereUserRole(4)
              ->exists();

    //if($email_exists){
    //  return response()->json(['success' => false, 'message' => 'Email already Exists']);
    //}

    if($mobile_exists){
      return response()->json(['success' => false, 'message' => 'Mobile Number already Exists']);
    }

    try{

      DB::beginTransaction();
      // Create Patient 
      $patient = new User();
      $patient->user_role = 4;
      $patient->name = $request->name;
      $patient->email = $request->email;
      $patient->mobile_no = $request->country_code.$request->mobile_no;
      $patient->organisation_id = $request->organisation_id;
      $patient->password = bcrypt($request->password);
      $patient->save();

      $patient->shdct_user_id = Config::get('sheDoctr.db.patientPrefix').$patient->id;
      $patient->save();

      //Send Sms for User Mobile Verification
      $verification_code = mt_rand(1000, 9999);
      $msgtxt = '<#> C2P: Your Cover2Protect verification code is '.$verification_code.' SRwtvi7PLLR';
      $msgData = array(
        'recipient_no' => $patient->mobile_no,
        'msgtxt' => $msgtxt
      );
      $sendsms = Helper::sendSMS($msgData);
      $sendemail = Helper::sendMail($patient->mobile_no,$verification_code);
      DB::commit();

      return response()->json(['success' => true, 'message' => 'User Registered Successfully', 'otp' => $verification_code, 'data' => $patient]);
    }
    catch(\Exception $e){
       
      DB::rollBack();
      return response()->json(['success' => false, 'message' => 'Something Went Wrong']);
    }
    }
       public function SyncMedCheckUsers()
       {

        $curl = curl_init();
 
  curl_setopt_array($curl, array(
  CURLOPT_URL => "https://getmedcheck.com/medcheckfte/api/get-user-data",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS =>"{\n\t\"data\":{\n\t\t\"token\":\"4mzpc3yzzocgksoc4s4s00gskkscc8\",\n\t\t\"per_page\":\"100\",\n\t\t\"page_no\":\"1\"\n\t}\n}",
  CURLOPT_HTTPHEADER => array(
    "Content-Type: text/plain"
  ),
));

$response = curl_exec($curl);

curl_close($curl);
//echo $response;
//$response_data  = json_encode(unserialize(serialize($response)));
$response_data = json_decode($response, true);
//return response()->json($response_data['data'][0]);


            //foreach($response_data['data'] as $i => $v)
            foreach($response_data['data'] as $v)
            { 
                //echo $v['mobile_number'].'-';
                //return response()->json($v);
                //=============Inser User into C2P=========
                // Check Whether Patient Mobile or Email Exists or Not.
    //$email_exists = User::whereEmail($request->email)
    //          ->whereUserRole(4)
    //          ->exists();
//str_replace('+', '', $v['country_code']); 
    $mobile_exists = User::whereMobileNo(str_replace('+', '', $v['country_code']).$v['mobile_number'])
        ->whereUserRole(4)
        ->exists();

//if(!$email_exists){ 
//  return response()->json(['success' => false, 'message' => 'Email already Exists']);
//}
//!empty(str_replace(' ', '', $v['email']))

if(!$mobile_exists){
//return response()->json(['success' => false, 'message' => 'Mobile Number already Exists']);
//} 
try{

    DB::beginTransaction();
    // Create Patient 
    $patient = new User();
    $patient->user_role = 4;
    $patient->name = ' ';
    $patient->email = $v['email'];
    $patient->mobile_no = str_replace('+', '', $v['country_code']).$v['mobile_number'];
    $patient->organisation_id = '4';
    $patient->password = bcrypt('welcome@c2p');
    $patient->save();

    $patient->shdct_user_id = Config::get('sheDoctr.db.patientPrefix').$patient->id;
    $patient->save();

    //Send Sms for User Mobile Verification
    //$verification_code = mt_rand(1000, 9999);
    $msgtxt = 'Dear '.$patient->name.', Thank you for being with Cover2Protect. Kindly complete your registration by clicking the below link. http://127.0.0.1:8000/registermedcheck/'.$patient->mobile_no;
    $msgData = array(
        'recipient_no' => $patient->mobile_no,
        'msgtxt' => $msgtxt
    );
    //$sendsms = Helper::sendSMS($msgData);
    //$sendemail = Helper::sendMail($patient->mobile_no,$verification_code);
    DB::commit();

    //return response()->json(['success' => true, 'message' => 'User Registered Successfully', 'otp' => $verification_code, 'data' => $patient]);
}
catch(\Exception $e){
     
    DB::rollBack();
    echo $e; //'Error - rollback';//->$patient;
    //return response()->json(['success' => false, 'message' => 'Something Went Wrong']);
}
                //=========================================              
                //echo $v['mobile_number'].'-'.$i;
                //$regUser = $this->registermedcheckuser($v);
                //echo '-result '.$regUser;
                //return response()->json($regUser);
}// mobile exist check end
else{echo 'Mobile Number already Exists -'.$v['mobile_number'].'-'.$v['email'].',';}
} //foreach end
return response()->json(['success' => true, 'message' => 'User Sync Successfully']);
    
}

public function SyncMedCheckBp($id)
{  
  if(strlen(trim($id)) > 10){
    $mobnum=trim($id);
    //$mobnum=substr(trim($id), 2, 10); 
  }
  else{
    $mobnum="91".trim($id);
    //$mobnum=substr_replace("91",trim($id),2);
  }
$userid =medcheckuserstable::where('mobile_no', $mobnum)->value('id');
 
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://getmedcheck.com/medcheckfte/api/get-user-blood-pressure-data",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS =>"{\n\t\"data\":{\n\t\t\"mobile_number\":\"".$id."\",\n\t\t\"token\":\"4mzpc3yzzocgksoc4s4s00gskkscc8\"\n\t}\n}",
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/json"
  ),
));
//return "{\n\t\"data\":{\n\t\t\"mobile_number\":\"".$id."\",\n\t\t\"token\":\"4mzpc3yzzocgksoc4s4s00gskkscc8\"\n\t}\n}";
$response = curl_exec($curl);

curl_close($curl);
$response_data = json_decode($response, true);
//return response()->json($response_data['data']);
            
foreach($response_data['data'] as $v)
{ 
                
  $device_reading_time= medcheckuser::wheredevice_reading_time($v['device_reading_time'])
                                      ->whereuser_id($userid)
                                      ->exists();



if(!$device_reading_time){
//return response()->json(['success' => false, 'message' => 'Mobile Number already Exists']);
//} 
try {

    DB::beginTransaction();
    // Create Patient 
    $patient = new medcheckuser();
    $patient->user_id = $userid;
    $patient->bp =str_replace('/', '', $v['systolic']).$v['diastolic'];
    $patient->device_reading_time =$v['device_reading_time'];
    $patient->mobile_no=$mobnum;
    $patient->save();

    DB::commit();
    
}
catch(\Exception $e){
     
    DB::rollBack();
    echo $e; //'Error - rollback';//->$patient;
    //return response()->json(['success' => false, 'message' => $e]);
}
  
}// mobile exist check end
else
{
  echo 'reading already exists on same time -'.$v['systolic'].'-'.$v['diastolic'].',';
}

} //foreach end
return response()->json(['success' => true, 'message' => 'User Sync bp Successfully']);
}

public function SyncMedCheckHr($id)
{
  if(strlen(trim($id)) > 10){
    $mobnum=trim($id);
    //$mobnum=substr(trim($id), 2, 10); 
  }
  else{
    $mobnum="91".trim($id);
    //$mobnum=substr_replace("91",trim($id),2);
  }
 
 $userid =medcheckuserstable::where('mobile_no', $mobnum)->value('id');

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://getmedcheck.com/medcheckfte/api/get-user-ecg-data",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS =>"{\r\n\t\"data\":{\r\n\t\t\"mobile_number\":\"".$id."\",\r\n\t\t\"token\":\"4mzpc3yzzocgksoc4s4s00gskkscc8\"\r\n\t}\r\n}",
  CURLOPT_HTTPHEADER => array(
    "Content-Type: text/plain"
  ),
));

$response = curl_exec($curl);

curl_close($curl);
$response_data = json_decode($response, true);
//return response()->json($response_data['data'][0]);


            //foreach($response_data['data'] as $i => $v)
            foreach($response_data['data'] as $v)
           { 
                //echo $v['mobile_number'].'-';
                //return response()->json($v);
                //=============Inser User into C2P=========
                // Check Whether Patient Mobile or Email Exists or Not.
   // $hr = medcheckecgdata::wherehr($v['hr'])
           //   ->whereuser_id(1)
             // ->exists();
             $device_reading_time= medcheckecgdata::wheredevice_reading_time($v['device_reading_time'])
              ->whereuser_id($userid)
              ->exists();

//str_replace('+', '', $v['country_code']); 
   // $bp = medcheckecgdata::whereBp(str_replace('+', '', $v['systolic']).$v['diastolic'])
       // ->whereid(1)
      // ->exists();

//if(!$email_exists){ 
//  return response()->json(['success' => false, 'message' => 'Email already Exists']);
//}
//!empty(str_replace(' ', '', $v['email']))


if(!$device_reading_time){
//return response()->json(['success' => false, 'message' => 'Mobile Number already Exists']);
//} 
try {

    DB::beginTransaction();
    // Create Patient 
    $patient = new medcheckecgdata();
    $patient->user_id = $userid;
    $patient->hr =$v['hr'];
    $patient->qrs =$v['qrs']; 
    $patient->qt =$v['qt'];
    $patient->ecg_result =$v['ecg_result'];
    $patient->mobile_no=$mobnum;
    $patient->save();

    //$patient->id = Config::get('she.db.patientPrefix').$patient->id;
    //$patient->save();

    //Send Sms for User Mobile Verification
    //$verification_code = mt_rand(1000, 9999);
    //$msgtxt = 'Dear '.$patient->name.', Thank you for being with Cover2Protect. Kindly complete your registration by clicking the below link. http://127.0.0.1:8000/registermedcheck/'.$patient->mobile_no;
   // $msgData = array(
        //'recipient_no' => $patient->mobile_no,
        //'msgtxt' => $msgtxt
    //);
    //$sendsms = Helper::sendSMS($msgData);
    //$sendemail = Helper::sendMail($patient->mobile_no,$verification_code);
    DB::commit();

    //return response()->json(['success' => true, 'message' => 'User Registered Successfully', 'otp' => $verification_code, 'data' => $patient]);
}
catch(\Exception $e){
     
    DB::rollBack();
    echo $e; //'Error - rollback';//->$patient;
    //return response()->json(['success' => false, 'message' => 'Something Went Wrong']);
}
                //=========================================              
                //echo $v['mobile_number'].'-'.$i;
                //$regUser = $this->registermedcheckuser($v);
                //echo '-result '.$regUser;
                //return response()->json($regUser);
}// mobile exist check end
else
{
  echo 'reading already exists on same time ';
}

} //foreach end
return response()->json(['success' => true, 'message' => 'User Sync Heart Rate Successfully']);
}






public function SyncMedCheckWeightScale($id)
{
  if(strlen(trim($id)) > 10){
    $mobnum=trim($id);
    //$mobnum=substr(trim($id), 2, 10); 
  }
  else{
    $mobnum="91".trim($id);
    //$mobnum=substr_replace("91",trim($id),2);
  }
 
 $userid =medcheckuserstable::where('mobile_no', $mobnum)->value('id');  
   
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://getmedcheck.com/medcheckfte/api/get-user-weight-scale-data",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS =>"{\n\t\"data\":{\n\t\t\"mobile_number\":\"".$id."\",\n\t\t\"token\":\"4mzpc3yzzocgksoc4s4s00gskkscc8\"\n\t}\n}",
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/json"
  ),
));

$response = curl_exec($curl);

curl_close($curl);
$response_data = json_decode($response, true);
//return response()->json($response_data['data'][0]);


            //foreach($response_data['data'] as $i => $v)
            foreach($response_data['data'] as $v)
           { 
                //echo $v['mobile_number'].'-';
                //return response()->json($v);
                //=============Inser User into C2P=========
                // Check Whether Patient Mobile or Email Exists or Not.
    //$bmi_weight = medcheckweightscale::wherebmi_weight($v['bmi_weight'])
      //      ->whereid(1)
        //    ->exists();
//str_replace('+', '', $v['country_code']); 
    //$bp = medcheckuser::whereBp(str_replace('+', '', $v['systolic']).$v['diastolic'])
       // ->whereuser_id(4)
      //  ->exists();
             $device_reading_time= medcheckweightscale::wheredevice_reading_time($v['device_reading_time'])
              ->whereuser_id($userid)
              ->exists();


//if(!$email_exists){ 
//  return response()->json(['success' => false, 'message' => 'Email already Exists']);
//}
//!empty(str_replace(' ', '', $v['email']))


if(!$device_reading_time){
//return response()->json(['success' => false, 'message' => 'Mobile Number already Exists']);
//} 
try {

    DB::beginTransaction();
    // Create Patient 
    $patient = new medcheckweightscale();
    $patient->user_id = $userid;
    $patient->bmi_weight=$v['bmi_weight'];
    $patient->bmi=$v['bmi']; 
    $patient->fat_per=$v['fat_per'];
    $patient->muscle_per=$v['muscle_per'];
    $patient->bmr=$v['bmr'];
    $patient->device_reading_time=$v['device_reading_time'];
    $patient->mobile_no=$mobnum;
    $patient->save();

    //$patient->id = Config::get('she.db.patientPrefix').$patient->id;
    //$patient->save();

    //Send Sms for User Mobile Verification
    //$verification_code = mt_rand(1000, 9999);
    //$msgtxt = 'Dear '.$patient->name.', Thank you for being with Cover2Protect. Kindly complete your registration by clicking the below link. http://127.0.0.1:8000/registermedcheck/'.$patient->mobile_no;
   // $msgData = array(
        //'recipient_no' => $patient->mobile_no,
        //'msgtxt' => $msgtxt
    //);
    //$sendsms = Helper::sendSMS($msgData);
    //$sendemail = Helper::sendMail($patient->mobile_no,$verification_code);
    DB::commit();

    //return response()->json(['success' => true, 'message' => 'User Registered Successfully', 'otp' => $verification_code, 'data' => $patient]);
}
catch(\Exception $e){
     
    DB::rollBack();
    echo $e; //'Error - rollback';//->$patient;
    //return response()->json(['success' => false, 'message' => 'Something Went Wrong']);
}
                //=========================================              
                //echo $v['mobile_number'].'-'.$i;
                //$regUser = $this->registermedcheckuser($v);
                //echo '-result '.$regUser;
                //return response()->json($regUser);
}// mobile exist check end
else
{
  echo 'reading already exists on same time';
}

} //foreach end
return response()->json(['success' => true, 'message' => 'User Sync Weight Scale Successfully']);
}


public function SyncMedCheckSpo2Data($id)
{
  if(strlen(trim($id)) > 10){
    $mobnum=trim($id);
    //$mobnum=substr(trim($id), 2, 10); 
  }
  else{
    $mobnum="91".trim($id);
    //$mobnum=substr_replace("91",trim($id),2);
  }
 
 $userid =medcheckuserstable::where('mobile_no', $mobnum)->value('id');
 
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://getmedcheck.com/medcheckfte/api/get-user-spo2-data",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS =>"{\n\t\"data\":{\n\t\t\"mobile_number\":\"".$id."\",\n\t\t\"token\":\"4mzpc3yzzocgksoc4s4s00gskkscc8\"\n\t}\n}",
  CURLOPT_HTTPHEADER => array(
    "Content-Type: text/plain"
  ),
));

$response = curl_exec($curl);

curl_close($curl);
$response_data = json_decode($response, true);
//return response()->json($response_data['data'][0]);


            //foreach($response_data['data'] as $i => $v)
            foreach($response_data['data'] as $v)
           { 
                //echo $v['mobile_number'].'-';
                //return response()->json($v);
                //=============Inser User into C2P=========
                // Check Whether Patient Mobile or Email Exists or Not.
    //$spo2_value = medcheckspo2::wherespo2_value($v['spo2_value'])
       //     ->whereuser_id(0)
         //   ->exists();
             $device_reading_time= medcheckspo2::wheredevice_reading_time($v['device_reading_time'])
              ->whereuser_id($userid)
              ->exists();
//str_replace('+', '', $v['country_code']); 
    
//if(!$email_exists){ 
//  return response()->json(['success' => false, 'message' => 'Email already Exists']);
//}
//!empty(str_replace(' ', '', $v['email']))


if(!$device_reading_time){
//return response()->json(['success' => false, 'message' => 'Mobile Number already Exists']);
//} 
try {

    DB::beginTransaction();
    // Create Patient 
    $patient = new medcheckspo2();
    $patient->user_id =$userid;
    $patient->spo2_value =$v['spo2_value'];
    $patient->pr =$v['pr']; 
    $patient->pi =$v['pi'];
    $patient->spo2_result =$v['spo2_result'];
    $patient->device_reading_time =$v['device_reading_time'];
    $patient->mobile_no=$mobnum;
    $patient->save();

    //$patient->id = Config::get('she.db.patientPrefix').$patient->id;
    //$patient->save();

    //Send Sms for User Mobile Verification
    //$verification_code = mt_rand(1000, 9999);
    //$msgtxt = 'Dear '.$patient->name.', Thank you for being with Cover2Protect. Kindly complete your registration by clicking the below link. http://127.0.0.1:8000/registermedcheck/'.$patient->mobile_no;
   // $msgData = array(
        //'recipient_no' => $patient->mobile_no,
        //'msgtxt' => $msgtxt
    //);
    //$sendsms = Helper::sendSMS($msgData);
    //$sendemail = Helper::sendMail($patient->mobile_no,$verification_code);
    DB::commit();

    //return response()->json(['success' => true, 'message' => 'User Registered Successfully', 'otp' => $verification_code, 'data' => $patient]);
}
catch(\Exception $e){
     
    DB::rollBack();
    echo $e; //'Error - rollback';//->$patient;
    //return response()->json(['success' => false, 'message' => 'Something Went Wrong']);
}
                //=========================================              
                //echo $v['mobile_number'].'-'.$i;
                //$regUser = $this->registermedcheckuser($v);
                //echo '-result '.$regUser;
                //return response()->json($regUser);
}// mobile exist check end
else
{
  echo 'reading already exists on same time';
}

} //foreach end
return response()->json(['success' => true, 'message' => 'User Sync Spo2 Data Successfully']);
}




public function SyncMedCheckTemparatureData($id)
{
  if(strlen(trim($id)) > 10){
    $mobnum=trim($id);
    //$mobnum=substr(trim($id), 2, 10); 
  }
  else{
    $mobnum="91".trim($id);
    //$mobnum=substr_replace("91",trim($id),2);
  }
 
 $userid =medcheckuserstable::where('mobile_no', $mobnum)->value('id');
 
 $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://getmedcheck.com/medcheckfte/api/get-user-temperature-data",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS =>"{\r\n\t\"data\":{\r\n\t\t\"mobile_number\":\"".$id."\",\r\n\t\t\"token\":\"4mzpc3yzzocgksoc4s4s00gskkscc8\"\r\n\t}\r\n}",
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/json"
  ),
));

$response = curl_exec($curl);

curl_close($curl);
$response_data = json_decode($response, true);
//return response()->json($response_data['data'][0]);


            //foreach($response_data['data'] as $i => $v)
            foreach($response_data['data'] as $v)
           { 
                //echo $v['mobile_number'].'-';
                //return response()->json($v);
                //=============Inser User into C2P=========
                // Check Whether Patient Mobile or Email Exists or Not.
  //  $ptt_value = medchecktemparature::whereptt_value($v['ptt_value'])
    //        ->whereid(1)
      //      ->exists();
//str_replace('+', '', $v['country_code']); 
    $device_reading_time= medchecktemparature::wheredevice_reading_time($v['device_reading_time'])
              ->whereuser_id($userid)
              ->exists();
//if(!$email_exists){ 
//  return response()->json(['success' => false, 'message' => 'Email already Exists']);
//}
//!empty(str_replace(' ', '', $v['email']))


if(!$device_reading_time){
//return response()->json(['success' => false, 'message' => 'Mobile Number already Exists']);
//} 
try {

    DB::beginTransaction();
    // Create Patient 
    $patient = new medchecktemparature();
    $patient->user_id = $userid;
    $patient->ptt_value=$v['ptt_value'];
    $patient->measure_mode=$v['measure_mode']; 
    $patient->device_reading_time=$v['device_reading_time'];
    $patient->mobile_no=$mobnum;
    $patient->save();

    //$patient->id = Config::get('she.db.patientPrefix').$patient->id;
    //$patient->save();

    //Send Sms for User Mobile Verification
    //$verification_code = mt_rand(1000, 9999);
    //$msgtxt = 'Dear '.$patient->name.', Thank you for being with Cover2Protect. Kindly complete your registration by clicking the below link. http://127.0.0.1:8000/registermedcheck/'.$patient->mobile_no;
   // $msgData = array(
        //'recipient_no' => $patient->mobile_no,
        //'msgtxt' => $msgtxt
    //);
    //$sendsms = Helper::sendSMS($msgData);
    //$sendemail = Helper::sendMail($patient->mobile_no,$verification_code);
    DB::commit();

    //return response()->json(['success' => true, 'message' => 'User Registered Successfully', 'otp' => $verification_code, 'data' => $patient]);
}
catch(\Exception $e){
     
    DB::rollBack();
    echo $e; //'Error - rollback';//->$patient;
    //return response()->json(['success' => false, 'message' => 'Something Went Wrong']);
}
                //=========================================              
                //echo $v['mobile_number'].'-'.$i;
                //$regUser = $this->registermedcheckuser($v);
                //echo '-result '.$regUser;
                //return response()->json($regUser);
}// mobile exist check end
else
{
  echo 'reading already exists on same time';
}

} //foreach end
return response()->json(['success' => true, 'message' => 'User Sync Temparature Data Successfully']);
}


//still work there

public function SyncMedCheckGlucoseData($id)
{
  if(strlen(trim($id)) > 10){
    $mobnum=trim($id);
    //$mobnum=substr(trim($id), 2, 10); 
  }
  else{
    $mobnum="91".trim($id);
    //$mobnum=substr_replace("91",trim($id),2);
  }
 
 $userid =medcheckuserstable::where('mobile_no', $mobnum)->value('id');
//$userid =medcheckuserstable::where('email', ['email' => $id])->value('id');

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://getmedcheck.com/medcheckfte/api/get-user-glucose-data",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS =>"{\n\t\"data\":{\n\t    \"mobile_number\": \"".$id."\",\n\t\t\"token\":\"4mzpc3yzzocgksoc4s4s00gskkscc8\"\n\t}\n}",
  CURLOPT_HTTPHEADER => array(
    "Content-Type: text/plain"
  ),
));

$response = curl_exec($curl);

curl_close($curl);
$response_data = json_decode($response, true);

//return response()->json($response_data['data']);


            //foreach($response_data['data'] as $i => $v)
            foreach($response_data['data'] as $v)
           { 
                //echo $v['mobile_number'].'-';
                //return response()->json($v);
                
            //return $v['device_reading_time'];
             $dataExists= medcheckglucosedata::wheredevice_reading_time($v['device_reading_time'])
              ->whereuser_id($userid)
              ->exists();


if(!$dataExists){
  //return json_decode($dataExists);
//return response()->json(['success' => false, 'message' => 'Mobile Number already Exists']);
//} 
try {

    DB::beginTransaction();
    // Create Patient 
    $patient = new medcheckglucosedata();
    $patient->user_id =$userid;
    $patient->high_blood=$v['high_blood'];
    $patient->indicator=$v['indicator']; 
    $patient->device_reading_time=$v['device_reading_time'];
    $patient->mobile_no =$mobnum;
    $patient->save();
    
    DB::commit();

    //return response()->json(['success' => true, 'message' => 'User Registered Successfully', 'otp' => $verification_code, 'data' => $patient]);
}
catch(\Exception $e){
     
    DB::rollBack();
    echo $e; //'Error - rollback';//->$patient;
    //return response()->json(['success' => false, 'message' => 'Something Went Wrong']);
}
              
}// mobile exist check end
else
{
  echo 'reading already exists on same time';
}

} //foreach end
return response()->json(['success' => true, 'message' => 'User Sync Glucose Data Successfully']);
}

//getoperation
public function getuseralldata(Request $request){
  //return response()->json($request->all());
  $validator = Validator::make($request->all(), [
  'mobile_no' => 'required|numeric',
  'start_datetime' => 'required',
  'end_datetime' => 'required'
  ]);
  
  if($validator->fails()){
  $errors = collect($validator->messages())->flatten()->toArray();
  return response()->json(['success' => false, 'message' => 'Validation Failed', 'validation' => $errors]);
  }
  
  if(strlen(trim($request->mobile_no)) > 10){
    $mobnum=trim($request->mobile_no);
    //$mobnum=substr(trim($id), 2, 10); 
  }
  else{
    $mobnum="91".trim($request->mobile_no);
    //$mobnum=substr_replace("91",trim($id),2);
  }
  
  $from = date($request->start_datetime);
  $to = date($request->end_datetime);
  //echo ($from.';'. $to);

  $data = [];
  //$data['patient_id'] = '';
  //BP Data  
  $data['bloodpressure'] =medcheckuser::where('mobile_no',$mobnum)
                        ->whereBetween('device_reading_time', [$from, $to])
                        ->get();

 //BG Data   
 $data['bloodglucose'] =medcheckglucosedata::where('mobile_no',$mobnum)
                        ->whereBetween('device_reading_time', [$from, $to])
                        ->get();  

//BMI Weight Scale
$data['bmiweightscale']  =medcheckweightscale::where('mobile_no',$mobnum)
->whereBetween('device_reading_time', [$from, $to])
->get();

//SPO2 Data
$data['spo2'] =medcheckspo2::where('mobile_no',$mobnum)
                        ->whereBetween('device_reading_time', [$from, $to])
                        ->get();

//ECG Data
$data['ecg'] =medcheckecgdata::where('mobile_no',$mobnum)
                        ->whereBetween('device_reading_time', [$from, $to])
                        ->get();

//Temperature
$data['bodytemp'] =medchecktemparature::where('mobile_no',$mobnum)
                        ->whereBetween('device_reading_time', [$from, $to])
                        ->get();


$datacount = count($data);
//echo 'datacount: '.$datacount;
if($datacount > 0)
{  
  return response()->json(['success' => true, 'message' =>'Records Found.','data'=>$data]);
}
else
{  
  return response()->json(['success' => false, 'message' =>'No Record(s) Found.']);
}

}

public function getuserbpdata(Request $request){
  //return response()->json($request->all());
  $validator = Validator::make($request->all(), [
  'mobile_no' => 'required|numeric',
  'start_datetime' => 'required',
  'end_datetime' => 'required'
  ]);
  
  if($validator->fails()){
  $errors = collect($validator->messages())->flatten()->toArray();
  return response()->json(['success' => false, 'message' => 'Validation Failed', 'validation' => $errors]);
  }
  
  if(strlen(trim($request->mobile_no)) > 10){
    $mobnum=trim($request->mobile_no);
    //$mobnum=substr(trim($id), 2, 10); 
  }
  else{
    $mobnum="91".trim($request->mobile_no);
    //$mobnum=substr_replace("91",trim($id),2);
  }
  
  $from = date($request->start_datetime);
  $to = date($request->end_datetime);
  //echo ($from.';'. $to);
  $data =medcheckuser::where('mobile_no',$mobnum)
                        ->whereBetween('device_reading_time', [$from, $to])
                        ->get();

$datacount = $data->count();
//echo 'datacount: '.$datacount;
if($datacount > 0)
{  
  return response()->json(['success' => true, 'message' =>'Records Found.','data'=>$data]);
}
else
{  
  return response()->json(['success' => false, 'message' =>'No Record(s) Found.']);
}

}

public function getuserweightscaledata(Request $request){
  //return response()->json($request->all());
  $validator = Validator::make($request->all(), [
  'mobile_no' => 'required|numeric',
  'start_datetime' => 'required',
  'end_datetime' => 'required'
  ]);
  
  if($validator->fails()){
  $errors = collect($validator->messages())->flatten()->toArray();
  return response()->json(['success' => false, 'message' => 'Validation Failed', 'validation' => $errors]);
  }
  
  if(strlen(trim($request->mobile_no)) > 10){
    $mobnum=trim($request->mobile_no);
    //$mobnum=substr(trim($id), 2, 10); 
  }
  else{
    $mobnum="91".trim($request->mobile_no);
    //$mobnum=substr_replace("91",trim($id),2);
  }
  
  $from = date($request->start_datetime);
  $to = date($request->end_datetime);
  //echo ($from.';'. $to);
  $data =medcheckweightscale::where('mobile_no',$mobnum)
                        ->whereBetween('device_reading_time', [$from, $to])
                        ->get();

  $datacount = $data->count();
  //echo 'datacount: '.$datacount;
  if($datacount > 0)
  {  
    return response()->json(['success' => true, 'message' =>'Records Found.','data'=>$data]);
  }
  else
  {  
    return response()->json(['success' => false, 'message' =>'No Record(s) Found.']);
  }

}
public function getuserglucosedata(Request $request){
  //return response()->json($request->all());
  $validator = Validator::make($request->all(), [
  'mobile_no' => 'required|numeric',
  'start_datetime' => 'required',
  'end_datetime' => 'required'
  ]);
  
  if($validator->fails()){
  $errors = collect($validator->messages())->flatten()->toArray();
  return response()->json(['success' => false, 'message' => 'Validation Failed', 'validation' => $errors]);
  }
  
  if(strlen(trim($request->mobile_no)) > 10){
    $mobnum=trim($request->mobile_no);
    //$mobnum=substr(trim($id), 2, 10); 
  }
  else{
    $mobnum="91".trim($request->mobile_no);
    //$mobnum=substr_replace("91",trim($id),2);
  }
  
  $from = date($request->start_datetime);
  $to = date($request->end_datetime);
  //echo ($from.';'. $to);
  $data =medcheckglucosedata::where('mobile_no',$mobnum)
                        ->whereBetween('device_reading_time', [$from, $to])
                        ->get();

  $datacount = $data->count();
  //echo 'datacount: '.$datacount;
  if($datacount > 0)
  {  
    return response()->json(['success' => true, 'message' =>'Records Found.','data'=>$data]);
  }
  else
  {  
    return response()->json(['success' => false, 'message' =>'No Record(s) Found.']);
  }

}
public function getuserspo2(Request $request){
  //return response()->json($request->all());
  $validator = Validator::make($request->all(), [
  'mobile_no' => 'required|numeric',
  'start_datetime' => 'required',
  'end_datetime' => 'required'
  ]);
  
  if($validator->fails()){
  $errors = collect($validator->messages())->flatten()->toArray();
  return response()->json(['success' => false, 'message' => 'Validation Failed', 'validation' => $errors]);
  }
  
  if(strlen(trim($request->mobile_no)) > 10){
    $mobnum=trim($request->mobile_no);
    //$mobnum=substr(trim($id), 2, 10); 
  }
  else{
    $mobnum="91".trim($request->mobile_no);
    //$mobnum=substr_replace("91",trim($id),2);
  }
  
  $from = date($request->start_datetime);
  $to = date($request->end_datetime);
  //echo ($from.';'. $to);
  $data =medcheckspo2::where('mobile_no',$mobnum)
                        ->whereBetween('device_reading_time', [$from, $to])
                        ->get();
 
  $datacount = $data->count();
  //echo 'datacount: '.$datacount;
  if($datacount > 0)
  {  
    return response()->json(['success' => true, 'message' =>'Records Found.','data'=>$data]);
  }
  else
  {  
    return response()->json(['success' => false, 'message' =>'No Record(s) Found.']);
  }

}
public function getuserecgdata(Request $request){
  //return response()->json($request->all());
  $validator = Validator::make($request->all(), [
  'mobile_no' => 'required|numeric',
  'start_datetime' => 'required',
  'end_datetime' => 'required'
  ]);
  
  if($validator->fails()){
  $errors = collect($validator->messages())->flatten()->toArray();
  return response()->json(['success' => false, 'message' => 'Validation Failed', 'validation' => $errors]);
  }
  
  if(strlen(trim($request->mobile_no)) > 10){
    $mobnum=trim($request->mobile_no);
    //$mobnum=substr(trim($id), 2, 10); 
  }
  else{
    $mobnum="91".trim($request->mobile_no);
    //$mobnum=substr_replace("91",trim($id),2);
  }
  
  $from = date($request->start_datetime);
  $to = date($request->end_datetime);
  //echo ($from.';'. $to);
  $data =medcheckecgdata::where('mobile_no',$mobnum)
                        ->whereBetween('device_reading_time', [$from, $to])
                        ->get();
 
  $datacount = $data->count();
  //echo 'datacount: '.$datacount;
  if($datacount > 0)
  {  
    return response()->json(['success' => true, 'message' =>'Records Found.','data'=>$data]);
  }
  else
  {  
    return response()->json(['success' => false, 'message' =>'No Record(s) Found.']);
  }

}


public function getusertemparaturedata(Request $request){
  //return response()->json($request->all());
  $validator = Validator::make($request->all(), [
  'mobile_no' => 'required|numeric',
  'start_datetime' => 'required',
  'end_datetime' => 'required'
  ]);
  
  if($validator->fails()){
  $errors = collect($validator->messages())->flatten()->toArray();
  return response()->json(['success' => false, 'message' => 'Validation Failed', 'validation' => $errors]);
  }
  
  if(strlen(trim($request->mobile_no)) > 10){
    $mobnum=trim($request->mobile_no);
    //$mobnum=substr(trim($id), 2, 10); 
  }
  else{
    $mobnum="91".trim($request->mobile_no);
    //$mobnum=substr_replace("91",trim($id),2);
  }
  
  $from = date($request->start_datetime);
  $to = date($request->end_datetime);
  //echo ($from.';'. $to);
  $data =medchecktemparature::where('mobile_no',$mobnum)
                        ->whereBetween('device_reading_time', [$from, $to])
                        ->get();
 
  $datacount = $data->count();
  //echo 'datacount: '.$datacount;
  if($datacount > 0)
  {  
    return response()->json(['success' => true, 'message' =>'Records Found.','data'=>$data]);
  }
  else
  {  
    return response()->json(['success' => false, 'message' =>'No Record(s) Found.']);
  }

}

public function getusersdata($id)
{
  if(strlen(trim($id)) > 10){
    $mobnum=trim($id);
    //$mobnum=substr(trim($id), 2, 10); 
  }
  else{
    $mobnum="91".trim($id);
    //$mobnum=substr_replace("91",trim($id),2);
  }
  
  //return $mobnum;
  
  $data =medcheckuserstable::where('mobile_no',$mobnum)->get();

  $datacount = $data->count();
  //echo 'datacount: '.$datacount;
  if($datacount > 0)
  { 
    $data= $data->makeHidden(['password']);
    return response()->json(['success' => true, 'message' =>'Records Found.','data'=>$data]);
  }
  else
  {  
    return response()->json(['success' => false, 'message' =>'Given Mobileno/Emailid does not exists, Please try with different number/id.']);
  }
}

//INSERT MEDCHECK DEVICE READINGS 

public function InsertuserBPdata(Request $request){
//return response()->json($request->all());
$validator = Validator::make($request->all(), [
'systolic' => 'required|numeric',
'diastolic' => 'required|numeric',
'device_reading_time' => 'required',
'mobile_no' => 'required|numeric'
]);

if($validator->fails()){
$errors = collect($validator->messages())->flatten()->toArray();
return response()->json(['success' => false, 'message' => 'Validation Failed', 'validation' => $errors]);
}

if(strlen(trim($request->mobile_no)) > 10){
  $mobnum=trim($request->mobile_no);
  //$mobnum=substr(trim($id), 2, 10); 
}
else{
  $mobnum="91".trim($request->mobile_no);
  //$mobnum=substr_replace("91",trim($id),2);
}

//return $mobnum;
$userid =medcheckuserstable::where('mobile_no', $mobnum)->value('id');


//foreach($response_data['data'] as $v){ 
                
  $device_reading_time= medcheckuser::wheredevice_reading_time($request->device_reading_time)
                                      ->whereuser_id($userid)
                                      ->exists();

if(!$device_reading_time){
//return response()->json(['success' => false, 'message' => 'Mobile Number already Exists']);
//} 
try {

    DB::beginTransaction();
    // Create Patient 
    $patient = new medcheckuser();
    $patient->user_id = $userid;
    $patient->bp = $request->systolic.'/'.$request->diastolic;
    $patient->device_reading_time =$request->device_reading_time;
    $patient->mobile_no=$mobnum;
    $patient->save();
    //commit
    DB::commit();
    
}
catch(\Exception $e){
     
    DB::rollBack();    
    return response()->json(['success' => false, 'message' => $e]);
}
  
}// mobile exist check end
else
{
  return response()->json(['success' => false, 'message' => 'Duplicate device reading time: '.$request->device_reading_time.'/'.$request->systolic.'-'.$request->diastolic.',']);
}

//} //foreach end
return response()->json(['success' => true, 'message' => 'Insert User BP reading Successfully']);


}


public function InsertuserGlucosedata(Request $request){
  //return response()->json($request->all());
  $validator = Validator::make($request->all(), [
  'high_blood' => 'required|numeric',
  'low_blood' => 'nullable',  
  'indicator' => 'required|numeric',
  'reading_type' => 'nullable',
  'device_reading_time' => 'required',
  'mobile_no' => 'required|numeric'
  ]);
  
  if($validator->fails()){
  $errors = collect($validator->messages())->flatten()->toArray();
  return response()->json(['success' => false, 'message' => 'Validation Failed', 'validation' => $errors]);
  }
  
  if(strlen(trim($request->mobile_no)) > 10){
    $mobnum=trim($request->mobile_no);
    //$mobnum=substr(trim($id), 2, 10); 
  }
  else{
    $mobnum="91".trim($request->mobile_no);
    //$mobnum=substr_replace("91",trim($id),2);
  }
  
  //return $mobnum;
  $userid =medcheckuserstable::where('mobile_no', $mobnum)->value('id');
  
  
  //foreach($response_data['data'] as $v){ 
                  
    $device_reading_time= medcheckglucosedata::wheredevice_reading_time($request->device_reading_time)
                                        ->whereuser_id($userid)
                                        ->exists();
  
  if(!$device_reading_time){
  //return response()->json(['success' => false, 'message' => 'Mobile Number already Exists']);
  //} 
  try {
  
      DB::beginTransaction();
      // Create Patient 
      $patient = new medcheckglucosedata();
      $patient->user_id =$userid;
      $patient->high_blood=$request->high_blood;
      $patient->low_blood=$request->low_blood;
      $patient->indicator=$request->indicator; 
      $patient->reading_type=$request->reading_type; 
      $patient->device_reading_time=$request->device_reading_time;
      $patient->mobile_no =$mobnum;
      $patient->save();
      //commit
      DB::commit();
      
  }
  catch(\Exception $e){
       
      DB::rollBack();    
      return response()->json(['success' => false, 'message' => $e]);
  }
    
  }// mobile exist check end
  else
  {
    return response()->json(['success' => false, 'message' => 'Duplicate device reading time: '.$request->device_reading_time.'/'.$request->high_blood.'-'.$request->indicator.',']);
  }
  
  //} //foreach end
  return response()->json(['success' => true, 'message' => 'Insert User Gulcose reading Successfully']);
  
  
  }
  public function InsertuserWeightscaledata(Request $request){
    //return response()->json($request->all());
    $validator = Validator::make($request->all(), [
    'bmi_weight' => 'required',
    'bmi' => 'required',
    'fat_per' => 'required',
    'muscle_per' => 'required',
    'water_per' => 'required',
    'bmr' => 'required',
    'device_reading_time' => 'required',
    'mobile_no' => 'required|numeric'
    ]);
    
    if($validator->fails()){
    $errors = collect($validator->messages())->flatten()->toArray();
    return response()->json(['success' => false, 'message' => 'Validation Failed', 'validation' => $errors]);
    }
    
    if(strlen(trim($request->mobile_no)) > 10){
      $mobnum=trim($request->mobile_no);
      //$mobnum=substr(trim($id), 2, 10); 
    }
    else{
      $mobnum="91".trim($request->mobile_no);
      //$mobnum=substr_replace("91",trim($id),2);
    }
    
    //return $mobnum;
    $userid =medcheckuserstable::where('mobile_no', $mobnum)->value('id');
    
    
    //foreach($response_data['data'] as $v){ 
                    
      $device_reading_time= medcheckweightscale::wheredevice_reading_time($request->device_reading_time)
                                          ->whereuser_id($userid)
                                          ->exists();
    
    if(!$device_reading_time){
    //return response()->json(['success' => false, 'message' => 'Mobile Number already Exists']);
    //} 
    try {
    
        DB::beginTransaction();
        // Create Patient 
        $patient = new medcheckweightscale();
        $patient->user_id = $userid;
        $patient->bmi_weight=$request->bmi_weight;
        $patient->bmi=$request->bmi; 
        $patient->fat_per=$request->fat_per;
        $patient->muscle_per=$request->muscle_per;
        $patient->water_per=$request->water_per;
        $patient->bmr=$request->bmr;
        $patient->device_reading_time=$request->device_reading_time;
        $patient->mobile_no=$mobnum;
        $patient->save();

        // BMI & Weight Update in Patient Profile
        $patient = Auth::user();      
        if ($patient->patientProfile()->first()) {
          $patient->patientProfile->bmi = $request->bmi; 
          $patient->patientProfile->weight_kg = $request->bmi_weight;
          $patient->patientProfile->save(); 
          //$data = $patient->patientProfile()->first()->toArray(); 
        }
        
        //commit
        DB::commit();
        
    }
    catch(\Exception $e){
         
        DB::rollBack();    
        return response()->json(['success' => false, 'message' => $e]);
    }
      
    }// mobile exist check end
    else
    {
      return response()->json(['success' => false, 'message' => 'Duplicate device reading time: '.$request->device_reading_time.'/'.$request->bmi_weight.',']);
    }
    
    //} //foreach end
    return response()->json(['success' => true, 'message' => 'Insert User Weightscale reading Successfully']);
    
    
    }

    public function InsertuserSPO2(Request $request){
      //return response()->json($request->all());
      $validator = Validator::make($request->all(), [
      'spo2_value' => 'required',
      'pr' => 'required',
      'pi' => 'required',
      'spo2_result' => 'nullable',
      'device_reading_time' => 'required',
      'mobile_no' => 'required|numeric'
      ]);
      
      if($validator->fails()){
      $errors = collect($validator->messages())->flatten()->toArray();
      return response()->json(['success' => false, 'message' => 'Validation Failed', 'validation' => $errors]);
      }
      
      if(strlen(trim($request->mobile_no)) > 10){
        $mobnum=trim($request->mobile_no);
        //$mobnum=substr(trim($id), 2, 10); 
      }
      else{
        $mobnum="91".trim($request->mobile_no);
        //$mobnum=substr_replace("91",trim($id),2);
      }
      
      //return $mobnum;
      $userid =medcheckuserstable::where('mobile_no', $mobnum)->value('id');
      
      
      //foreach($response_data['data'] as $v){ 
                      
        $device_reading_time= medcheckspo2::wheredevice_reading_time($request->device_reading_time)
                                            ->whereuser_id($userid)
                                            ->exists();
      
      if(!$device_reading_time){
      //return response()->json(['success' => false, 'message' => 'Mobile Number already Exists']);
      //} 
      try {
      
          DB::beginTransaction();
          // Create Patient 
          $patient = new medcheckspo2();
          $patient->user_id =$userid;
          $patient->spo2_value =$request->spo2_value;
          $patient->pr =$request->pr; 
          $patient->pi =$request->pi;
          $patient->spo2_result =$request->spo2_result;
          $patient->device_reading_time =$request->device_reading_time;
          $patient->mobile_no=$mobnum;
          $patient->save();
          //commit
          DB::commit();
          
      }
      catch(\Exception $e){
           
          DB::rollBack();    
          return response()->json(['success' => false, 'message' => $e]);
      }
        
      }// mobile exist check end
      else
      {
        return response()->json(['success' => false, 'message' => 'Duplicate device reading time: '.$request->device_reading_time.'/'.$request->spo2_value.',']);
      }
      
      //} //foreach end
      return response()->json(['success' => true, 'message' => 'Insert User SPO2 reading Successfully']);
      
      
      }
      public function InsertuserECGdata(Request $request){
        //return response()->json($request->all());
        $validator = Validator::make($request->all(), [
        'hr' => 'required',
        'qrs' => 'required',
        'qt' => 'required',
        'qtc' => 'required',
        'ecg_result' => 'nullable',
        'arr_ecg_content' => 'nullable',
		    'arr_ecg_heartrate' => 'nullable',
        'device_reading_time' => 'required',
        'mobile_no' => 'required|numeric'
        ]);
        
        if($validator->fails()){
        $errors = collect($validator->messages())->flatten()->toArray();
        return response()->json(['success' => false, 'message' => 'Validation Failed', 'validation' => $errors]);
        }
        
        if(strlen(trim($request->mobile_no)) > 10){
          $mobnum=trim($request->mobile_no);
          //$mobnum=substr(trim($id), 2, 10); 
        }
        else{
          $mobnum="91".trim($request->mobile_no);
          //$mobnum=substr_replace("91",trim($id),2);
        }
        
        //return $mobnum;
        $userid =medcheckuserstable::where('mobile_no', $mobnum)->value('id');
        
        
        //foreach($response_data['data'] as $v){ 
                        
          $device_reading_time= medcheckecgdata::wheredevice_reading_time($request->device_reading_time)
                                              ->whereuser_id($userid)
                                              ->exists();
        
        if(!$device_reading_time){
        //return response()->json(['success' => false, 'message' => 'Mobile Number already Exists']);
        //} 
        try {
        
            DB::beginTransaction();
            // Create Patient 
            $patient = new medcheckecgdata();
            $patient->user_id = $userid;
            $patient->hr =$request->hr;
            $patient->qrs =$request->qrs; 
            $patient->qt =$request->qt;
            $patient->qtc =$request->qtc;
            $patient->ecg_result =$request->ecg_result;
            $patient->arr_ecg_content =$request->arr_ecg_content;
            $patient->arr_ecg_heartrate =$request->arr_ecg_heartrate;
            $patient->device_reading_time=$request->device_reading_time;
            $patient->mobile_no=$mobnum;
            $patient->save();
            //commit
            DB::commit();
            
        }
        catch(\Exception $e){
             
            DB::rollBack();    
            return response()->json(['success' => false, 'message' => $e]);
        }
          
        }// mobile exist check end
        else
        {
          return response()->json(['success' => false, 'message' => 'Duplicate device reading time: '.$request->device_reading_time.'/'.$request->hr.',']);
        }
        
        //} //foreach end
        return response()->json(['success' => true, 'message' => 'Insert User ECG reading Successfully']);
        
        
        }

        public function InsertuserTemparaturedata(Request $request){
          //return response()->json($request->all());
          $validator = Validator::make($request->all(), [
          'ptt_value' => 'required',
          'measure_mode' => 'required',
          'device_reading_time' => 'required',
          'mobile_no' => 'required|numeric'
          ]);
          
          if($validator->fails()){
          $errors = collect($validator->messages())->flatten()->toArray();
          return response()->json(['success' => false, 'message' => 'Validation Failed', 'validation' => $errors]);
          }
          
          if(strlen(trim($request->mobile_no)) > 10){
            $mobnum=trim($request->mobile_no);
            //$mobnum=substr(trim($id), 2, 10); 
          }
          else{
            $mobnum="91".trim($request->mobile_no);
            //$mobnum=substr_replace("91",trim($id),2);
          }
          
          //return $mobnum;
          $userid =medcheckuserstable::where('mobile_no', $mobnum)->value('id');
          
          
          //foreach($response_data['data'] as $v){ 
                          
            $device_reading_time= medchecktemparature::wheredevice_reading_time($request->device_reading_time)
                                                ->whereuser_id($userid)
                                                ->exists();
          
          if(!$device_reading_time){
          //return response()->json(['success' => false, 'message' => 'Mobile Number already Exists']);
          //} 
          try {
          
              DB::beginTransaction();
              // Create Patient 
              $patient = new medchecktemparature();
              $patient->user_id = $userid;
              $patient->ptt_value=$request->ptt_value;
              $patient->measure_mode=$request->measure_mode; 
              $patient->device_reading_time=$request->device_reading_time;
              $patient->mobile_no=$mobnum;
              $patient->save();
              //commit
              DB::commit();
              
          }
          catch(\Exception $e){
               
              DB::rollBack();    
              return response()->json(['success' => false, 'message' => $e]);
          }
            
          }// mobile exist check end
          else
          {
            return response()->json(['success' => false, 'message' => 'Duplicate device reading time: '.$request->device_reading_time.'/'.$request->ptt_value.',']);
          }
          
          //} //foreach end
          return response()->json(['success' => true, 'message' => 'Insert User Body Temparature reading Successfully']);
          
          
          }

}

