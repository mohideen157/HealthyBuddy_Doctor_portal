<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Model\UploadFile;

use Flow\Autoloader as FAutoloader;
use Flow\Config as FConfig;
use Flow\Request as FRequest;
use Flow\Basic as FBasic;
use Flow\File as FFile;

use URL;
use Log;
use Carbon\Carbon;

use App\Helpers\Helper;

class AppFileController extends Controller
{
	public function uploadFile(Request $request){

		$user = Helper::isUserLoggedIn();

		if (!$user) {
			return response()->json(array('success' => false, 'error' => 'auth_error', 'message' => "Something went wrong.<br />Please try again"), 401);
		}

		$config = new FConfig(['tempDir'=> public_path('uploads/chunks_temp_folder')]);
		$frequest = new FRequest();

		$file = new FFile($config);

		$filename = $frequest->getFileName();

		if ($_SERVER['REQUEST_METHOD'] === 'GET') {
			$allowed =  array('gif','png' ,'jpg', 'pdf');
			
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			if(!in_array($ext,$allowed) ) {
				return response()->json([], 400);
			}

			if (!$file->checkChunk()) {
				return response()->json([], 204);
			}
		}
		else {
			if ($file->validateChunk()) {
				$file->saveChunk();
			}
			else {
				// error, invalid chunk upload request, retry
				return response()->json([], 400);
			}
		}

		$dt = Carbon::now();

		$main_path = 'uploads/';
		$inner_path = $dt->year.'/'.$dt->month.'/'.$user->id.'/';

		//The name of the directory that we need to create.
		$directoryName = public_path($main_path.$inner_path);
		 
		//Check if the directory already exists.
		if(!is_dir($directoryName)){
			//Directory does not exist, so lets create it.
			mkdir($directoryName, 0755, true);
		}

		$filesavename = $dt->day.'-'.$dt->hour.'-'.$dt->minute.'-'.$dt->second.'-'.$filename;

		// Appending datetime to filename to prevent overwriting
		$save_path = $main_path.$inner_path.$filesavename;

		if ($file->validateFile() && $file->save(public_path($save_path))) {
			
			$upload_file = new UploadFile;
			$upload_file->user_id = $user->id;
			$upload_file->name = $filesavename;
			$upload_file->path = '/'.$save_path;
			$upload_file->save();

			return response()->json(['success' => true, 'data' => ['id' => $upload_file->id, 'path' => URL::to('/').'/'.$save_path, 'report_type' => $_REQUEST['report_type']], 'message' => 'File Uploaded Successfully']);
		} else {
			// This is not a final chunk, continue to upload
		}
	}

	public function removeFile(Request $request){
		
	}
}
