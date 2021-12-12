<?php

namespace App\Http\Controllers\Api\Doctor;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\AdminSettings;

use App\Model\Doctor\DoctorTimeSlots;
use App\Model\Appointment\TempAppointment;
use App\Model\Appointment\AppointmentDetails;

use App\Model\Doctor\DoctorAppointments;

use App\Model\Doctor\DoctorSlot;

use App\Helpers\Helper;

use Carbon\Carbon;
use Config;
use DB;

class ConsultationTimeController extends Controller
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

			$id = $user->id;

			$activated_slots = array();
			$disabled_slots = array();

			$invalid_slots = array();

			$temp_bookings = TempAppointment::where('doctor_id', $id)->get();

			foreach ($temp_bookings as $slot_details) {
				if ($slot_details->status == 1) {
					$expiry = (int)$this->settings['payment_pending_booking_expiry'];
				}
				else if($slot_details->status == 0){
					$expiry = (int)$this->settings['temp_booking_expiry'];
				}
				else{
					$expiry = 15;
				}
				
				$expiry = $expiry*60;
				// 1 minute buffer
				$expiry = $expiry+60;

				$t = Carbon::parse($slot_details->updated_at)->addSeconds($expiry);
				if ($t->isPast()) {
					$slot_details->delete();
					AppointmentDetails::where('appointment_id', $slot_details->id)
										->where('appointment_type', 0)
										->delete();
					// Slot Available
					$slot_available = true;
				}
				else{
					$slot_available = false;					
				}

				if (!$slot_available) {
					array_push($invalid_slots, $slot_details->slot_id);
				}
			}

			$perm_bookings = DoctorAppointments::where('doctor_id', $id)->whereRaw('date >= curdate()')->get();

			foreach ($perm_bookings as $book) {
				$status = $book->appointmentCallStatus;
				$inv = true;
				if (!$status) {
					$inv = true;
				}
				else{
					if ($status->status == 1) {
						$inv = true;
					}
					else{
						if (strpos($status->reason, 'Cancel') === false) {
							$inv = true;
						}
						else{
							$inv = false;
						}
					}
				}
				if ($inv) {
					$timestamp = strtotime( $book->date . ' ' .$book->time_start );
					$disabled_slots[] = $timestamp;
				}
			}


			$timeslots = DoctorTimeSlots::where('doctor_id', $id)->whereRaw('date >= curdate()')->whereNotIn('id', $invalid_slots)->get();

			foreach ($timeslots as $value) {
				$timestamp = strtotime( $value->date . ' ' .$value->time_start );
				$activated_slots[] = $timestamp;  		
			}

			$timeslots = DoctorTimeSlots::where('doctor_id', $id)->whereIn('id', $invalid_slots)->whereRaw('date >= curdate()')->get();

			foreach ($timeslots as $value) {
				$timestamp = strtotime( $value->date . ' ' .$value->time_start );
				$disabled_slots[] = $timestamp;  		
			}

			$return_arr = array(
				'active' => $activated_slots,
				'disabled' => $disabled_slots
			);

			return response()->json(['success' => true, 'data' => $return_arr]);
		}
		catch(Exception $e){
			return response()->json(array('success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"));
		}
	}

	public function update(Request $request){
		try{
			$user = Helper::isUserLoggedIn();

			if (!$user) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => "Unauthorized"], 401);
			}

			$user_id = $user->id;
			$doctor_timeslots = DoctorTimeSlots::where('doctor_id', $user_id)->whereRaw('date >= curdate()')->get();
			$doctor_slots = DoctorSlot::where('doctor_id', $user_id)->first();
			//dd($doctor_slots->slot);
			$added_timeslots = array();
			$added_timeslots_ids = array();
			foreach ($doctor_timeslots as $slot) {
				$timestamp = strtotime( $slot->date . ' ' .$slot->time_start );
				array_push($added_timeslots, $timestamp);
				$added_timeslots_ids[$timestamp] = $slot->id;
			}

			$req_timeslots = $request->timeslots;

			$timeslots_to_add = array_diff($req_timeslots, $added_timeslots);
			$timeslots_to_delete = array_diff($added_timeslots, $req_timeslots);

			try{
				DB::beginTransaction();

				if (!empty($timeslots_to_delete)) {
					$ids_to_delete = array();
					foreach ($timeslots_to_delete as $value) {
						array_push($ids_to_delete, $added_timeslots_ids[$value]);
					}

					DoctorTimeSlots::whereIn('id', $ids_to_delete)->delete();
				}
				
				$insert_arr = array();

				foreach ($timeslots_to_add as $value) {
					$time = date('Y-m-d H:i:s', $value);
					$t = Carbon::parse($time);
					$arr = [
						'doctor_id' => $user_id,
						'date' => $t->toDateString(),
						'time_start' => $t->toTimeString(),
						//'time_end' => $t->addSeconds(15*60)->toTimeString();
						'time_end' => $t->addSeconds($doctor_slots->slot*60)->toTimeString()
					];
					array_push($insert_arr, $arr);
					// $ts = DoctorTimeSlots::create($arr);
				}

				// Divide into chunks of 200
				$insert_chunk = array_chunk($insert_arr, 200);

				// Insert one chunk at a time
				foreach ($insert_chunk as $chunk) {
					DoctorTimeSlots::insert($chunk);
				}

				// $ts = DoctorTimeSlots::create($insert_arr);

				DB::commit();
			}
			catch(Exception $e){
				DB::rollBack();
				return response()->json(array('success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"), 500);
			}

			return response()->json(['success' => true, 'message' => 'Time Slots Saved']);
		}
		catch(Exception $e){
			return response()->json(array('success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"));
		}
	}
}
