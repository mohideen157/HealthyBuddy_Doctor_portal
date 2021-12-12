<?php

namespace App\Http\Controllers\Api\Doctor;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\Doctor\DoctorProfile;

use App\Model\HealthTip;

use App\Model\Notification;
use App\User;

use App\Helpers\Helper;

use URL;
use Validator;
use Carbon\Carbon;
use Mail;

class HealthTipController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		try{
			$user = Helper::isUserLoggedIn();

			if (!$user) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => "Unauthorized"], 401);
			}

			$start = 0;
			$limit = 2;

			if ($request->has('start')) {
				$start = $request->start;
			}
			if ($request->has('limit')) {
				$limit = $request->limit;
			}

			$health_tips = HealthTip::where('doctor_id', $user->id)->skip($start)->take($limit)->orderBy('created_at', 'desc')->get();

			$return_arr = array();
			foreach ($health_tips as $tip) {
				$arr = array(
					'id' => $tip->id,
					'title' => $tip->title,
					'content' => nl2br($tip->content),
					'image' => ($tip->image?URL::to('/').$tip->image:false),
					'active' => $tip->active,
					'slug' => $tip->slug,
					'posted_at' => $tip->created_at->toAtomString()
				);

				array_push($return_arr, $arr);
			}

			return response()->json(['success' => true, 'data' => $return_arr]);
		}
		catch(Exception $e){
			return response()->json(['success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"], 500);
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		try{
			$user = Helper::isUserLoggedIn();

			if (!$user) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => "Unauthorized"], 401);
			}

			$validator = Validator::make($request->all(),[
				'title' => 'required',
				'content' => 'required',
			]);

			if ($validator->fails()) {
				return response()->json(['success' => false, 'error' => 'validation_error', 'message' => "Did not get proper input"]);
			}

			/*if (!$request->hasFile('file')) {
				return response()->json(['success' => false, 'error' => 'validation_error', 'message' => "Did not get the file to save"]);
			}*/

			$tip = new HealthTip();
			$tip->doctor_id = $user->id;
			$tip->title = $request->title;
			$tip->content = $request->content;

			if ($request->hasFile('file')) {
				if (!$request->file('file')->isValid()) {
					return response()->json(['success' => false, 'error' => 'upload_error', 'message' => "Did not get a valid image"]);
				}

				$file = $request->file('file');

				$timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
				$image_path = $timestamp. '-' .$file->getClientOriginalName();
				$file->move(public_path().'/uploads/doctors/'.$user->id.'/', $image_path);

				$image = '/uploads/doctors/'.$user->id.'/'.$image_path;

				$tip->image = $image;
			}		
			
			$tip->active = 0;

			$tip->save();

			$doctor_profile = DoctorProfile::where('doctor_id', $user->id)->first();

			// Add Notification
			$admin_users = User::where('user_role', 1)->get();
			foreach ($admin_users as $u) {
				$u->newNotification()
					->withType('NewArticle')
					->withSubject('Article Posted')
					->withBody('Dr. '.$doctor_profile->name.' posted a new article and is pending approval')
					->regarding($tip)
					->deliver();

				// Send Mail
				$sendemail = Mail::send('emails.newarticle', array('data' => ['doctor_name' => $doctor_profile->name]), function ($message) use ($u)
				{
					$message->to($u->email, $u->name);
					$message->subject('SheDoctr - New Article Posted');
				});
			}

			return response()->json(['success' => true, 'response' => 'Health Tip has been sent for approval']);
		}
		catch(Exception $e){
			return response()->json(['success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"], 500);
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		try{
			$user = Helper::isUserLoggedIn();

			if (!$user) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => "Unauthorized"], 401);
			}

			$tip = HealthTip::findBySlug($id);
			if (!$tip) {
				return response()->json(['success' => false, 'error' => 'not_found', 'message' => 'We could not find the health tip']);
			}

			if ($tip->doctor_id != $user->id) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => 'You are trying to view health tip of another doctor']);
			}

			$arr = array(
				'id' => $tip->id,
				'title' => $tip->title,
				'content' => $tip->content,
				'image' => ($tip->image?URL::to('/').$tip->image:false),
				'active' => $tip->active,
				'slug' => $tip->slug,
				'posted_at' => $tip->created_at->toAtomString()
			);

			return response()->json(['success' => true, 'data' => $arr]);
		}
		catch(Exception $e){
			return response()->json(['success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"], 500);
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function updateqwe(Request $request, $id)
	{
		try{
			$user = Helper::isUserLoggedIn();

			if (!$user) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => "Unauthorized"], 401);
			}

			$tip = HealthTip::find($id);

			if (!$tip) {
				return response()->json(['success' => false, 'error' => 'not_found', 'message' => 'We could not find the health tip']);
			}

			if ($tip->doctor_id != $user->id) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => 'You are trying to view health tip of another doctor']);
			}

			if ($request->has('title')) {
				$tip->title = $request->title;
			}

			if ($request->has('content')) {
				$tip->content = $request->content;
			}

			if ($request->hasFile('file') && $request->file('file')->isValid()) {
				$file = $request->file('file');

				$timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
				$image_path = $timestamp. '-' .$file->getClientOriginalName();
				$file->move(public_path().'/uploads/doctors/'.$user->id.'/', $image_path);

				$image = '/uploads/doctors/'.$user->id.'/'.$image_path;

				$tip->image = $image;
			}

			$tip->active = 0;

			$tip->save();

			$doctor_profile = DoctorProfile::where('doctor_id', $user->id)->first();

			// Add Notification
			$admin_users = User::where('user_role', 1)->get();
			foreach ($admin_users as $u) {
				$u->newNotification()
					->withType('ArticleUpdated')
					->withSubject('Article Updated')
					->withBody('Dr. '.$doctor_profile->name.' updated their article and is pending approval')
					->regarding($tip)
					->deliver();

				// Send Mail
				$sendemail = Mail::send('emails.articleupdate', array('data' => ['doctor_name' => $doctor_profile->name]), function ($message) use ($u)
				{
					$message->to($u->email, $u->name);
					$message->subject('SheDoctr - Article Updated');
				});
			}

			return response()->json(['success' => true, 'message' => 'Health Tip updated']);			
		}
		catch(Exception $e){
			return response()->json(['success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"], 500);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		try{
			$user = Helper::isUserLoggedIn();

			if (!$user) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => "Unauthorized"], 401);
			}

			$tip = HealthTip::find($id);
			
			if (!$tip) {
				return response()->json(['success' => false, 'error' => 'not_found', 'message' => 'We could not find the health tip']);
			}

			if ($tip->doctor_id != $user->id) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => 'You are trying to remove health tip of another doctor']);
			}

			$tip->delete();

			return response()->json(['success' => true, 'message' => 'Health Tip Deleted']);
		}
		catch(Exception $e){
			return response()->json(['success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"], 500);
		}
	}
}
