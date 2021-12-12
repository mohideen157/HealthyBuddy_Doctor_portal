<?php

namespace App\Http\Controllers\Api\Patient;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\User\UserReferralCode;

use App\User;

use App\Helpers\Helper;

use Mail;
use Config;

class ReferralsController extends Controller
{
    public function send(Request $request){
    	try{
			$user = Helper::isUserLoggedIn();

			if (!$user) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => "Unauthorized"], 401);
			}

			$urc = UserReferralCode::where('user_id', $user->id)->first();

			if (!$urc) {
				$urc = new UserReferralCode();
				$urc->user_id = $user->id;
				$urc->referral_code = 'SHDCTRF'.$user->id;
				$urc->save();
			}

			$user_exists = false;

			if ($request->has('email')) {
				$u = User::where('email', $request->email)->count();
				if ($u > 0) {
					return response()->json(['success' => false, 'error' => 'already_exists', 'message' => 'Referred User is already a part of SheDoctr']);
				}
				$data = array(
					'referral_code' => $urc->referral_code,
					'referrer' => $user->name,
					'link' => Config::get('sheDoctr.webapp.url'),
					'email' => $request->email
				);

				$sendemail = Mail::send('emails.referral', $data, function ($message) use ($data)
				{
					$message->to($data['email']);
					$message->subject('Signup On SheDoctr');
				});
			}

			if ($request->has('mobile_no')) {
				$u = User::where('mobile_no', $request->mobile_no)->count();
				if ($u > 0) {
					return response()->json(['success' => false, 'error' => 'already_exists', 'message' => 'Referred User is already a part of SheDoctr']);
				}
				$msgtxt = "Please sign up using my referral code : ".$urc->referral_code." Link : ".Config::get('sheDoctr.webapp.url');

				$msgData = array(
					'recipient_no' => $request->mobile_no,
					'msgtxt' => $msgtxt
				);

				$sendsms = Helper::sendSMS($msgData);
			}

			return response()->json(['success' => true]);
		}
		catch(Exception $e){
			return response()->json(['success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"], 500);
		}
    }
}
