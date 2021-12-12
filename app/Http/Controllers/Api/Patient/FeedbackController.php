<?php

namespace App\Http\Controllers\Api\Patient;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\Feedback;
use App\Model\CallFeedback;

use App\Helpers\Helper;

use Validator;

class FeedbackController extends Controller
{
	public function create(Request $request){
		try{
			$user = Helper::isUserLoggedIn();

			if (!$user) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => "Unauthorized"], 401);
			}

			$validator = Validator::make($request->all(),[
				'topic'     => 'required',
				'rating' => 'required',
				'feedback'    => 'required',
			]);

			if ($validator->fails()) {
				return response()->json(['success' => false, 'error' => 'validation_error', 'message' => "Did not get proper input"]);
			}

			$feedback = new Feedback();
			$feedback->user_id = $user->id;
			$feedback->topic = $request->topic;
			$feedback->rating = $request->rating;
			$feedback->feedback = $request->feedback;

			$feedback->save();

			return response()->json(['success' => true, 'message' => 'Feedback Saved']);
		}
		catch(Exception $e){
			return response()->json(['success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"], 500);
		}
	}

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
}
