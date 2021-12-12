<?php

namespace App\Http\Controllers;

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

class AppAuthController extends Controller
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

	public function authenticate(Request $request){
		try {
			$username = $request->username;
			$password = $request->password;

			$user_type = UserRole::where('user_role', 'admin')->first();

			$check_user = User::where('email', $username)
								->orWhere('mobile_no', $username)
								->where('user_role', '!=', $user_type->id)
								->first();

			if ($check_user != NULL) {
				$credentials = array(
				'name' => $check_user->name,
						'email' => $check_user->email,
						'password' => $password
					);
			}
			else{
				return response()->json(['success' => false, 'error' => 'invalid_credentials', 'message' => 'Incorrect Mobile Number/Password'], 403);
			}

			if ($check_user->active != 1) {
				return response()->json(['success' => false, 'error' => 'invalid_credentials', 'message' => 'Your account is not yet approved'], 403);
			}

			// attempt to verify the credentials and create a token for the user
			if (! $token = JWTAuth::attempt($credentials)) {
				return response()->json(['success' => false, 'error' => 'invalid_credentials', 'message' => 'Incorrect Mobile Number/Password'], 403);
			}
		} catch (JWTException $e) {
			// something went wrong whilst attempting to encode the token
			return response()->json(['success' => false, 'error' => 'could_not_create_token', 'message' => 'Something went wrong. Please try again'], 500);
		}

		// all good so return the token
		// return response()->json(array('success' => true, 'data' => array('token' => $token));
		return response()->json(compact('token'));
	}

	public function googleLogin(Request $request)
	{
		$googleAuthCode = $request->googleAuthCode;
		$accessTokenResponse= Socialite::driver('google')->getAccessTokenResponse($googleAuthCode);
		$accessToken=$accessTokenResponse["access_token"];
		$expiresIn=$accessTokenResponse["expires_in"];
		$idToken=$accessTokenResponse["id_token"];
		$refreshToken=isset($accessTokenResponse["refresh_token"])?$accessTokenResponse["refresh_token"]:"";
		$tokenType=$accessTokenResponse["token_type"];
		return Socialite::driver('google')->userFromToken($accessToken);

	}

	function generateRandomString($length){
		$characters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$charsLength = strlen($characters) -1;
		$string = "";
		for($i=0; $i<$length; $i++){
			$randNum = mt_rand(0, $charsLength);
			$string .= $characters[$randNum];
		}
		return $string;
	}

	public function findOrCreateUser($request)
    {
        $authUser = User::where('provider_id', $request->provider_id)->where('provider', $request->provider)->first();
        if ($authUser) {
            return $authUser;
		}

		$shedoctrid = Config::get('sheDoctr.db.patientPrefix');
		$shedoctrid_length = Config::get('sheDoctr.db.numberLength');
		$userType = UserRole::where('user_role', $request->user_type)->first();
		$max_user_count = User::where('user_role', $userType->id)->max('id');
		$max_user_count++;
		$user_id = str_pad($max_user_count, $shedoctrid_length, "0", STR_PAD_LEFT);
		$shedoctrid .= $user_id;
		$mobileNo = $randnum = rand(1111111111,9999999999);
		$email = $this->generateRandomString(10) . '@c2p.com';

        return User::create([
            'name'     => $request->name,
            'email'    => !empty($request->email) ? $request->email : $email,
            'provider' => $request->provider,
			'provider_id' => $request->provider_id,
			'user_role' => $userType->id,
			'shdct_user_id' => $shedoctrid,
			'active' => 1,
			'mobile_no' => !empty($request->mobile_no) ? $request->mobile_no : $mobileNo
        ]);
	}

	public function facebookLogin($request)
	{
		$authUser = $this->findOrCreateUser($request);
		try {
			if (! $token = JWTAuth::fromUser($authUser)) {
				return response()->json(['success' => false, 'error' => 'invalid_credentials', 'message' => 'Incorrect Mobile Number/Password'], 200);
			}
			return response()->json(array('success' => true, 'data' => array('token' => $token, 'user' => $authUser, 'showProfile' => $authUser->showProfilePageOrNot())));

		} catch(JWTException $e) {
			return response()->json(['success' => false, 'error' => 'could_not_create_token', 'message' => 'Something went wrong. Please try again'], 500);
		}

	}

	public function applogin(Request $request){
		 
		if ($request->provider == 'facebook' && !empty($request->provider_id)) {
			return $this->facebookLogin($request);
		}

		try {
			$username = $request->username;
			$password = $request->password;

			$user_type = UserRole::where('user_role', 'admin')->first();

			$check_user = User::where('email', $username)
								->orWhere('mobile_no', $username)
								->where('user_role', '!=', $user_type->id)
								->first();

			if ($check_user != NULL) {
				$credentials = array(
						'email' => $check_user->email,
						'password' => $password
					);
			}
			else{
				return response()->json(['success' => false, 'error' => 'invalid_credentials', 'message' => 'Incorrect Mobile Number/Password'], 200);
			}

			if ($check_user->active != 1) {
				return response()->json(['success' => false, 'error' => 'invalid_credentials', 'message' => 'Your account is not yet approved'], 200);
			}

			// attempt to verify the credentials and create a token for the user
			if (! $token = JWTAuth::attempt($credentials)) {
				return response()->json(['success' => false, 'error' => 'invalid_credentials', 'message' => 'Incorrect Mobile Number/Password'], 200);
			}
		} catch (JWTException $e) {
			// something went wrong whilst attempting to encode the token
			return response()->json(['success' => false, 'error' => 'could_not_create_token', 'message' => 'Something went wrong. Please try again'], 500);
		}

		// Here we have to check if mandatory profile fields are filled or not
		$patient = Auth::user();
		// all good so return the token
		return response()->json(array('success' => true, 'data' => array('token' => $token, 'user' => $check_user, 'showProfile' => $patient->showProfilePageOrNot())));
	}

	public function register(Request $request){

		$validator = Validator::make($request->all(), [
			'name' => 'required|max:255',
			'email' => 'required|email|max:255',
			'mobile_no' => 'required',
			'country_code' => 'required|numeric',
			'organisation_id' => 'required|exists:users,id',
			'password' => 'required'
		]);

		if($validator->fails()){
			$errors = collect($validator->messages())->flatten()->toArray();
			return response()->json(['success' => false, 'message' => 'Validation Failed', 'validation' => $errors]);
		}

		// Check Whether Patient Mobile or Email Exists or Not.
		$email_exists = User::whereEmail($request->email)
							->whereUserRole(4)
							->exists();

		$mobile_exists = User::whereMobileNo($request->country_code.$request->mobile_no)
							->whereUserRole(4)
							->exists();

		if($email_exists){
			return response()->json(['success' => false, 'message' => 'Email already Exists']);
		}

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
			$patient->referred_by = !empty($request->referred_by) ? $request->referred_by : NULL;
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
			return response()->json(['success' => false, 'message' => 'Something Went Wrong-'.$e]);
		}
	}

	//MEDCHECK DATA Db2DbSync
	public function registermedcheckuserOLD(Request $request){

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
		//					->whereUserRole(4)
		//					->exists();

		$mobile_exists = User::whereMobileNo($request->country_code.$request->mobile_no)
							->whereUserRole(4)
							->exists();

		//if($email_exists){
		//	return response()->json(['success' => false, 'message' => 'Email already Exists']);
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

	// Send Otp
	public function send_otp(Request $request){
		$validator = Validator::make($request->all(), [
			'mobile_no' => 'required|exists:users,mobile_no'
		]);
         
		if($validator->fails()){
			$errors = collect($validator->messages())->flatten()->toArray();
			return response()->json(['success' => false,'message' => $errors[0]]);
		}

		//Send Sms for User Mobile Verification
		$verification_code = mt_rand(1000, 9999);
		$msgtxt = '<#> C2P: Your Cover2Protect verification code is '.$verification_code.' SRwtvi7PLLR';

		$msgData = array(
			'recipient_no' => $request->mobile_no,
			'msgtxt' => $msgtxt
		);

		$sendsms = Helper::sendSMS($msgData);
		$sendemail = Helper::sendMail($request->mobile_no,$verification_code);

		if($sendsms){
			return response()->json(['success' => true, 'message' => 'Otp Sent Successfully', 'otp' => $verification_code]);	
		}
		return response()->json(['status' => false, 'message' => 'Something went wrong']);
	}

	// To Verify User Mobile Number
	public function mobileVerification(Request $request){
		$validator = Validator::make($request->all(), [
			'id' => 'required|exists:users,id',
			'mobile_no' => 'required|exists:users,mobile_no'
		]);

		if($validator->fails()){
			$errors = collect($validator->messages())->flatten()->toArray();
			return response()->json(['success' => false, 'message' => 'Validation Failed', 'data' => $errors]);
		}

		$user = User::where('id', $request->id)
					->whereMobileNo($request->mobile_no)
					->first();

		if($user){
			$user->mobile_verified = 1;
			$user->save();
			return response()->json(['success' => true, 'message' => 'Patient Mobile Number Successfully Verified', 'data' => $user]);
		}
		return response()->json(['success' => false, 'message' => 'Failed to Verified']);
	}

	public function activateAccount(Request $request, $token){
		$app_link = Config::get('sheDoctr.webapp.url');

		// Compare verification code
		$code = VerificationCodes::where('code', $token)
			->first();

		if (!$code) {
			$msg = 'Invalid Activation Link';
			return view('app.auth.accountStatus')
					->with('status', 'invalid');
			// return redirect($app_link.'?account_activated=0&message='.$msg);
		}

		$user = User::where('email', $code->sent_to)->first();

		if (!$user) {
			$msg = 'Invalid Activation Link';
			return view('app.auth.accountStatus')
					->with('status', 'invalid');
			// return redirect($app_link.'?account_activated=0&message='.$msg);
		}

		// Check if code is still valid
		if ($code->created_at->addSeconds(60*60)->isPast()) {
			$code->delete();

			// Create and Send new token
			$token = str_random(30);
			$verification_code = VerificationCodes::sendActivationMail($user, $token);
			$msg = 'Activation Link Expired. We have sent a new link';
			return view('app.auth.accountStatus')
					->with('status', 'expired');
			// return redirect($app_link.'?account_activated=0&message='.$msg);
		}

		// Set account active
		$user->active = 1;
		$user->save();

		$code->delete();

		// Add Notification for Admin
		$user_type = UserRole::where('id', $user->user_role)->first();

		if ($user_type->user_role == 'doctor') {
			$notification = array(
				'type' => 'NewUser',
				'subject' => 'New Doctor Registration',
				'body' => 'New doctor registered and is pending approval',
				'email' => 'emails.newdoctor'
			);
		}
		else {
			$notification = array(
				'type' => 'NewUser',
				'subject' => 'New Patient Registration',
				'body' => 'New Patient registered',
				'email' => 'emails.newuser'
			);
		}

		if ($user_type->user_role != 'doctor') {
			$admin_user = UserRole::where('user_role', 'admin')->value('id');
			// Add Notification
			$admin_users = User::where('user_role', $admin_user)->get();
			foreach ($admin_users as $u) {
				$u->newNotification()
					->withType($notification['type'])
					->withSubject($notification['subject'])
					->withBody($notification['body'])
					->regarding($user)
					->deliver();

				// Send Mail
				$sendemail = Mail::send($notification['email'], array(), function ($message) use ($u)
				{
					$message->to($u->email, $u->name);
					$message->cc('appt@shedoctr.com', 'Admin');
					$message->subject('SheDoctr - New User Registration');
				});
			}
		}

		// Send Activation Confirmation Mail
		/*if ($user_type->user_role == 'doctor') {
			$sendemail = Mail::send('emails.welcomedoctor', array(), function ($message) use ($data)
			{
				$message->to($data['email'], $data['name']);
				$message->subject('Welcome To SheDoctr');
			});
		}
		else{
			$sendemail = Mail::send('emails.welcomeuser', array(), function ($message) use ($data)
			{
				$message->to($data['email'], $data['name']);
				$message->subject('Welcome To SheDoctr');
			});
		}

		// Send SMS
		$msgtxt = "Your account has been activated. You can now login to your account.";

		$msgData = array(
			'recipient_no' => $user->mobile_no,
			'msgtxt' => $msgtxt
		);

		$sendsms = Helper::sendSMS($msgData);*/

		$msg = 'Account activated. Please login';
		return view('app.auth.accountStatus')
					->with('status', 'success');
		// return redirect($app_link.'?account_activated=1&message='.$msg);
	}

	public function getAuthenticatedUser(){
		try {
			if (! $user = JWTAuth::parseToken()->authenticate()) {
				return response()->json(['user_not_found'], 404);
			}
		}
		catch (TokenExpiredException $e) {
			return response()->json(['token_expired'], 500);
		}
		catch (TokenInvalidException $e) {
			return response()->json(['token_invalid'], 500);
		}
		catch (JWTException $e) {
			return response()->json(['token_absent'], 500);
		}
		catch (Exception $e) {
			return response()->json(['server_error'], 500);
		}

		$return_array = array(
			'user' => array(
				'name' => $user->name,
				'email' => $user->email,
				'mobile' => $user->mobile_no,
				'profile_image' => URL::to('/').$user->profile_image,
				'role' => $user->userRole->user_role
			)
		);

		// the token is valid and we have found the user via the sub claim
		return response()->json($return_array);
	}

	// public function forgotPassword(Request $request){
	// 	try{

	// 	$validator = Validator::make($request->all(),[
	// 			'mobile_no' => 'required|users:exists,mob'
	// 		]);

	// 		if ($validator->fails()) {
	// 			return response()->json(array('success' => false, 'error' => 'validation_error', 'message' => "Something went wrong.<br />Please try again"));
	// 		}


	// 		if ($request->has('username')) {
	// 			$username = $request->countryCode.$request->username;

	// 			$user = User::where('email', $username)
	// 							->orWhere('mobile_no', $username)
	// 							->first();

	// 			if ($user != NULL && $user->active == 1) {
	// 				$reset_code = mt_rand(1000, 9999);

	// 				PasswordResetCodes::where('user_id', $user->id)->delete();

	// 				$password_reset_code = new PasswordResetCodes;
	// 				$password_reset_code->user_id = $user->id;
	// 				$password_reset_code->code = $reset_code;
	// 				$password_reset_code->save();

	// 				// Add Code to send email and sms
	// 				$send_notifications = $this->sendPasswordResetMail($user, $reset_code);

	// 				if (!$send_notifications) {
	// 					throw new Exception('Could not send notification');
	// 				}

	// 				return response()->json(array('success' => true, 'message' => "Reset code has been sent to your Email/Mobile No."));
	// 			}
	// 			else{
	// 				return response()->json(['success' => false, 'error' => 'invalid_credentials', 'message' => 'Please enter valid Mobile Number']);
	// 			}
	// 		}
	// 		else{
	// 			return response()->json(array('success' => false, 'error' => 'validation_error', 'message' => "Something went wrong.<br />Please try again"));
	// 		}
	// 	}
	// 	catch(Exception $e){
	// 		return response()->json(array('success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"));
	// 	}
	// }

	// public function resendResetCode(Request $request){
	// 	try{

	// 	$validator = Validator::make($request->all(),[
	// 			'username' => 'required',
	// 			'countryCode' => 'required',
	// 		]);

	// 		if ($validator->fails()) {
	// 			return response()->json(array('success' => false, 'error' => 'validation_error', 'message' => "Something went wrong.<br />Please try again"));
	// 		}

	// 		if ($request->has('username')) {
	// 			$username = $request->countryCode.$request->username;

	// 			$user = User::where('email', $username)
	// 							->orWhere('mobile_no', $username)
	// 							->first();

	// 			if ($user != NULL && $user->active == 1) {
	// 				$reset_code = PasswordResetCodes::where('user_id', $user->id)->value('code');

	// 				// Add Code to send email and sms
	// 				$send_notifications = $this->sendPasswordResetMail($user, $reset_code);

	// 				if (!$send_notifications) {
	// 					throw new Exception('Could not send notification');
	// 				}

	// 				return response()->json(array('success' => true, 'message' => "Reset code has been sent to your Email/Mobile No."));
	// 			}
	// 			else{
	// 				return response()->json(['success' => false, 'error' => 'invalid_credentials', 'message' => 'Username not found']);
	// 			}
	// 		}
	// 		else{
	// 			return response()->json(array('success' => false, 'error' => 'validation_error', 'message' => "Something went wrong.<br />Please try again"));
	// 		}
	// 	}
	// 	catch(Exception $e){
	// 		return response()->json(array('success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"));
	// 	}
	// }

	public function resetPassword(Request $request){
		try{
			$validator = Validator::make($request->all(),[
				'mobile_no' => 'required|exists:users,mobile_no',
				'password' => 'required',
			]);

			if ($validator->fails()){
				$errors = collect($validator->messages())->flatten()->toArray();
				return response()->json(['success' => false, 'message' => 'Validation Failed', 'data' => $errors]);
			}

			$user = User::where('mobile_no', $request->mobile_no)
						->first();
								
			if ($user != Null && $user->active == 1) {
				$user->password = bcrypt($request->password);
				$user->save();
				return response()->json(array('success' => true, 'message' => 'Password Reset Successfully.<br />Please Login', 'email' => $user->email));
			}
			else{
				return response()->json(['success' => false, 'error' => 'invalid_credentials', 'message' => 'Invalid Reset Code']);
			}
		}
		catch(Exception $e){
			return response()->json(array('success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"));
		}
	}

	private function sendPasswordResetMail($user, $reset_code){

		try{

			$data = array(
				'name' => $user->name,
				'email' => $user->email,
				'mobile_no' => $user->mobile_no,
				'reset_code' => $reset_code,
				'expiry' => Config::get('sheDoctr.webapp.code_expiry')
			);

			// Send Email
			$sendemail = Mail::send('emails.passwordreset', array('data' => $data), function ($message) use ($data)
			{
				$message->to($data['email'], $data['name']);
				$message->cc('appt@shedoctr.com', 'Admin');
				$message->subject('SheDoctr Reset Password');
			});

			// Send SMS
			// $msgtxt = "Your MyAIBud Password Reset Code is : ".$reset_code;
			$msgtxt = '<#> C2P: Your verification code is '.$reset_code.' SRwtvi7PLLR';

			$msgData = array(
				'recipient_no' => $data['mobile_no'],
				'msgtxt' => $msgtxt
			);

			$sendsms = Helper::sendSMS($msgData);

			return true;

		}
		catch(Exception $e){
			return false;
		}
	}

	public function sendOtp(Request $request){
        $otp_code = mt_rand(100000, 999999);
			try{
				$validator = Validator::make($request->all(),[
				'user_type' => 'required',
				'name'      => 'required',
				'email'     => 'required',
				'mobileno'  => 'required',
				'pass'      => 'required',
				'countryCode' => 'required'

			]);

			if ($validator->fails()) {
				return response()->json(array('success' => false, 'error' => 'validation_error', 'message' => "Something went wrong.<br />Please try again"));
			}

			$data = array(
				'user_type' => $request->user_type,
				'name'      => $request->name,
				'email'     => $request->email,
				'mobileno'  => $request->mobileno,
				'password'  => $request->pass,
				'countrycode'  => $request->countryCode,
				'mobile'  => $request->countryCode.$request->mobileno,
			);

			$referred_by = NULL;

			if ($request->has('referral_code')) {
				$referral_code = $request->referral_code;

				$referrer = UserReferralCode::where('referral_code', $referral_code)->first();
				if (!$referrer) {
					return response()->json(['success' => false, 'error' => 'validation_error', 'message' => 'Invalid Referral Code']);
				}

				$referred_by = $referrer->user_id;
			}

			// Check if username or mobileno already exists
			$email_exists = User::where('email', $data['email'])->count();
			$mobile_no_exists = User::where('mobile_no', $data['mobile'])->count();
			$user_type = UserRole::where('user_role', $data['user_type'])->first();

			if ($email_exists > 0 && $mobile_no_exists > 0) {
				return response()->json(array('success' => false, 'error' => 'validation_error', 'message' => "Email ID and mobile no already exists.<br />Please enter a different mail address and mobile no"));
			}
			else{
				if ($email_exists > 0) {
					return response()->json(array('success' => false, 'error' => 'validation_error', 'message' => "Email ID already exists.<br />Please enter a different mail address"));
				}
				if ($mobile_no_exists > 0) {
					return response()->json(array('success' => false, 'error' => 'validation_error', 'message' => "Mobile Number already exists.<br />Please enter a different mobile number"));
				}
			}

			if (!$user_type) {

				return response()->json(array('success' => false, 'error' => 'validation_error', 'message' => "Something went wrong.<br />Please try again"));
			}


			// Send Email
		/*	$sendemail = Mail::send('emails.passwordreset', array('data' => $data), function ($message) use ($data)
			{
				$message->to($data['email'], $data['name']);
				$message->subject('SheDoctr Reset Password');
			});*/

			// Send SMS


			$msgtxt = "Thank you for registering with SheDoctr.com. Please enter the OTP : ".$otp_code." to finish the registration process.";

			$msgData = array(
				'recipient_no' => $request->countryCode.$data['mobileno'],
				'msgtxt' => $msgtxt
			);

	       $sendsms = Helper::sendSMS($msgData);

		return response()->json(array('success' => true,'otp' =>$otp_code,  'message' => "Otp Sent Successfully!"));

		}
		catch(Exception $e){
			return response()->json(array('success' => false, 'error' => 'validation_error', 'message' => "Something went wrong.<br />Please try again"));
		}
	}
}
