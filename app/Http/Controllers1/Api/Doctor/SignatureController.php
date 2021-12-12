<?php

namespace App\Http\Controllers\Api\Doctor;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\Doctor\DoctorSignature;

use App\Helpers\Helper;

class SignatureController extends Controller
{
	public function index(){
		try{
			$user = Helper::isUserLoggedIn();

			if (!$user) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => "Unauthorized"], 401);
			}

			$image = '';

			$doctor_signature = DoctorSignature::where('doctor_id', $user->id)->first();

			if ($doctor_signature) {
				$image = $doctor_signature->image;
			}			

			return response()->json(['success' => true, 'data' => ['image' => $image], 'message' => 'File Uploaded']);
		}
		catch(Exception $e){
			return response()->json(['success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"], 500);
		}
	}

	public function create(Request $request){
		try{
			$user = Helper::isUserLoggedIn();

			if (!$user) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => "Unauthorized"], 401);
			}

			if (!$request->hasFile('file')) {
				return response()->json(['success' => false, 'error' => 'validation_error', 'message' => "Did not get the file to save"]);
			}

			if (!$request->file('file')->isValid()) {
				return response()->json(['success' => false, 'error' => 'upload_error', 'message' => "Did not get a valid file"]);
			}

			$file = $request->file('file');

			$doctor_signature = DoctorSignature::where('doctor_id', $user->id)->first();

			if (!$doctor_signature) {
				$doctor_signature = new DoctorSignature();
				$doctor_signature->doctor_id = $user->id;
			}

			$image = file_get_contents($file);

			$doctor_signature->image_type = $file->getMimeType();
			$doctor_signature->image = base64_encode($image);
			$doctor_signature->image_size = $file->getClientSize();
			$doctor_signature->image_name = $file->getClientOriginalName();

			$doctor_signature->save();

			return response()->json(['success' => true, 'data' => ['image' => base64_encode($image)], 'message' => 'File Uploaded']);
		}
		catch(Exception $e){
			return response()->json(['success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"], 500);
		}
	}
}
