<?php

namespace App\Http\Controllers\Api\Patient;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Helpers\Helper;

use Validator;
use Mail;

class SupportController extends Controller
{
    public function create(Request $request){
    	try{
    		$user = Helper::isUserLoggedIn();

			if (!$user) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => "Unauthorized"], 401);
			}

			$validator = Validator::make($request->all(),[
				'regarding' => 'required',
				'query' => 'required',
			]);

			if ($validator->fails()) {
				return response()->json(['success' => false, 'error' => 'validation_error', 'message' => "Did not get proper input"]);
			}

    		// Send Mail
			$sendemail = Mail::send('emails.enquiry', $request->all(), function ($message) use ($user)
			{
				$message->to(['support@shedoctr.com' => 'SheDoctr Support', $user->email => $user->name]);
				// $message->cc($user->email, $user->name);
				$message->subject('Patient Enquiry');
			});

			return response()->json(['success' => true]);
    	}
    	catch(Exception $e){
    		return response()->json(['success' => true, 'error' => 'server_error', 'message' => 'Something went wrong while to send your support enquiry'], 500);
    	}
    }
}
