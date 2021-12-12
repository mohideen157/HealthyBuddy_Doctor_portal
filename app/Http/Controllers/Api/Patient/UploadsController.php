<?php

namespace App\Http\Controllers\Api\Patient;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Helpers\Helper;

use App\Model\AdminSettings;

use URL;
use Validator;
use Carbon\Carbon;

use App\Model\UploadFile;

class UploadsController extends Controller
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

	public function index(){
		try{
			$user = Helper::isUserLoggedIn();

			if (!$user) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => "Unauthorized"], 401);
			}

			$uploads = UploadFile::where('user_id', $user->id)->get();
			$return_arr = array();

			foreach ($uploads as $u) {
				$arr = array(
					'id' => $u->id,
					'type' => $u->type,
					'title' => $u->title,
					'path' => URL::to('/').$u->path,
					'datetime' => $u->created_at->toAtomString()
				);
				array_push($return_arr, $arr);
			}

			if (array_key_exists('upload_file_count_limit', $this->settings)) {
				$max_file_allowed = (int)$this->settings['upload_file_count_limit'];
			}
			else{
				$max_file_allowed = 10;
			}

			return response()->json(['success' => true, 'data' => ['max_upload_count' => $max_file_allowed, 'files' => $return_arr]]);
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

			$validator = Validator::make($request->all(),[
				'type' => 'required',
				'title' => 'required',
				'file' => 'required|file'
			]);

			if ($validator->fails()) {
				return response()->json(['success' => false, 'error' => 'validation_error', 'message' => "Did not get proper input"]);
			}

			$uploaded_file_count = UploadFile::where('user_id', $user->id)->count();

			if (array_key_exists('upload_file_count_limit', $this->settings)) {
				$max_file_allowed = (int)$this->settings['upload_file_count_limit'];
			}
			else{
				$max_file_allowed = 10;
			}
			

			if ($uploaded_file_count >= $max_file_allowed) {
				return response()->json(['success' => false, 'error' => 'not_allowed', 'message' => 'You have exceeded the maximum number of files allowed per user.<br />Please remove existing files to upload new file']);
			}

			$upload_file = new UploadFile();
			$upload_file->user_id = $user->id;

			$file = $request->file('file');

			$timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
			$image_path = $timestamp. '-' .$file->getClientOriginalName();
			$file->move(public_path().'/uploads/patients/'.$user->shdct_user_id.'/my-uploads/', $image_path);

			$upload_file->type = $request->type;
			$upload_file->title = $request->title;
			$upload_file->path = '/uploads/patients/'.$user->shdct_user_id.'/my-uploads/'.$image_path;
			$upload_file->save();

			$return_arr = array(
				'id' => $upload_file->id,
				'type' => $upload_file->type,
				'title' => $upload_file->title,
				'path' => URL::to('/').$upload_file->path,
				'datetime' => $upload_file->created_at->toAtomString()
			);

			return response()->json(['success' => true, 'data' => $return_arr]);
		}
		catch(Exception $e){
			return response()->json(['success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"], 500);
		}
	}

	public function destroy($id){
		try{
			$user = Helper::isUserLoggedIn();

			if (!$user) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => "Unauthorized"], 401);
			}

			$file = UploadFile::find($id);

			if ($file->user_id != $user->id) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => 'The file you are trying to delete belongs to another user']);
			}
if(isset($file->path)) {
			unlink(public_path().$file->path);
			$file->delete();

			return response()->json(['success' => true]);
			}
			else
			{
			return response()->json(['success' => false, 'error' => 'auth_error', 'message' => 'The file you are trying to delete not exists']);
			}
		}
		catch(Exception $e){
			return response()->json(['success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"], 500);
		}
	}
}
