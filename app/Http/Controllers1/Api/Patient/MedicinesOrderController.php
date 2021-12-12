<?php

namespace App\Http\Controllers\Api\Patient;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\Orders\Order;
use App\Model\Orders\OrderMedicines;
use App\Model\Patient\PatientAddress;
use App\Model\UploadFile;
use App\Model\Doctor\DoctorAppointments;
use App\Model\Appointment\AppointmentPrescription;

use App\User;
use App\Model\UserRole;
use App\Model\Notification;

use App\Helpers\Helper;

use DB;
use Storage;
use File;
use Validator;
use Config;
use Carbon\Carbon;
use Mail;

class MedicinesOrderController extends Controller
{
	public function index(){
		try{
			$user = Helper::isUserLoggedIn();

			if (!$user) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => "Unauthorized"], 401);
			}

			$return_arr = array();

			$orders = Order::where('user_id', $user->id)->where('order_type', 'medicine')->orderBy('id', 'desc')->get();

			foreach ($orders as $ord) {
				$md_arr = array();

				foreach ($ord->medicines as $med) {
					$arr = array(
						'name' => $med->medicine_name,
						'type' => $med->medicine_type,
						'unit' => (int)$med->medicine_unit,
						'quantity' => (int)$med->medicine_qty,
						'note' => $med->note
					);
					array_push($md_arr, $arr);
				}

				$arr = array(
					'id' => $ord->id,
					'shdct_id' => $ord->shdct_id,
					'delivery_address' => nl2br($ord->address),
					'status' => $ord->status,
					'remarks' => $ord->remarks,
					'delivery_date' => ($ord->status == 'Delivered')?$ord->delivered_on:$ord->deliver_by,
					'order_date' => $ord->created_at->toAtomString(),
					'prescription_type' => Storage::mimeType($ord->prescription),
					'medicines' => $md_arr
				);

				array_push($return_arr, $arr);
			}

			return response()->json(['success' => true, 'data' => $return_arr]);
		}
		catch(Exception $e){
			return response()->json(['success' => false, 'error' => 'server_error', 'message' => 'Something went wrong.<br />Please try again'], 500);
		}
	}

	public function show($id){
		try{
			$user = Helper::isUserLoggedIn();

			if (!$user) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => "Unauthorized"], 401);
			}

			$return_arr = array();

			$order = Order::find($id);
			if (!$order || $order->order_type != 'medicine') {
				return response()->json(['success' => false, 'error' => 'not_found', 'message' => 'Order Not Found']);
			}

			if ($order->user_id != $user->id) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => 'You are trying to access order of another user']);
			}

			$md_arr = array();
			$i = 0;
			foreach ($order->medicines as $med) {
				$arr = array(
					'counter' => $i,
					'name' => $med->medicine_name,
					'type' => $med->medicine_type,
					'unit' => (int)$med->medicine_unit,
					'quantity' => (int)$med->medicine_qty,
					'note' => $med->note,
					'addNote' => ($med->note)?true:false
				);
				array_push($md_arr, $arr);
				$i++;
			}

			$arr = array(
				'id' => $order->id,
				'shdct_id' => $order->shdct_id,
				'delivery_address' => nl2br($order->address),
				'status' => $order->status,
				'remarks' => $order->remarks,
				'delivery_date' => ($order->status == 'Delivered')?$order->delivered_on:$order->deliver_by,
				'order_date' => $order->created_at->toAtomString(),
				'prescription_type' => Storage::mimeType($order->prescription),
				'medicines' => $md_arr
			);

			return response()->json(['success' => true, 'data' => $arr]);
		}
		catch(Exception $e){
			return response()->json(['success' => false, 'error' => 'server_error', 'message' => 'Something went wrong.<br />Please try again'], 500);			
		}
	}

	public function store(Request $request){
		try{
			$user = Helper::isUserLoggedIn();

			if (!$user) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => "Unauthorized"], 401);
			}

			// Validate
			$validator = Validator::make($request->all(),[
				/*'drugs.*.name' => 'sometimes|required',
				'drugs.*.quantity' => 'sometimes|required',
				'drugs.*.type' => 'sometimes|required',
				'drugs.*.unit' => 'sometimes|required',*/
				'address' => 'required',
				'prescription' => 'required'
			]);

			if ($validator->fails()) {
				return response()->json(['success' => false, 'error' => 'validation_error', 'message' => "Did not get proper input"]);
			}

			if ($request->prescription['type'] == 'doctor_prescription') {
				$appointment = DoctorAppointments::find($request->prescription['id']);

				if (!$appointment) {
					return response()->json(['success' => false, 'error' => 'not_found', 'message' => 'We could not find the appointment']);
				}

				if ($appointment->patient_id != $user->id) {
					return response()->json(['success' => false, 'error' => 'not_allowed', 'message' => 'Unauthorized<br />You are trying to access an appointment which belongs to other patient']);
				}

				$prescription = $appointment->appointmentPrescription;
				if (!$prescription || !$prescription->file_path || !Storage::disk('prescriptions')->has($prescription->file_path)) {
					return response()->json(['success' => false, 'error' => 'not_found', 'message' => 'Prescription Not Found']);
				}

				$prescription_file = storage_path('app/prescriptions/'.$prescription->file_path);
			}
			elseif ($request->prescription['type'] == 'upload_file') {
				$prescription = UploadFile::find($request->prescription['id']);
				if (!$prescription || !$prescription->path || !file_exists(public_path().$prescription->path)) {
					return response()->json(['success' => false, 'error' => 'not_found', 'message' => 'Prescription Not Found']);
				}

				$prescription_file = public_path().$prescription->path;
			}
			else{
				return response()->json(['success' => false, 'error' => 'validation_error', 'message' => 'Unknown Prescription Type']);
			}
			
			$extension = pathinfo($prescription_file, PATHINFO_EXTENSION);

			$address = PatientAddress::find($request->address);

			if (!$address) {
				return response()->json(['success' => false, 'error' => 'not_found', 'message' => 'Address Not Found']);
			}

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

			try{
				DB::beginTransaction();

				// Save order details
				$shedoctrid = '';
				$shedoctrid_length = Config::get('sheDoctr.db.numberLength');
				$shedoctrid = Config::get('sheDoctr.db.medicineOrderPrefix');

				$max_order_count = Order::where('order_type', 'medicine')->count();
				$max_order_count++;
				$order_id = str_pad($max_order_count, $shedoctrid_length, "0", STR_PAD_LEFT);

				$shedoctrid .= $order_id;

				$new_file = Storage::put('orders/prescription/'.$shedoctrid.'.'.$extension, file_get_contents($prescription_file));

				$prescription_path = 'orders/prescription/'.$shedoctrid.'.'.$extension;

				$order = new Order();
				$order->shdct_id = $shedoctrid;
				$order->order_type = 'medicine';
				$order->user_id = $user->id;
				$order->address = $address_text;
				$order->prescription = $prescription_path;
				$order->status = 'Pending';

				$order->save();

				foreach ($request->drugs as $drug) {
					if (array_key_exists('name', $drug) && array_key_exists('type', $drug) && array_key_exists('quantity', $drug)) {
						$order_med = new OrderMedicines();
						$order_med->order_id = $order->id;
						
						$order_med->medicine_name = $drug['name'];
						$order_med->medicine_type = $drug['type'];

						if (array_key_exists('unit', $drug)) {
							$order_med->medicine_unit = (int)$drug['unit'];
						}
						else{
							$order_med->medicine_unit = NULL;
						}

						$order_med->medicine_qty = $drug['quantity'];
						
						if (array_key_exists('note', $drug) && $drug['note'] != '') {
							$order_med->note = $drug['note'];
						}
						$order_med->save();
					}
				}

				DB::commit();
			}
			catch(Exception $e){
				DB::rollBack();
				return response()->json(array('success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"), 500);
			}

			// Send Mail To User
			$sendemail = Mail::send('emails.orderConfirmation', array('name' => $user->name, 'order_id' => $order->shdct_id, 'order_type' => 'medicine'), function ($message) use ($user)
			{
				$message->to($user->email, $user->name);
				$message->subject('SheDoctr - Medicines Order Confirmed');
			});

			// Send Mail to Admin

			$admin_user = UserRole::where('user_role', 'admin')->value('id');
			// Add Notification
			$admin_users = User::where('user_role', $admin_user)->get();
			foreach ($admin_users as $u) {
				$u->newNotification()
					->withType('MedicineOrder')
					->withSubject('Medicine Order Received')
					->withBody($user->name.' has made an order for medicines')
					->regarding($order)
					->deliver();

				// Send Mail
				$sendemail = Mail::send('emails.admin.newOrder', array('name' => $user->name, 'order_id' => $order->shdct_id, 'order_type' => 'medicine'), function ($message) use ($u)
				{
					$message->to($u->email, $u->name);
					$message->subject('SheDoctr - New Medicine Order');
				});
			}

			return response()->json(['success' => true]);
		}
		catch(Exception $e){
			return response()->json(['success' => false, 'error' => 'server_error', 'message' => 'Something went wrong.<br />Please try again'], 500);
		}
	}
}
