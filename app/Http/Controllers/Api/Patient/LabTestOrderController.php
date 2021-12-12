<?php

namespace App\Http\Controllers\Api\Patient;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\Orders\Order;
use App\Model\Orders\OrderLabTests;
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

class LabTestOrderController extends Controller
{
    public function index(){
		try{
			$user = Helper::isUserLoggedIn();

			if (!$user) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => "Unauthorized"], 401);
			}

			$return_arr = array();

			$orders = Order::where('user_id', $user->id)->where('order_type', 'lab_test')->orderBy('id', 'desc')->get();

			foreach ($orders as $ord) {
				$lt_arr = array();

				foreach ($ord->labtests as $lt) {
					$arr = array(
						'name' => $lt->test_name,
						'date' => Carbon::parse($lt->test_date)->toAtomString(),
						'time' => Carbon::parse($lt->test_time)->toAtomString(),
						'note' => $lt->note
					);
					array_push($lt_arr, $arr);
				}

				$arr = array(
					'id' => $ord->id,
					'shdct_id' => $ord->shdct_id,
					'delivery_address' => nl2br($ord->address),
					'status' => $ord->status,
					'remarks' => $ord->remarks,
					'delivery_date' => ($ord->status == 'Delivered')?$ord->delivered_on:$ord->deliver_by,
					'order_date' => $ord->created_at->toAtomString(),
					'prescription_uploaded' => ($ord->prescription)?true:false,
					'prescription_type' => ($ord->prescription)?Storage::mimeType($ord->prescription):false,
					'labTests' => $lt_arr
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
			if (!$order || $order->order_type != 'lab_test') {
				return response()->json(['success' => false, 'error' => 'not_found', 'message' => 'Order Not Found']);
			}

			if ($order->user_id != $user->id) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => 'You are trying to access order of another user']);
			}

			$lt_arr = array();
			$i = 0;
			foreach ($order->labtests as $lt) {
				$arr = array(
					'counter' => $i,
					'name' => $lt->test_name,
					'date' => Carbon::parse($lt->test_date)->toAtomString(),
					'time' => Carbon::parse($lt->test_time)->toAtomString(),
					'note' => $lt->note,
					'addNote' => ($lt->note)?true:false
				);
				array_push($lt_arr, $arr);
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
				'prescription_uploaded' => ($order->prescription)?true:false,
				'prescription_type' => ($order->prescription)?Storage::mimeType($order->prescription):false,
				'labTests' => $lt_arr
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
				'labTests.*.name' => 'required',
				'labTests.*.date' => 'required',
				'labTests.*.time' => 'required',
				'address' => 'required',
				// 'prescription' => 'required'
			]);

			if ($validator->fails()) {
				return response()->json(['success' => false, 'error' => 'validation_error', 'message' => "Did not get proper input"]);
			}

			$prescription_uploaded = false;

			if ($request->has('prescription') && array_key_exists('type', $request->prescription) && isset($request->prescription['type'])) {
				$prescription_uploaded = true;
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
			}

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
				$shedoctrid = Config::get('sheDoctr.db.labTestOrderPrefix');

				$max_order_count = Order::where('order_type', 'lab_test')->count();
				$max_order_count++;
				$order_id = str_pad($max_order_count, $shedoctrid_length, "0", STR_PAD_LEFT);

				$shedoctrid .= $order_id;

				$order = new Order();
				$order->shdct_id = $shedoctrid;
				$order->order_type = 'lab_test';
				$order->user_id = $user->id;
				$order->address = $address_text;				
				$order->prescription = NULL;
				$order->status = 'Pending';

				if ($prescription_uploaded) {
					$new_file = Storage::put('orders/prescription/'.$shedoctrid.'.'.$extension, file_get_contents($prescription_file));
					$prescription_path = 'orders/prescription/'.$shedoctrid.'.'.$extension;
					$order->prescription = $prescription_path;
				}				

				$order->save();

				foreach ($request->labTests as $lt) {
					$order_lt = new OrderLabTests();
				    $order_lt->order_id = $order->id;
					$order_lt->test_name = $lt['name'];
					$order_lt->test_date = Carbon::parse($lt['date'])->toDateString();
					$order_lt->test_time = Carbon::parse($lt['time'])->toTimeString();

					// Check if test date, time is past
					$datetime = Carbon::parse($lt['date'].' '.$lt['time']);
					if ($datetime->isPast()) {
						DB::rollBack();
						return response()->json(['success' => false, 'error' => 'validation_error', 'message' => 'One of the lab tests entered has date, time which is already passed. Please change it to a future date time']);
					}
					if (array_key_exists('note', $lt) && $lt['note'] != '') {
						$order_lt->note = $lt['note'];
					}
					
					$order_lt->save();
				}

				DB::commit();
			}
			catch(Exception $e){
				DB::rollBack();
				return response()->json(array('success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"), 500);
			}

			// Send Mail To User
			$sendemail = Mail::send('emails.orderConfirmation', array('name' => $user->name, 'order_id' => $order->shdct_id, 'order_type' => 'lab test'), function ($message) use ($user)
			{
				$message->to($user->email, $user->name);
				$message->cc('appt@shedoctr.com', 'Admin');
				$message->cc('admin@shedoctr.com', 'Admin');
				$message->subject('SheDoctr - Lab Tests Order Confirmed');
			});

			// Send Mail to Admin

			$admin_user = UserRole::where('user_role', 'admin')->value('id');
			// Add Notification
			$admin_users = User::where('user_role', $admin_user)->get();
			foreach ($admin_users as $u) {
				$u->newNotification()
					->withType('LabTestOrder')
					->withSubject('Lab Test Order Received')
					->withBody($user->name.' has made an order for lab tests')
					->regarding($order)
					->deliver();

				// Send Mail
				$sendemail = Mail::send('emails.admin.newOrder', array('name' => $user->name, 'order_id' => $order->shdct_id, 'order_type' => 'lab test'), function ($message) use ($u)
				{
					$message->to($u->email, $u->name);
					$message->subject('SheDoctr - New Lab Test Order');
				});
			}

			return response()->json(['success' => true]);
		}
		catch(Exception $e){
			return response()->json(['success' => false, 'error' => 'server_error', 'message' => 'Something went wrong.<br />Please try again'], 500);
		}
	}
}
