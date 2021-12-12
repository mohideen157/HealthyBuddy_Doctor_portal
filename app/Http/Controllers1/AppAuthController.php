<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Hash;
use URL;
use Validator;
use Carbon\Carbon;
use DB;
use Config;
use Mail;
use Exception;

use App\User;
use App\Model\UserRole;
use App\Model\Doctor\DoctorProfile;
use App\Model\PasswordResetCodes;
use App\Model\VerificationCodes;
use App\Model\User\CancelRescheduleCount;
use App\Model\User\UserReferralCode;
use App\Model\Patient\PatientCredits;
use App\Model\Patient\PatientCreditLogs;

use App\Model\Notification;

use App\Helpers\Helper;

use App\Model\AdminSettings;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

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
						'email' => $check_user->email,
						'password' => $password
					);
			}
			else{
				return response()->json(['success' => false, 'error' => 'invalid_credentials', 'message' => 'Incorrect Username/Password'], 403);				
			}

			if ($check_user->active != 1) {
				return response()->json(['success' => false, 'error' => 'invalid_credentials', 'message' => 'Your account is not yet approved'], 403);
			}

			// attempt to verify the credentials and create a token for the user
			if (! $token = JWTAuth::attempt($credentials)) {
				return response()->json(['success' => false, 'error' => 'invalid_credentials', 'message' => 'Incorrect Username/Password'], 403);
			}
		} catch (JWTException $e) {
			// something went wrong whilst attempting to encode the token
			return response()->json(['success' => false, 'error' => 'could_not_create_token', 'message' => 'Something went wrong. Please try again'], 500);
		}

		// all good so return the token
		// return response()->json(array('success' => true, 'data' => array('token' => $token));
		return response()->json(compact('token'));
	}

	public function applogin(Request $request){
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
				return response()->json(['success' => false, 'error' => 'invalid_credentials', 'message' => 'Incorrect Username/Password'], 403);				
			}

			if ($check_user->active != 1) {
				return response()->json(['success' => false, 'error' => 'invalid_credentials', 'message' => 'Your account is not yet approved'], 403);
			}

			// attempt to verify the credentials and create a token for the user
			if (! $token = JWTAuth::attempt($credentials)) {
				return response()->json(['success' => false, 'error' => 'invalid_credentials', 'message' => 'Incorrect Username/Password'], 403);
			}
		} catch (JWTException $e) {
			// something went wrong whilst attempting to encode the token
			return response()->json(['success' => false, 'error' => 'could_not_create_token', 'message' => 'Something went wrong. Please try again'], 500);
		}

		// all good so return the token
		return response()->json(array('success' => true, 'data' => array('token' => $token)));
	}

	public function register(Request $request){

		try{

			$validator = Validator::make($request->all(),[
				'user_type' => 'required',
				'name'      => 'required',
				'email'     => 'required',
				'mobileno'  => 'required',
				'pass'      => 'required',
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
			$mobile_no_exists = User::where('mobile_no', $data['mobileno'])->count();
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

			$shedoctrid = '';
			$shedoctrid_length = Config::get('sheDoctr.db.numberLength');

			if ($user_type->user_role == 'doctor') {
				$shedoctrid = Config::get('sheDoctr.db.doctorPrefix');

				if (!$request->has('medical_registration_no')) {
					return response()->json(array('success' => false, 'error' => 'validation_error', 'message' => "Something went wrong.<br />Please try again"));
				}

				/*$medical_registration_no_exists = DoctorProfile::where('registration_no', $request->medical_registration_no)->count();
				if ($medical_registration_no_exists) {
					return response()->json(array('success' => false, 'error' => 'validation_error', 'message' => "Medical Registration Number already exists"));
				}*/
			}
			else if($user_type->user_role == 'patient'){
				$shedoctrid = Config::get('sheDoctr.db.patientPrefix');
			}
			else{
				return response()->json(array('success' => false, 'error' => 'validation_error', 'message' => "Something went wrong.<br />Please try again"));
			}

			$max_user_count = User::where('user_role', $user_type->id)->max('id');
			$max_user_count++;
			$user_id = str_pad($max_user_count, $shedoctrid_length, "0", STR_PAD_LEFT);

			  $shedoctrid .= $user_id;

			try{
				DB::beginTransaction();

				$user = User::create([
							'user_role' => $user_type->id,
							'shdct_user_id' => $shedoctrid,
							'name' => $data['name'],
							'email' => $data['email'],
							'mobile_no' => $data['mobileno'],
							'password' => bcrypt($data['password']),
							'active' => 1,
							'referred_by' => $referred_by
						]);

				// Add Credits to referrers account
				if ($user_type->user_role == 'patient') {
					if ($referred_by) {

						$delta = 100;
						if (array_key_exists('referral_credits', $this->settings)) {
							$delta = (int)$this->settings['referral_credits'];
						}

						$credits = PatientCredits::where('patient_id', $referred_by)->first();
						if (!$credits) {
							$credits = new PatientCredits();
							$credits->patient_id = $referred_by;
							$credits->credits = 0;
							$credits->save();
						}

						$credits->credits = $credits->credits + $delta;
						$credits->save();

						$credit_log = new PatientCreditLogs();
						$credit_log->patient_id = $referred_by;
						$credit_log->remarks = "Your friend ".$user->name." ( ".$user->email." ) signed up using your referral code";
						$credit_log->type = 'Credit';
						$credit_log->delta = $delta;
						$credit_log->transaction_date = Carbon::now()->toDateTimeString();
						$credit_log->save();
					}
				}

				$uid = $user->id;

				$crc = new CancelRescheduleCount();
				$crc->user_id = $uid;
				$crc->cancel_count = 0;
				$crc->reschedule_count = 0;
				$crc->save();

				$urc = new UserReferralCode();
				$urc->user_id = $uid;
				$urc->referral_code = 'SHDCTRF'.$uid;
				$urc->save();

				if ($user_type->user_role == 'doctor') {
					$doctor_profile = new DoctorProfile();
					$doctor_profile->doctor_id = $user->id;
					$doctor_profile->prefix = 'Dr.';
					$doctor_profile->name = $data['name'];
					$doctor_profile->registration_no = $request->medical_registration_no;
					$doctor_profile->is_verified = 0;
					$doctor_profile->save();
				}
				DB::commit();
			}
			catch(Exception $e){
				DB::rollBack();
				return response()->json(['success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"], 500);
			}

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
					$message->subject('SheDoctr - New User Registration');
				});
			}
		}



			//$token = str_random(30);

			// Create verification code
			//$verification_code = VerificationCodes::sendActivationMail($user, $token);

			return response()->json(array('success' => true, 'message' => 'Registration Completed Successfully.'));
		}
		catch(Exception $e){
			return response()->json(array('success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again", 'data' => $e->getMessage()));
		}
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

	public function forgotPassword(Request $request){
		try{
			if ($request->has('username')) {
				$username = $request->username;

				$user = User::where('email', $username)
								->orWhere('mobile_no', $username)
								->first();

				if ($user != NULL && $user->active == 1) {
					$reset_code = str_random(6);

					PasswordResetCodes::where('user_id', $user->id)->delete();

					$password_reset_code = new PasswordResetCodes;
					$password_reset_code->user_id = $user->id;
					$password_reset_code->code = $reset_code;
					$password_reset_code->save();

					// Add Code to send email and sms
					$send_notifications = $this->sendPasswordResetMail($user, $reset_code);

					if (!$send_notifications) {
						throw new Exception('Could not send notification');
					}

					return response()->json(array('success' => true, 'message' => "Reset code has been sent to your Email/Mobile No."));
				}
				else{
					return response()->json(['success' => false, 'error' => 'invalid_credentials', 'message' => 'Username not found']);				
				}
			}
			else{
				return response()->json(array('success' => false, 'error' => 'validation_error', 'message' => "Something went wrong.<br />Please try again"));
			}
		}
		catch(Exception $e){
			return response()->json(array('success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"));
		}
	}

	public function resendResetCode(Request $request){
		try{
			if ($request->has('username')) {
				$username = $request->username;

				$user = User::where('email', $username)
								->orWhere('mobile_no', $username)
								->first();

				if ($user != NULL && $user->active == 1) {
					$reset_code = PasswordResetCodes::where('user_id', $user->id)->value('code');

					// Add Code to send email and sms
					$send_notifications = $this->sendPasswordResetMail($user, $reset_code);

					if (!$send_notifications) {
						throw new Exception('Could not send notification');
					}

					return response()->json(array('success' => true, 'message' => "Reset code has been sent to your Email/Mobile No."));
				}
				else{
					return response()->json(['success' => false, 'error' => 'invalid_credentials', 'message' => 'Username not found']);				
				}
			}
			else{
				return response()->json(array('success' => false, 'error' => 'validation_error', 'message' => "Something went wrong.<br />Please try again"));
			}
		}
		catch(Exception $e){
			return response()->json(array('success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"));
		}
	}

	public function resetPassword(Request $request){
		try{

			$validator = Validator::make($request->all(),[
				'username' => 'required',
				'resetcode' => 'required',
				'password' => 'required',
			]);

			if ($validator->fails()) {
				return response()->json(array('success' => false, 'error' => 'validation_error', 'message' => "Something went wrong.<br />Please try again"));
			}

			$data = array(
				'username' => $request->username,
				'resetcode' => $request->resetcode,
				'password' => $request->password
			);

			$user = User::where('email', $data['username'])
								->orWhere('mobile_no', $data['username'])
								->first();

			if ($user != NULL && $user->active == 1) {
				$reset_code = PasswordResetCodes::where('user_id', $user->id)->first();

				if (!$reset_code) {
					throw new Exception('Reset Code Not Found');
				}

				if ($reset_code->code === $data['resetcode']) {

					$expiry = (int)Config::get('sheDoctr.webapp.code_expiry');
					$expiry = $expiry*60;

					$expiresAt = Carbon::parse($reset_code->created_at)->addSeconds($expiry);
					if ($expiresAt->isPast()) {
						PasswordResetCodes::where('user_id', $user->id)->delete();
						return response()->json(['success' => false, 'error' => 'reset_code_expired', 'message' => 'Reset Code Has Expired.<br />Please generate a new one']);
					}

					$user->password = bcrypt($data['password']);
					$user->save();

					PasswordResetCodes::where('user_id', $user->id)->delete();

					return response()->json(array('success' => true, 'message' => "Password Reset Successfully.<br />Please Login"));
				}
				else{
					return response()->json(['success' => false, 'error' => 'invalid_credentials', 'message' => 'Invalid Reset Code']);
				}
			}
			else{
				return response()->json(['success' => false, 'error' => 'invalid_credentials', 'message' => 'Username not found']);				
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
				$message->subject('SheDoctr Reset Password');
			});

			// Send SMS
			$msgtxt = "Your SheDoctr Password Reset Code is : ".$reset_code;

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
			$mobile_no_exists = User::where('mobile_no', $data['mobileno'])->count();
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
			
			
			$msgtxt = "Please enter OTP: ".$otp_code." for account verification. Thank you";

			$msgData = array(
				'recipient_no' => $data['mobileno'],
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