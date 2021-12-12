<?php

namespace App\Http\Controllers\Api\Appointment;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\Feedback;
use App\Model\CallFeedback;
use App\Model\Appointment\AppointmentCallLogs;
use Carbon\Carbon;

use App\Helpers\Helper;

use Validator;

class CallController extends Controller
{
    public function callFeedback(Request $request){
    	try{
			$user = Helper::isUserLoggedIn();

			if (!$user) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => "Unauthorized"], 401);
			}

			if (!$request->has('appointment_id')) {
				return response()->json(['success' => false, 'error' => 'validation_error', 'message' => "Did not get the appointment"]);
			}

			if (!$request->has('rating')) {
				return response()->json(['success' => false, 'error' => 'validation_error', 'message' => "Did not get the rating to save"]);
			}

			$already_exists = CallFeedback::where('appointment_id', $request->appointment_id)
											->where('user_id', $user->id)
											->count();

			if ($already_exists > 0) {
				return response()->json(['success' => true, 'message' => 'Your feedback is already saved for this appointment']);
			}

			$feedback = new CallFeedback();
			$feedback->appointment_id = $request->appointment_id;
			$feedback->user_id = $user->id;
			$feedback->rating = $request->rating;

			$feedback->save();

			return response()->json(['success' => true, 'message' => 'Feedback Saved']);
		}
		catch(Exception $e){
			return response()->json(['success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"], 500);
		}
    }

    public function saveCallLog(Request $request){
    	try{
			$user = Helper::isUserLoggedIn();

			if (!$user) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => "Unauthorized"], 401);
			}

			if (!$request->has('appointment_id')) {
				return response()->json(['success' => false, 'error' => 'validation_error', 'message' => "Did not get the appointment"]);
			}

			$call_log = AppointmentCallLogs::where('appointment_id', $request->appointment_id)->count();

			if ($call_log <= 0) {
				$call_log = new AppointmentCallLogs();
				$call_log->appointment_id = $request->appointment_id;
				$call_log->user_id = $user->id;
				$call_log->start = Carbon::parse($request->start)->toDateTimeString();
				$call_log->end = Carbon::parse($request->end)->toDateTimeString();
				$call_log->save();
			}

			return response()->json(['success' => true]);
		}
		catch(Exception $e){
			return response()->json(['success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"], 500);
		}
    }
}
