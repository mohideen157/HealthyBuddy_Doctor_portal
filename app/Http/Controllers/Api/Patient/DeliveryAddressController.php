<?php

namespace App\Http\Controllers\Api\Patient;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\Patient\PatientAddress;
use App\Model\AdminSettings;

use App\Helpers\Helper;

use Validator;
use Carbon\Carbon;

class DeliveryAddressController extends Controller
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

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		try{
			$user = Helper::isUserLoggedIn();

			if (!$user) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => "Unauthorized"], 401);
			}

			$return_arr = array();

			$address = PatientAddress::where('patient_id', $user->id)->where('default', 0)->get();

			foreach ($address as $add) {

				$address_text = '';

				if ($add->address_line_1) {
					$address_text .= $add->address_line_1."\r\n";
				}

				if ($add->address_line_2) {
					$address_text .= $add->address_line_2."\r\n";
				}

				if ($add->state) {
					$address_text .= $add->state."\r\n";
				}

				if ($add->city) {
					$address_text .= $add->city.' - ';
				}

				if ($add->pincode) {
					$address_text .= $add->pincode."\r\n";
				}

				$address_text .= 'India';

				$arr = array(
					'id' => $add->id,
					'address' => nl2br($address_text),
					'address_line_1' => $add->address_line_1,
					'address_line_2' => $add->address_line_2,
					'state' => $add->state,
					'city' => $add->city,
					'pincode' => $add->pincode,
				);

				array_push($return_arr, $arr);
			}

			$max_allowed = 2;
			if (array_key_exists('max_delivery_address_count', $this->settings)) {
				$max_allowed = (int)$this->settings['max_delivery_address_count'];
			}			

			return response()->json(['success' => true, 'data' => [ 'max_allowed' => $max_allowed, 'address_list' => $return_arr ]]);
		}
		catch(Exception $e){
			return response()->json(['success' => false, 'error' => 'server_error', 'message' => 'Something went wrong.<br />Please try again'], 500);
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
				'address_line_1' => 'required',
				'state' => 'required',
				'city' => 'required',
				'pincode' => 'required',
			]);

			if ($validator->fails()) {
				return response()->json(['success' => false, 'error' => 'validation_error', 'message' => "Did not get proper input"]);
			}

			$address = new PatientAddress();
			$address->patient_id = $user->id;
			$address->default = 0;

			$address->address_line_1 = $request->address_line_1;
			if ($request->has('address_line_2')) {
				$address->address_line_2 = $request->address_line_2;
			}				
			$address->state = $request->state;
			$address->city = $request->city;
			$address->pincode = $request->pincode;
			$address->save();

			$address_text = '';

			if ($address->address_line_1) {
				$address_text .= $address->address_line_1."\r\n";
			}

			if ($address->address_line_2) {
				$address_text .= $address->address_line_2."\r\n";
			}

			if ($address->state) {
				$address_text .= $address->state."\r\n";
			}

			if ($address->city) {
				$address_text .= $address->city.' - ';
			}

			if ($address->pincode) {
				$address_text .= $address->pincode."\r\n";
			}

			$address_text .= 'India';

			$return_arr = array(
				'id' => $address->id,
				'address' => nl2br($address_text),
				'address_line_1' => $address->address_line_1,
				'address_line_2' => $address->address_line_2,
				'state' => $address->state,
				'city' => $address->city,
				'pincode' => $address->pincode,
			);

			return response()->json(['success' => true, 'data' => $return_arr]);
		}
		catch(Exception $e){
			return response()->json(['success' => false, 'error' => 'server_error', 'message' => 'Something went wrong.<br />Please try again'], 500);
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		try{
			$user = Helper::isUserLoggedIn();

			if (!$user) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => "Unauthorized"], 401);
			}

			$validator = Validator::make($request->all(),[
				'address_line_1' => 'required',
				'state' => 'required',
				'city' => 'required',
				'pincode' => 'required',
			]);

			if ($validator->fails()) {
				return response()->json(['success' => false, 'error' => 'validation_error', 'message' => "Did not get proper input"]);
			}

			$address = PatientAddress::find($id);

			if (!$address) {
				return response()->json(['success' => false, 'error' => 'not_found', 'message' => 'Did not find the address you are trying to update']);
			}

			if ($address->patient_id != $user->id) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => 'You are trying to access address of another user']);
			}

			if ($request->has('address_line_1')) {
				$address->address_line_1 = $request->address_line_1;
			}
			if ($request->has('address_line_2')) {
				$address->address_line_2 = $request->address_line_2;
			}
			if ($request->has('state')) {
				$address->state = $request->state;
			}
			if ($request->has('city')) {
				$address->city = $request->city;
			}
			if ($request->has('pincode')) {
				$address->pincode = $request->pincode;
			}
			$address->save();

			$address_text = '';

			if ($address->address_line_1) {
				$address_text .= $address->address_line_1."\r\n";
			}

			if ($address->address_line_2) {
				$address_text .= $address->address_line_2."\r\n";
			}

			if ($address->state) {
				$address_text .= $address->state."\r\n";
			}

			if ($address->city) {
				$address_text .= $address->city.' - ';
			}

			if ($address->pincode) {
				$address_text .= $address->pincode."\r\n";
			}

			$address_text .= 'India';

			$return_arr = array(
				'id' => $address->id,
				'address' => nl2br($address_text),
				'address_line_1' => $address->address_line_1,
				'address_line_2' => $address->address_line_2,
				'state' => $address->state,
				'city' => $address->city,
				'pincode' => $address->pincode,
			);

			return response()->json(['success' => true, 'data' => $return_arr]);
		}
		catch(Exception $e){
			return response()->json(['success' => false, 'error' => 'server_error', 'message' => 'Something went wrong.<br />Please try again'], 500);
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

			$address = PatientAddress::find($id);

			if (!$address) {
				return response()->json(['success' => false, 'error' => 'not_found', 'message' => 'Did not find the address you are trying to update']);
			}

			if ($address->patient_id != $user->id) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => 'You are trying to access address of another user']);
			}

			$address->delete();

			return response()->json(['success' => true]);
		}
		catch(Exception $e){
			return response()->json(['success' => false, 'error' => 'server_error', 'message' => 'Something went wrong.<br />Please try again'], 500);
		}
	}
}
