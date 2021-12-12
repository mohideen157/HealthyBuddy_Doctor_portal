<?php

namespace Myaibud\Controllers;

use App\Helpers\Helper;
use App\Http\Requests;
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
use Illuminate\Http\Request;
use JWTAuth;
use Mail;
use Socialite;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use URL;
use Validator;

class MedcheckUserRegController extends \App\Http\Controllers\Controller
{
    
    public function registermedcheck(Request $request, $id)
   {
      //$sp=DocSpecialization::pluck('specialization','id');        
      return view('registermedcheck',['phone' => $id]);
   }
   public function registermedchecksuccess(Request $request)
   {     
      return view('registermedchecksuccess');
   }

    //MEDCHECK USER REGISTER
	public function registermedcheckuser(Request $request){
        //echo 'registermedcheckuser-start-'.str_replace('+', '', $request['country_code']).$request['mobile_number'];
        $validator = Validator::make($request->all(), [
			'name' => 'required|max:255',
			'email' => 'required|email|max:255',
			'mobile_no' => 'required',
			'password' => 'required'
		]);

		if($validator->fails()){
			$errors = collect($validator->messages())->flatten()->toArray();
            return redirect()->back()->withErrors([$errors]);
		}

		// Check Whether Patient Mobile or Email Exists or Not.
		$email_exists = User::whereEmail($request->email)
							->whereUserRole(4)
							->exists();

		$mobile_exists = User::whereMobileNo('91'.$request->mobile_no)
							->whereUserRole(4)
							->exists();

		if($email_exists){
            return redirect()->back()->withErrors(['Email already Exists!']);
		}

		if($mobile_exists){
            return redirect()->back()->withErrors(['Mobile Number already Exists!']);
		}

		try{

			DB::beginTransaction();
			// Create Patient 
			$patient = new User();
			$patient->user_role = 4;
			$patient->name = $request->name;
			$patient->email = $request->email;
			$patient->mobile_no = '91'.$request->mobile_no;
			$patient->organisation_id = '4';
			$patient->password = bcrypt($request->password);
			$patient->save();

			$patient->shdct_user_id = Config::get('sheDoctr.db.patientPrefix').$patient->id;
			$patient->save();

			//Send Sms for User Mobile Verification
			//$verification_code = mt_rand(1000, 9999);
			$msgtxt = 'Dear '.$patient->name.', Registration done successfully.Thank you for being registered in Cover2Protect.';
            //$msgtxt = 'Dear '.$patient->name.', Thank you for being with Cover2Protect. Kindly complete your registration by clicking the below link. http://127.0.0.1:8000/registermedcheck/'.$request->mobile_no;
			$msgData = array(
				'recipient_no' => '9884808644',//$request->mobile_no,
				'msgtxt' => $msgtxt
			);
			$sendsms = Helper::sendSMS($msgData);
			//$sendemail = Helper::sendMail($patient->mobile_no,$verification_code);
			DB::commit();

			return redirect('registermedchecksuccess');
		}
		catch(\Exception $e){
			 
			DB::rollBack();
            return redirect()->back()->withErrors(['Sorry, something went wrong!']);
		}
    }
    
    
}