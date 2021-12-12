<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Model\AdminSettings;

use App\Model\Doctor\DoctorTimeSlots;
use App\Model\Appointment\TempAppointment;
use App\Model\Appointment\AppointmentDetails;
use App\Model\Doctor\DoctorSlot;

use App\Helpers\Helper;

use Carbon\Carbon;
use Config;
use DB;

class AppDoctorController extends Controller
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

	public function getDoctorAvailableTimeSlots(Request $request){
		try{
			if (!$request->has('doctor_id')) {
				return response()->json(array('success' => false, 'error' => 'validation_error', 'message' => "Something went wrong.<br />Please try again"));
			}
			
			$id = $request->doctor_id;
			$return_arr = array();
			$return_arr_slots = array();

			$invalid_slots = array();

			$user = Helper::isUserLoggedIn();

			// Get Temp Bookings if valid
			$temp_bookings = TempAppointment::where('doctor_id', $id)->get();

			foreach ($temp_bookings as $slot_details) {
				if ($slot_details->status == 1) {
					$expiry =  (int)$this->settings['payment_pending_booking_expiry'];
				}
				else if($slot_details->status == 0){
					$expiry = (int)$this->settings['temp_booking_expiry'];
				}
				else{
					$expiry = 15;
				}
				
				$expiry = $expiry*60;

				$slot_available = false;

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
					if ($user) {
						if ($slot_details->user_id == $user->id) {
							$slot_available = true;
						}
					}
					else{
						$slot_available = false;
					}
				}

				if (!$slot_available) {
					array_push($invalid_slots, $slot_details->slot_id);
				}
			}
			
			

			$timeslots = DoctorTimeSlots::where('doctor_id', $id)->whereNotIn('id', $invalid_slots)->orderby('date','asc')->orderby('time_start','asc')->get();
			$expiry = (int)$this->settings['advance_booking_limit'];
			$expiry = $expiry*60;

			foreach ($timeslots as $value) {

				//$t = Carbon::parse($value->date . ' ' .$value->time_start)->subSeconds($expiry);
				$t = Carbon::parse($value->date . ' ' .$value->time_start);
				if (!$t->isPast()) {
					$timestamp = strtotime( $value->date . ' ' .$value->time_start );
					$return_arr[] = $timestamp;
					$return_date[] = $value->date;
					$return_start[] = $value->time_start;
					$return_end[] = $value->time_start;
				}    		
			}

			
         

			return response()->json(['success' => true, 'data' => ['timeslots' => $return_arr]] );
		}
		catch(Exception $e){
			return response()->json(array('success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"));
		}
		
	}
}
