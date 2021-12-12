<?php

namespace App\Http\Controllers\Api\Doctor;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

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
use App\Model\Doctor\DoctorReceptionist;

use App\Helpers\Helper;

class ReceptionistController extends Controller
{	
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(){
		try{
			$user = Helper::isUserLoggedIn();

			if (!$user) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => "Unauthorized"], 401);
			}
			$return_arr = array();

			$receptionist = DoctorReceptionist::where('doctor_id', $user->id)->get();

			foreach ($receptionist as $rec) {
				$data = $rec->userdata;
				$arr = array(
					'id' => $rec->id,
					'name' => $data->name,
					'email' => $data->email,
					'mobile' => $data->mobile_no
				);
				array_push($return_arr, $arr);
			}

			/*if ($receptionist) {
				$data = $receptionist->userdata;
				$arr = array(
					'name' => $data->name,
					'email' => $data->email,
					'mobile' => $data->mobile_no
				);
			}*/

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
	public function store(Request $request){
		try{
			$user = Helper::isUserLoggedIn();

			if (!$user) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => "Unauthorized"], 401);
			}

			// Do not allow more than one receptionist
			$receptionist_count = DoctorReceptionist::where('doctor_id', $user->id)->count();
			if ($receptionist_count > 0) {
				return response()->json(['success' => false, 'error' => 'not_allowed', 'message' => 'You cannot add more than one receptionist'], 403);
			}

			$validator = Validator::make($request->all(),[
				'name' => 'required',
				'email' => 'required',
				'mobile' => 'required',
				'password' => 'required',
			]);

			if ($validator->fails()) {
				return response()->json(array('success' => false, 'error' => 'validation_error', 'message' => "Something went wrong.<br />Please try again"));
			}

			$data = array(
				'name'      => $request->name,
				'email'     => $request->email,
				'mobileno'  => $request->mobile,
				'password'  => $request->password,
			);

			$user_role = Helper::getUserRoleID('receptionist');

			$email_exists = User::where('email', $data['email'])->count();
			$mobile_no_exists = User::where('mobile_no', $data['mobileno'])->count();

			if ($email_exists > 0) {
				return response()->json(array('success' => false, 'error' => 'validation_error', 'message' => "Email ID already exists.<br />Please enter a different mail address"));
			}
			if ($mobile_no_exists > 0) {
				return response()->json(array('success' => false, 'error' => 'validation_error', 'message' => "Mobile Number already exists.<br />Please enter a different mobile number"));
			}

			$shedoctrid = '';
			$shedoctrid_length = Config::get('sheDoctr.db.numberLength');
			$shedoctrid = Config::get('sheDoctr.db.receptionistPrefix');

			$max_user_count = User::where('user_role', $user_role)->count();
			$max_user_count++;
			$user_id = str_pad($max_user_count, $shedoctrid_length, "0", STR_PAD_LEFT);

			$shedoctrid .= $user_id;

			$rec_user = User::create([
				'user_role' => $user_role,
				'shdct_user_id' => $shedoctrid,
				'name' => $data['name'],
				'email' => $data['email'],
				'mobile_no' => $data['mobileno'],
				'password' => bcrypt($data['password']),
				'online' => 1,
				'active' => 1,
				'profile_image' => '/images/recp-profile.png'
			]);

			$rec = new DoctorReceptionist();
			$rec->receptionist_id = $rec_user->id;
			$rec->doctor_id = $user->id;
			$rec->save();

			return response()->json(['success' => true, 'message' => 'Receptionist Added']);
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
	public function show($id){
		try{
			$user = Helper::isUserLoggedIn();

			if (!$user) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => "Unauthorized"], 401);
			}

			$receptionist = DoctorReceptionist::find($id);

			if (!$receptionist) {
				return response()->json(['success' => false, 'error' => 'not_found', 'message' => 'We could not find the receptionist you want to edit']);
			}

			if ($receptionist->doctor_id != $user->id) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => 'Unauthorized<br />You are trying to access receptionist that is not associated to your  account'], 403);
			}

			$data = $receptionist->userdata;
			$return_arr = array(
				'id' => $receptionist->id,
				'name' => $data->name,
				'email' => $data->email,
				'mobile' => $data->mobile_no
			);		

			return response()->json(['success' => true, 'data' => $return_arr]);
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
	public function update(Request $request, $id){
		try{
			$user = Helper::isUserLoggedIn();

			if (!$user) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => "Unauthorized"], 401);
			}

			$receptionist = DoctorReceptionist::find($id);

			if (!$receptionist) {
				return response()->json(['success' => false, 'error' => 'not_found', 'message' => 'We could not find the receptionist you are trying to update']);
			}

			if ($receptionist->doctor_id != $user->id) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => 'Unauthorized<br />You are trying to access receptionist that is not associated to your  account'], 403);
			}

			$validator = Validator::make($request->all(),[
				'name' => 'required',
			]);

			if ($validator->fails()) {
				return response()->json(array('success' => false, 'error' => 'validation_error', 'message' => "Something went wrong.<br />Please try again"));
			}


			$rec_user = User::find($receptionist->receptionist_id);

			$rec_user->name = $request->name;

			if ($request->has('password') && $request->password != '') {
				$rec_user->password = bcrypt($request->password);
			}

			if ($request->has('email') && $request->email != '' && $request->email != $rec_user->email) {
				$email_exists = User::where('email', $request->email)->count();
				if ($email_exists > 0) {
					return response()->json(array('success' => false, 'error' => 'validation_error', 'message' => "Email ID already exists.<br />Please enter a different mail address"));
				}

				$rec_user->email = $request->email;
			}

			if ($request->has('mobile') && $request->mobile != '' && $request->mobile != $rec_user->mobile_no) {
				$mobile_no_exists = User::where('mobile_no', $request->mobile)->count();
			
				if ($mobile_no_exists > 0) {
					return response()->json(array('success' => false, 'error' => 'validation_error', 'message' => "Mobile Number already exists.<br />Please enter a different mobile number"));
				}

				$rec_user->mobile_no = $request->mobile;
			}

			$rec_user->save();

			return response()->json(['success' => true, 'message' => 'Receptionist Updated']);
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
	public function destroy($id){
		try{
			$user = Helper::isUserLoggedIn();

			if (!$user) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => "Unauthorized"], 401);
			}

			$receptionist = DoctorReceptionist::find($id);

			if (!$receptionist) {
				return response()->json(['success' => false, 'error' => 'not_found', 'message' => 'We could not find the receptionist you are trying to remove']);
			}

			if ($receptionist->doctor_id != $user->id) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => 'Unauthorized<br />You are trying to access receptionist that is not associated to your  account'], 403);
			}

			// Remove the user
			$rec_user = User::find($receptionist->receptionist_id);
			$rec_user->delete();

			// Remove from receptionist table
			$receptionist->delete();

			return response()->json(['success' => true, 'message' => 'Receptionist Removed']);
		}
		catch(Exception $e){
			return response()->json(['success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"], 500);
		}
	}
}
