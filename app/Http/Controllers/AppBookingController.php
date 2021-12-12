<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;
use App\Model\UserRole;

use App\Model\Appointment\TempAppointment;
use App\Model\Appointment\AppointmentDetails;
use App\Model\Appointment\AppointmentPatientReports;

use App\Model\Doctor\DoctorTimeSlots;
use App\Model\Doctor\DoctorSlot;
use App\Model\Doctor\DoctorAppointments;
use App\Model\Doctor\DoctorProfile;

use App\Model\UploadFile;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

use App\Helpers\Helper;

use App\Model\AdminSettings;

use Validator;
use Carbon\Carbon;
use DB;
use File;
use Storage;
use Config;
use URL;
use Mail;

class AppBookingController extends Controller
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

	public function callNow(Request $request){
		try{
			$user = Helper::isUserLoggedIn();

			if (!$user) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => "Unauthorized"], 401);
			}

			if ($user->userRole->user_role != 'patient') {
				return response()->json(['success' => false, 'error' => 'invalid_user', 'message' => 'You are not allowed to book appointments.<br />Please sign up as a patient to book an appointment']);
			}

			// Validation
			$validator = Validator::make($request->all(),[
				'doctor_id'     => 'required',
				'consultation_type' => 'required',
				'consultation_price' => 'required'
			]);

			if ($validator->fails()) {
				return response()->json(array('success' => false, 'error' => 'validation_error', 'message' => "Something went wrong.<br />Please try again"));
			}

			// Check if doctor still online
			$doc = DoctorProfile::where('doctor_id', $request->doctor_id)->first();
			if (!$doc->userData->online) {
				return response()->json(['success' => false, 'error' => 'doctor_offline', 'message' => 'Doctor is unavailable.']);
			}

			$dt = time();
$doc_timeslot1_val = DoctorTimeSlots::where('doctor_id', $request->doctor_id)->whereRaw('Date(created_at) = CURDATE()')
												 ->whereRaw('CONCAT(date, " " ,time_start) > NOW()')->orderby('date','asc')->orderby('time_start','asc')->first();
												 if(count($doc_timeslot1_val) < 1 )
												 {
												  $doc_slot = DoctorSlot::where('doctor_id', $request->doctor_id)->value('slot');
												 	if($doc_slot == '')
												    $interval=15*60;
													else
													$interval=$doc_slot*60;

												}
												else
												{
					$to_time = strtotime($doc_timeslot1_val->date.' '.$doc_timeslot1_val->time_start);
				      $from_time = strtotime($doc_timeslot1_val->date.' '.$doc_timeslot1_val->time_end);
													 $interval =  round(abs($to_time - $from_time) / 60,2)*60;
													// $dt = strtotime($doc_timeslot1_val->time_start);
												}
			$last = $dt;
			$next = $last + $interval;
			$next2 = $next + $interval;

			// $time = strftime('%H:%M:%S', $next);
			// $time2 = strftime('%H:%M:%S', $next2);
			$dt1 = Carbon::createFromTimestamp($next);
			$dt2 = Carbon::createFromTimestamp($next2);
			$current = Carbon::createFromTimestamp($dt);

		     $time = $dt1->toTimeString();
			$date = $dt1->toDateString();

		     $time2 = $dt2->toTimeString();
			$date2 = $dt2->toDateString();

			 $currenttime = $current->toTimeString();
			$currentdate = $current->toDateString();

			

			// $dt = Carbon::now();
			// $date = $dt->toDateString();

			$slot1_booked = false;
			$slot2_booked = false;

			// Check if appointment booked within next 2 slots
			  $booking1 = DoctorAppointments::where('doctor_id', $request->doctor_id)
											->where('date', $date)
										  	 ->whereBetween('time_start', [$currenttime,$time])
											->count();

			  $booking2 = DoctorAppointments::where('doctor_id', $request->doctor_id)
											->where('date', $date2)
										   ->whereBetween('time_start', [$time,$time2])
											->count();
											
										

			if ($booking1 > 0) {
				$booking1_bookings = DoctorAppointments::where('doctor_id', $request->doctor_id)
											->where('date', $date)
										  	  ->whereBetween('time_start', [$currenttime,$time])
											->get();

				foreach ($booking1_bookings as $book) {
					$status = $book->appointmentCallStatus;
					if ($status) {
						if ($status->status == 0) {
							if(strpos($status->reason, 'Cancel') === false){
								$slot1_booked = true;
								break;
							}
						}
						else{
							$slot1_booked = true;
							break;
						}
					}
					else{
						$slot1_booked = true;
						break;
					}
				}
			}

			if ($booking2 > 0) {
				$booking2_bookings = DoctorAppointments::where('doctor_id', $request->doctor_id)
											->where('date', $date2)
										  	->whereBetween('time_start', [$time,$time2])
											->get();

				foreach ($booking2_bookings as $book) {
					$status = $book->appointmentCallStatus;
					if ($status) {
						if ($status->status == 0) {
							if(strpos($status->reason, 'Cancel') === false){
								$slot2_booked = true;
								break;
							}
						}
						else{
							$slot2_booked = true;
							break;
						}
					}
					else{
						$slot2_booked = true;
						break;
					}
				}
			}

			if ($slot1_booked && $slot2_booked) {
				return response()->json(['success' => false, 'error' => 'doctor_booked', 'message' => 'Doctor has booked appointments. Please select other appointments using Book Appointment Facility']);
			}

			/*if ($booking1 > 0) {
				$slot1_booked = true;
			}
			if ($booking2 > 0) {
				$slot2_booked = true;
			}*/

			$expiry = (int)$this->settings['temp_booking_expiry'];
			$expiry_mins = $expiry;

			

			
			// Check if there is no temp appointment within next 2 slots
			 $doc_timeslot1_id = DoctorTimeSlots::where('doctor_id', $request->doctor_id)
												->where('date', $date)
												 ->whereBetween('time_start', [$currenttime,$time])
												->value('id');
												//exit;

			if ($doc_timeslot1_id) {
				$temp_booking = TempAppointment::where('slot_id', $doc_timeslot1_id)->count();

				if ($temp_booking > 0) {
					$slot_details = TempAppointment::where('slot_id', $doc_timeslot1_id)->first();

					if ($slot_details->status == 1) {
						$expiry = (int)$this->settings['payment_pending_booking_expiry'];
					}
					else if($slot_details->status == 0){
						$expiry = (int)$this->settings['temp_booking_expiry'];
					}
					else{
						$expiry = 15;
					}
					$expiry_mins = $expiry;
					
					$expiry = $expiry*60;

					$t = Carbon::parse($slot_details->updated_at);
					if ($t->isPast()) {
						$slot_details->delete();
					}
					else{
						$slot1_booked = true;
					}
				}
			}

			$doc_timeslot2_id = DoctorTimeSlots::where('doctor_id', $request->doctor_id)
												->where('date', $date2)
												 ->whereBetween('time_start', [$time,$time2])
												->value('id');

			if ($doc_timeslot2_id) {
				$temp_booking = TempAppointment::where('slot_id', $doc_timeslot2_id)->count();

				if ($temp_booking > 0) {
					$slot_details = TempAppointment::where('slot_id', $doc_timeslot2_id)->first();

					if ($slot_details->status == 1) {
						$expiry = (int)$this->settings['payment_pending_booking_expiry'];
					}
					else if($slot_details->status == 0){
						$expiry = (int)$this->settings['temp_booking_expiry'];
					}
					else{
						$expiry = 15;
					}
					$expiry_mins = $expiry;
					
					$expiry = $expiry*60;

					$t = Carbon::parse($slot_details->updated_at);
					if ($t->isPast()) {
						$slot_details->delete();
					}
					else{
						$slot2_booked = true;
					}
				}
			}

			if ($slot1_booked && $slot2_booked) {
				return response()->json(['success' => false, 'error' => 'doctor_booked', 'message' => 'Doctor has booked appointments. Please select other appointments using Book Appointment Facility']);
			}



			$slot_to_book = NULL;
			$slot_timestamp = NULL;
			//echo $slot1_booked;
			//echo $slot2_booked;
			
			// Create slot if not already added
			if (!$slot1_booked) {
		//	echo 1;
                  $doc_timeslot1_time = DoctorTimeSlots::where('doctor_id', $request->doctor_id)
												->where('date', $date)
										  	    ->whereBetween('time_start', [$currenttime,$time])
												->value('time_start');
											
					if(isset($doc_timeslot1_time))
					{
					 $time = $doc_timeslot1_time;
					
				    }
					else
					{
					//	echo 2;
				    $time11 = strtotime($time);
					$time = date("H:i:s", strtotime('-'.(($interval-600)/60).' minutes', $time11));

					 if($slot2_booked)
				    {
				    	//echo $time2;
				    	//$time11 = strtotime($time2);
				    	//$time = date("H:i:s", strtotime('-'.(($interval)/60).' minutes', $time11));
				        $time = $time2;
				    	//exit;
				    }
				    }
				   

				$t = Carbon::parse($date.' '.$time);
				$slot_timestamp = $t->timestamp;
				if (!$doc_timeslot1_id) {
					$doc_timeslot1 = new DoctorTimeSlots();
					$doc_timeslot1->doctor_id = $request->doctor_id;
					$doc_timeslot1->date = $t->toDateString();
					$doc_timeslot1->time_start = $t->toTimeString();
					$doc_timeslot1->time_end = $t->addSeconds($interval)->toTimeString();
					$doc_timeslot1->save();

					$doc_timeslot1_id = $doc_timeslot1->id;
				}

				$slot_to_book = $doc_timeslot1_id;				
			}
			else{
				 $doc_timeslot1_time2 = DoctorTimeSlots::where('doctor_id', $request->doctor_id)
												->where('date', $date)
										  	    ->whereBetween('time_start', [$time,$time2])
										->value('time_start');

								 $booking1_bookings1 = DoctorAppointments::where('doctor_id', $request->doctor_id)
											->where('date', $date)
										  	  ->whereBetween('time_start', [$currenttime,$time])
											->value('time_start');
									
				if(isset($doc_timeslot1_time2))
					$time2 = $doc_timeslot1_time2;
				else
					{
					$time11 = strtotime($time2);
					$time2 = date("H:i:s", strtotime('-'.(($interval-600)/60).' minutes', $time11));
                    }

				    if(isset($booking1_bookings1))
						{
					$time11 = strtotime($booking1_bookings1);
					$time2 = date("H:i:s", strtotime('+'.(($interval)/60).' minutes', $time11));
//echo $time2;exit;
						}
				$t = Carbon::parse($date2.' '.$time2);
				$slot_timestamp = $t->timestamp;
				if (!$doc_timeslot2_id) {
					$doc_timeslot2 = new DoctorTimeSlots();
					$doc_timeslot2->doctor_id = $request->doctor_id;
					$doc_timeslot2->date = $t->toDateString();
					$doc_timeslot2->time_start = $t->toTimeString();
					$doc_timeslot2->time_end = $t->addSeconds($interval)->toTimeString();
					$doc_timeslot2->save();

					$doc_timeslot2_id = $doc_timeslot2->id;
				}

				$slot_to_book = $doc_timeslot2_id;
			}

		//	exit;

			// Create temp appointment
			if (!$slot_to_book) {
				return response()->json(['success' => false, 'error' => 'server_error', 'message' => 'Something went wrong.<br />Please try again'], 500);
			}

			$temp_booking = new TempAppointment();
			$temp_booking->doctor_id = $request->doctor_id;
			$temp_booking->user_id = $user->id;
			$temp_booking->slot_id = $slot_to_book;
			$temp_booking->consultation_type = $request->consultation_type;
			$temp_booking->consultation_price = $request->consultation_price;
			$temp_booking->status = 0;
			$temp_booking->save();

			if (!$temp_booking->id) {
				return response()->json(array('success' => false, 'error' => 'server_error', 'message' => "Unable to create temporary booking"));
			}
			else{
				return response()->json(array('success' => true, 'data' => ['temp_slot_id' => $temp_booking->id, 'slot_timestamp' => $slot_timestamp], 'message' => "Temp Booking Created<br />Please complete the booking process in ".$expiry_mins." mins<br />Do not refresh the page"));
			}
		}
		catch(Exception $e){
			return response()->json(['success' => false, 'error' => 'server_error', 'message' => 'Something went wrong.<br />Please try again'], 500);
		}
	}

	public function checkSlotAvailabilityAndCreateTempBooking(Request $request){
		try{
			$user = JWTAuth::parseToken()->authenticate();
			
			// If not patient return
			if ($user->userRole->user_role != 'patient') {
				return response()->json(['success' => false, 'error' => 'invalid_user', 'message' => 'You are not allowed to book appointments.<br />Please sign up as a patient to book an appointment']);
			}

			// Validation
			$validator = Validator::make($request->all(),[
				'timeslot'      => 'required',
				'doctor_id'     => 'required',
				'consultation_type' => 'required',
				'consultation_price' => 'required'
			]);

			if ($validator->fails()) {
				return response()->json(array('success' => false, 'error' => 'validation_error', 'message' => "Something went wrong.<br />Please try again"));
			}

			$timeslot = $request->timeslot;
			$doctor_id = $request->doctor_id;
			$user_id = $user->id;

			$expiry = (int)$this->settings['booking_buffer'];
			$expiry = $expiry*60;

			$dt = date('Y-m-d H:i:s', $timeslot);
			$dt = Carbon::parse($dt)->subSeconds($expiry);
			if ($dt->isPast()) {
				return response()->json(array('success' => false, 'error' => 'booking_not_allowed', 'message' => "You need to book slot atleast ".$this->settings['booking_buffer']." mins before the slot time"));
			}

			$slot_available = true;

			// Find Time Slot
			$t = date('Y-m-d H:i:s', $timeslot);

			$t = Carbon::parse($t);
			$date = $t->toDateString();
			$time = $t->toTimeString();

			if ($t->isPast()) {
				return response()->json(array('success' => false, 'error' => 'slot_time_passed', 'message' => "Slot Time Passed"));
			}

			$doc_timeslot_id = DoctorTimeSlots::where('doctor_id', $doctor_id)
										->where('date', $date)
										->where('time_start', $time)
										->value('id');
			
			if (!$doc_timeslot_id || $doc_timeslot_id == NULL) {
				return response()->json(array('success' => false, 'error' => 'slot_not_found', 'message' => "Slot already booked<br />Please choose a different time slot"));
			}

			$temp_appointment_ids = TempAppointment::where('user_id', $user_id)->pluck('id');
			if ($temp_appointment_ids) {
				AppointmentDetails::whereIn('appointment_id', $temp_appointment_ids)
									->where('appointment_type', 0)
									->delete();
			}
			// Remove all temp slots for that user
			TempAppointment::where('user_id', $user_id)->delete();

			// Check Slot Availability
			$slot_in_temp = TempAppointment::where('slot_id', $doc_timeslot_id)->count();

			$expiry = (int)$this->settings['temp_booking_expiry'];
			$expiry_mins = $expiry;

			if ($slot_in_temp > 0) {
				$slot_details = TempAppointment::where('slot_id', $doc_timeslot_id)->first();

				if ($slot_details->status == 1) {
					$expiry = (int)$this->settings['payment_pending_booking_expiry'];
				}
				else if($slot_details->status == 0){
					$expiry = (int)$this->settings['temp_booking_expiry'];
				}
				else{
					$expiry = 15;
				}

				$expiry_mins = $expiry;
				
				$expiry = $expiry*60;

				$t = Carbon::parse($slot_details->updated_at)->addSeconds($expiry);
				if ($t->isPast()) {
					$slot_details->delete();
					// Slot Available
					$slot_available = true;
				}
				else{
					$slot_available = false;
				}
			}

			if (!$slot_available) {
				return response()->json(array('success' => false, 'error' => 'slot_unavailable', 'message' => "Slot already booked<br />Please choose a different time slot"));
			}

			// Create a temp booking
			$temp_booking = new TempAppointment();
			$temp_booking->doctor_id = $doctor_id;
			$temp_booking->user_id = $user_id;
			$temp_booking->slot_id = $doc_timeslot_id;
			$temp_booking->consultation_type = $request->consultation_type;
			$temp_booking->consultation_price = $request->consultation_price;
			$temp_booking->status = 0;
			$temp_booking->save();

			if (!$temp_booking->id) {
				return response()->json(array('success' => false, 'error' => 'server_error', 'message' => "Unable to create temporary booking"));
			}
			else{
				return response()->json(array('success' => true, 'data' => ['temp_slot_id' => $temp_booking->id], 'message' => "Temp Booking Created<br />Please complete the booking process in ".$expiry_mins." mins<br />Do not refresh the page"));
			}


		}
		catch(Exception $e){
			return response()->json(array('success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"), 500);
		}
	}

	public function cancelTempBooking(Request $request){
		try{
			if (!$request->has('booking_id')) {
				return response()->json(array('success' => false, 'error' => 'validation_error', 'message' => "Something went wrong.<br />Please try again"));
			}

			$user = Helper::isUserLoggedIn();

			if (!$user) {
				return response()->json(array('success' => false, 'error' => 'auth_error', 'message' => "Something went wrong.<br />Please try again"), 401);
			}

			$booking = TempAppointment::find($request->booking_id);

			if (!$booking) {
				return response()->json(array('success' => false, 'error' => 'booking_not_found', 'message' => "Something went wrong.<br />Please try again"));
			}

			if ($booking->user_id != $user->id) {
				return response()->json(array('success' => false, 'error' => 'auth_error', 'message' => "Something went wrong.<br />Please try again"), 403);
			}

			AppointmentDetails::where('appointment_id', $request->booking_id)
								->where('appointment_type', 0)
								->delete();

			$booking->delete();

			return response()->json(array('success' => true, 'message' => "Temp Booking Cancelled"));
		}
		catch(Exception $e){
			return response()->json(array('success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"), 500);
		}
	}

	public function updateTempBooking(Request $request){
		try{
			// Validation
			$validator = Validator::make($request->all(),[
				'tempBookingID'      => 'required',
				'patientType'     => 'required',
				'additionalInfo.purpose' => 'required',
				'additionalInfo.allergy' => 'required',
				'additionalInfo.medications' => 'required',
				'additionalInfo.report' => 'required',
				// 'additionalInfo.allergy_details' => 'required',
				// 'additionalInfo.medication_details' => 'required',
				// 'additionalInfo.uploadedFiles' => 'required',
				'whoIsPatient.name' => 'required',
				'whoIsPatient.blood_group' => 'required',
				'whoIsPatient.gender' => 'required',
				'whoIsPatient.weight' => 'required',
				'whoIsPatient.height_feet' => 'required',
				'whoIsPatient.height_inches' => 'required',
			]);

			if ($validator->fails()) {
				return response()->json(array('success' => false, 'error' => 'validation_error', 'message' => "Something went wrong.<br />Please try again"), 400);
			}

			$user = Helper::isUserLoggedIn();

			if (!$user) {
				return response()->json(array('success' => false, 'error' => 'auth_error', 'message' => "Something went wrong.<br />Please try again"), 401);
			}

			$booking = TempAppointment::find($request->tempBookingID);

			if (!$booking) {
				return response()->json(array('success' => false, 'error' => 'booking_not_found', 'message' => "Booking Time Expired. Please book again"));
			}

			if ($booking->user_id != $user->id) {
				return response()->json(array('success' => false, 'error' => 'user_not_authorized', 'message' => "You are not allowed to access this booking"), 403);
			}

			if ($booking->status == 1) {
				$expiry = (int)$this->settings['payment_pending_booking_expiry'];
			}
			else if($booking->status == 0){
				$expiry = (int)$this->settings['temp_booking_expiry'];
			}
			else{
				$expiry = 15;
			}
			
			$expiry = $expiry*60;

			$t = Carbon::parse($booking->updated_at)->addSeconds($expiry);
			if ($t->isPast()) {
				$booking->delete();
				return response()->json(array('success' => false, 'error' => 'booking_expired', 'message' => "Booking Time Expired. Please book again"));
			}

			$booking_date_time = Carbon::parse($booking->slotDetails->date.' '.$booking->slotDetails->time_start);

			if ($booking_date_time->isPast()) {
				$booking->delete();
				return response()->json(array('success' => false, 'error' => 'booking_expired', 'message' => "Booking Time Expired. Please book again"));
			}

			try{
				DB::beginTransaction();

				$ad = new AppointmentDetails();
				$ad->appointment_id = $booking->id;
				$ad->appointment_type = 0;
				$ad->patient_type = $request->patientType;
				$ad->patient_name = $request->whoIsPatient['name'];
				$ad->patient_gender = $request->whoIsPatient['gender'];
				$ad->patient_height_feet = $request->whoIsPatient['height_feet'];
				$ad->patient_height_inches = $request->whoIsPatient['height_inches'];
				$ad->patient_blood_group = $request->whoIsPatient['blood_group'];
				$ad->patient_weight = $request->whoIsPatient['weight'];
				$ad->patient_purpose = $request->additionalInfo['purpose'];

				if ($request->additionalInfo['allergy'] != 'no') {
					if ($request->additionalInfo['allergy_details'] != '') {
						$ad->patient_allergies = $request->additionalInfo['allergy_details'];
					}
				}

				if ($request->additionalInfo['medications'] != 'no') {
					if ($request->additionalInfo['medication_details'] != '') {
						$ad->patient_medications = $request->additionalInfo['medication_details'];
					}
				}

				$ad->save();

				  $appointment_details_id = $ad->id;

				if ($request->additionalInfo['report'] != 'no') {

					if (!empty($request->additionalInfo['uploadedFiles'])) {
						foreach ($request->additionalInfo['uploadedFiles'] as $file) {
						//print_r($file[0]);exit;
							@$upload_file = UploadFile::find($file['id']);

							if ($upload_file) {
								$main_path = 'uploads/patients/';
								$inner_path = $user->shdct_user_id.'/'.$appointment_details_id.'/'.'patient_reports/';

								$filename = basename(public_path().$upload_file->path);

								$new_path = $main_path.$inner_path.$filename;

								//The name of the directory that we need to create.
								$directoryName = public_path($main_path.$inner_path);
								 
								//Check if the directory already exists.
								if(!is_dir($directoryName)){
									//Directory does not exist, so lets create it.
									mkdir($directoryName, 0755, true);
								}
								
								if (File::copy(public_path($upload_file->path), public_path($new_path))){
									$pr = new AppointmentPatientReports();
									$pr->appointment_details_id = $appointment_details_id;
									$pr->type = $upload_file->type;
									$pr->path = '/'.$new_path;
									$pr->save();
								}
							}
						}
					}
				}

				// Change status of booking to payment pending
				$booking->status = 1;
				$booking->save();


				DB::commit();
			}
			catch(Exception $e){
				DB::rollBack();
				return response()->json(array('success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"), 500);
			}
			return response()->json(['success' => true, 'message' => 'Details Saved<br />Please make the payment to complete the booking']);
		}
		catch(Exception $e){		
			return response()->json(array('success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"), 500);
		}
	}

	public function getTempAppointmentSummary(Request $request){
		try{
			if (!$request->has('booking_id')) {
				return response()->json(array('success' => false, 'error' => 'validation_error', 'message' => "Did not get the booking id"));
			}

			$user = Helper::isUserLoggedIn();

			if (!$user) {
				return response()->json(array('success' => false, 'error' => 'auth_error', 'message' => "Unauthorized"), 401);
			}

			$booking = TempAppointment::find($request->booking_id);

			if (!$booking) {
				return response()->json(array('success' => false, 'error' => 'booking_not_found', 'message' => "We did not find a booking with the submitted id"), 404);
			}

			if ($booking->status == 0) {
				return response()->json(array('success' => false, 'error' => 'booking_not_found', 'message' => "We did not find any data for the booking id submitted"), 404);
			}

			if ($booking->user_id != $user->id) {
				return response()->json(array('success' => false, 'error' => 'user_not_authorized', 'message' => "You are not allowed to access this booking"), 403);
			}

			$doctor = $booking->doctorProfile;

			$d_education = '';
			foreach ($doctor->education as $ded) {
				$d_education .= $ded->degree.', ';
			}

			$doctor_details = array(
				'name' => 'Dr. '.$doctor->name,
				'education' => preg_replace('/, $/', '', $d_education),
				'experience' => $doctor->experience,
				'image' => URL::to('/').$doctor->userdata->profile_image,
				'specialty' => ($doctor->specialty)?$doctor->specialty->specialty->specialty:false
			);

			$slot_details = $booking->slotDetails;

			$appointment_details = array(
				'id' => $booking->id,
				'date' => $slot_details->date,
				'time' => $slot_details->time_start,
				'type' => $booking->consultation_type,
				'price' => $booking->consultation_price
			);

			$return_arr = array(
				'doctor' => $doctor_details,
				'appointment' => $appointment_details
			);

			return response()->json(['success' => true, 'data' => $return_arr, 'message' => 'Temp Appointment Summary']);
		}
		catch(Exception $e){
			return response()->json(array('success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"), 500);
		}		
	}

	public function checkTempBooking(Request $request, $id){
		try{
			$user = Helper::isUserLoggedIn();

			if (!$user) {
				return response()->json(array('success' => false, 'error' => 'auth_error', 'message' => "Something went wrong.<br />Please try again"), 401);
			}

			$booking = TempAppointment::find($id);

			if (!$booking) {
				return response()->json(array('success' => false, 'error' => 'not_found', 'message' => "Booking Time Expired. Please book again"));
			}

			if ($booking->user_id != $user->id) {
				return response()->json(array('success' => false, 'error' => 'user_not_authorized', 'message' => "You are not allowed to access this booking"), 403);
			}

			if ($booking->status == 1) {
				$expiry = (int)$this->settings['payment_pending_booking_expiry'];
			}
			else if($booking->status == 0){
				$expiry = (int)$this->settings['temp_booking_expiry'];
			}
			else{
				$expiry = 15;
			}
			
			$expiry = $expiry*60;

			$t = Carbon::parse($booking->updated_at)->addSeconds($expiry);
			if ($t->isPast()) {
				$booking->delete();
				return response()->json(array('success' => false, 'error' => 'booking_expired', 'message' => "Booking Time Expired. Please book again"));
			}

			$booking_date_time = Carbon::parse($booking->slotDetails->date.' '.$booking->slotDetails->time_start);

			if ($booking_date_time->isPast()) {
				$booking->delete();
				return response()->json(array('success' => false, 'error' => 'booking_expired', 'message' => "Booking Time Expired. Please book again"));
			}

			return response()->json(array('success' => true));
		}
		catch(Exception $e){
			return response()->json(array('success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"), 500);
		}
	}

	public function confirmBooking(Request $request){
		try{
			$user = Helper::isUserLoggedIn();

			if (!$user) {
				return response()->json(array('success' => false, 'error' => 'auth_error', 'message' => "Unauthorized"), 401);
			}

			if (!$request->has('temp_booking_id')) {
				return response()->json(['success' => false, 'error' => 'validation_error', 'message' => 'Did not get temp booking id']);
			}

			if (!$request->has('transaction_id')) {
				return response()->json(['success' => false, 'error' => 'validation_error', 'message' => 'Did not get transaction id']);
			}

			$temp_booking = TempAppointment::find($request->temp_booking_id);
			if (!$temp_booking) {
				return response()->json(['success' => false, 'error' => 'not_found', 'message' => 'Temp Booking not found']);
			}

			$shedoctrid = '';
			$shedoctrid_length = Config::get('sheDoctr.db.numberLength');

			$shedoctrid = Config::get('sheDoctr.db.appointmentPrefix');

			$max_appt_count = DoctorAppointments::count();
			$max_appt_count++;
			$appt_id = str_pad($max_appt_count, $shedoctrid_length, "0", STR_PAD_LEFT);

			$shedoctrid .= $appt_id;

			try{
				DB::beginTransaction();

				// Create Permanent Booking From temp booking
				$doc_app = new DoctorAppointments();
				$doc_app->shdct_appt_id = $shedoctrid;
				$doc_app->doctor_id = $temp_booking->doctor_id;
				$doc_app->patient_id = $temp_booking->user_id;
				$doc_app->consultation_type = $temp_booking->consultation_type;
				$doc_app->consultation_price = $temp_booking->consultation_price;
				$doc_app->date = $temp_booking->slotDetails->date;
				$doc_app->time_start = $temp_booking->slotDetails->time_start;
				$doc_app->transaction_id = $request->transaction_id;
				$doc_app->save();

				// Change status in appointment details
				$appointment_details = AppointmentDetails::where('appointment_id', $temp_booking->id)->where('appointment_type', 0)->first();
				$appointment_details->appointment_id = $doc_app->id;
				$appointment_details->appointment_type = 1;
				$appointment_details->save();

				// Remove temp booking
				$temp_booking->delete();

				// Remove Slot
				$slot = DoctorTimeSlots::find($temp_booking->slotDetails->id);
				$slot->delete();

				DB::commit();
			}
			catch(Exception $e){
				DB::rollBack();
				return response()->json(array('success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"), 500);
			}

			// Add Notification
			$du = User::find($doc_app->doctor_id);
			$pu = User::find($doc_app->patient_id);

			$doctor = DoctorProfile::where('doctor_id', $doc_app->doctor_id)->first();

			$appointment_datetime = Carbon::parse($doc_app->date.' '.$doc_app->time_start)->toDayDateTimeString();

			$data = array(
				'doctor_name' => $doctor->name,
				'patient_name' => $appointment_details->patient_name,
				'datetime' => $appointment_datetime,
				'appointment_id' => $doc_app->shdct_appt_id
			);

			// Doctor Notification
			$doctor_notification_text = $appointment_details->patient_name.' has booked an appointment for '.$appointment_datetime;
			$du->newNotification()
				->withType('NewAppointment')
				->withSubject('Patient booked an appointment')
				->withBody($doctor_notification_text)
				->regarding($doc_app)
				->deliver();

			$sendemail = Mail::send('emails.doctorNewAppointment', $data, function ($message) use ($du)
			{
				$message->to($du->email, $du->name);
				
$message->cc('appt@shedoctr.com', 'Admin');
				$message->subject('SheDoctr - New Appointment');
			});

			// Send SMS
			$msgtxt = "You have an appointment on ".$data['datetime']." with ".$data['patient_name'];

			$msgData = array(
				'recipient_no' => $du->mobile_no,
				'msgtxt' => $msgtxt
			);

			$sendsms = Helper::sendSMS($msgData);


			// Patient Notification
			$patient_notification_text = 'Your appointment '.$doc_app->shdct_appt_id.' has been confirmed for '.$appointment_datetime;
			$pu->newNotification()
				->withType('NewAppointment')
				->withSubject('Appointment Confirmed')
				->withBody($patient_notification_text)
				->regarding($doc_app)
				->deliver();			

			$sendemail = Mail::send('emails.patientApptConfirmed', $data, function ($message) use ($pu)
			{
				$message->to($pu->email, $pu->name);
				
$message->cc('appt@shedoctr.com', 'Admin');
				$message->subject('SheDoctr - Appointment Confirmed');
			});

			// Send SMS
			$msgtxt = "You appointment with Dr. ".$data['doctor_name']." has been confirmed for ".$data['datetime'];

			$msgData = array(
				'recipient_no' => $pu->mobile_no,
				'msgtxt' => $msgtxt
			);

			$sendsms = Helper::sendSMS($msgData);

			return response()->json(['success' => true]);
		}
		catch(Exception $e){
			return response()->json(array('success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"), 500);
		}
	}
}