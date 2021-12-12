<?php

namespace App\Http\Controllers\Api\Doctor;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Mail;

use App\User;
use App\Model\UserRole;

use App\Model\Doctor\DoctorDocuments;

use App\Model\Notification;

use App\Helpers\Helper;

use Carbon\Carbon;

class DocumentsController extends Controller
{
    public function create(Request $request){
    	try{
			$user = Helper::isUserLoggedIn();

			if (!$user) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => "Unauthorized"], 401);
			}

			/*if (!$request->hasFile('degree') || !$request->hasFile('government_id') || !$request->hasFile('medical_registration_certificate')) {
				return response()->json(['success' => false, 'error' => 'validation_error', 'message' => "Did not get the file to save"]);
			}

			if (!$request->file('degree')->isValid() || !$request->file('government_id')->isValid() || !$request->file('medical_registration_certificate')->isValid()) {
				return response()->json(['success' => false, 'error' => 'upload_error', 'message' => "Did not get a valid file"]);
			}*/

			/*$d_count = DoctorDocuments::where('doctor_id', $user->id)->count();

			if ($d_count > 0) {
				return response()->json(['success' => false, 'error' => 'exists', 'message' => 'Documents already saved']);
			}*/

			$document = DoctorDocuments::where('doctor_id', $user->id)->first();

			if (!$document) {
				$document = new DoctorDocuments();
				$document->doctor_id = $user->id;
			}

			$all_docs_uploaded = false;
			

			$timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());


			if ($request->hasFile('degree') && $request->file('degree')->isValid()) {
				$file = $request->file('degree');
				$image_path = $timestamp. '-' .$file->getClientOriginalName();
				$file->move(public_path().'/uploads/doctors/'.$user->id.'/documents/', $image_path);

				$document->medical_degree = '/uploads/doctors/'.$user->id.'/documents/'.$image_path;
				$document->medical_degree_verified = 0;
				$document->medical_degree_reject_reason = NULL;
			}

			if ($request->hasFile('government_id') && $request->file('government_id')->isValid()) {
				$file = $request->file('government_id');
				$image_path = $timestamp. '-' .$file->getClientOriginalName();
				$file->move(public_path().'/uploads/doctors/'.$user->id.'/documents/', $image_path);

				$document->government_id = '/uploads/doctors/'.$user->id.'/documents/'.$image_path;
				$document->government_id_verified = 0;
				$document->government_id_reject_reason = NULL;
			}

			if ($request->hasFile('medical_registration_certificate') && $request->file('medical_registration_certificate')->isValid()) {
				$file = $request->file('medical_registration_certificate');
				$image_path = $timestamp. '-' .$file->getClientOriginalName();
				$file->move(public_path().'/uploads/doctors/'.$user->id.'/documents/', $image_path);

				$document->medical_registration_certificate = '/uploads/doctors/'.$user->id.'/documents/'.$image_path;
				$document->medical_registration_certificate_verified = 0;
				$document->medical_registration_certificate_reject_reason = NULL;
			}

			if ($document->medical_degree && $document->government_id && $document->medical_registration_certificate) {
				$all_docs_uploaded = true;
			}

			/*$file = $request->file('degree');
			$image_path = $timestamp. '-' .$file->getClientOriginalName();
			$file->move(public_path().'/uploads/doctors/'.$user->id.'/documents/', $image_path);

			$document->medical_degree = '/uploads/doctors/'.$user->id.'/documents/'.$image_path;
			$document->medical_degree_verified = 0;

			$file = $request->file('government_id');
			$image_path = $timestamp. '-' .$file->getClientOriginalName();
			$file->move(public_path().'/uploads/doctors/'.$user->id.'/documents/', $image_path);

			$document->government_id = '/uploads/doctors/'.$user->id.'/documents/'.$image_path;
			$document->government_id_verified = 0;

			$file = $request->file('medical_registration_certificate');
			$image_path = $timestamp. '-' .$file->getClientOriginalName();
			$file->move(public_path().'/uploads/doctors/'.$user->id.'/documents/', $image_path);

			$document->medical_registration_certificate = '/uploads/doctors/'.$user->id.'/documents/'.$image_path;
			$document->medical_registration_certificate_verified = 0;*/

			$document->save();

			if ($all_docs_uploaded) {
				$admin_user = UserRole::where('user_role', 'admin')->value('id');
				$admin_users = User::where('user_role', $admin_user)->get();
				
				$notification = array(
					'type' => 'NewUser',
					'subject' => 'New Doctor Registration',
					'body' => 'New doctor registered and is pending approval',
					'email' => 'emails.newdoctor'
				);

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

				$sendemail = Mail::send('emails.documentUploaded', array('name' => $user->name), function ($message) use ($user)
				{
					$message->to($user->email, $user->name);
					$message->subject('SheDoctr - All Documents Uploaded');
				});
			}

			return response()->json(['success' => true, 'message' => 'Documents Saved']);
		}
		catch(Exception $e){
			return response()->json(['success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"], 500);
		}
    }

    public function update(Request $request){
    	try{
			$user = Helper::isUserLoggedIn();

			if (!$user) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => "Unauthorized"], 401);
			}

			$d_count = DoctorDocuments::where('doctor_id', $user->id)->count();

			if ($d_count <= 0) {
				return response()->json(['success' => false, 'error' => 'not_exists', 'message' => 'Other Documents not found']);
			}

			$document = DoctorDocuments::where('doctor_id', $user->id)->first();

			if ($document->doctor_id != $user->id) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => 'You are trying to access documents of another user']);
			}

			$timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());

			if ($request->hasFile('degree') && $request->file('degree')->isValid()) {
				$file = $request->file('degree');
				$image_path = $timestamp. '-' .$file->getClientOriginalName();
				$file->move(public_path().'/uploads/doctors/'.$user->id.'/documents/', $image_path);

				$document->medical_degree = '/uploads/doctors/'.$user->id.'/documents/'.$image_path;
				$document->medical_degree_verified = 0;
				$document->medical_degree_reject_reason = NULL;
			}

			if ($request->hasFile('government_id') && $request->file('government_id')->isValid()) {
				$file = $request->file('government_id');
				$image_path = $timestamp. '-' .$file->getClientOriginalName();
				$file->move(public_path().'/uploads/doctors/'.$user->id.'/documents/', $image_path);

				$document->government_id = '/uploads/doctors/'.$user->id.'/documents/'.$image_path;
				$document->government_id_verified = 0;
				$document->government_id_reject_reason = NULL;
			}

			if ($request->hasFile('medical_registration_certificate') && $request->file('medical_registration_certificate')->isValid()) {
				$file = $request->file('medical_registration_certificate');
				$image_path = $timestamp. '-' .$file->getClientOriginalName();
				$file->move(public_path().'/uploads/doctors/'.$user->id.'/documents/', $image_path);

				$document->medical_registration_certificate = '/uploads/doctors/'.$user->id.'/documents/'.$image_path;
				$document->medical_registration_certificate_verified = 0;
				$document->medical_registration_certificate_reject_reason = NULL;
			}			

			$document->save();

			$admin_user = UserRole::where('user_role', 'admin')->value('id');
			$admin_users = User::where('user_role', $admin_user)->get();
			
			$notification = array(
				'type' => 'DoctorDocumentChanged',
				'subject' => 'Doctor Updated their documents',
				'body' => 'Doctor changed their documents and is pending verification'
			);

			foreach ($admin_users as $u) {
				$u->newNotification()
					->withType($notification['type'])
					->withSubject($notification['subject'])
					->withBody($notification['body'])
					->regarding($document)
					->deliver();

				// Send Mail
				$sendemail = Mail::send('emails.documentupdated', array(), function ($message) use ($u)
				{
					$message->to($u->email, $u->name);
					$message->subject('SheDoctr - Document Updated');
				});
			}

			return response()->json(['success' => true, 'message' => 'Documents Updated']);
		}
		catch(Exception $e){
			return response()->json(['success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"], 500);
		}
    }
}
