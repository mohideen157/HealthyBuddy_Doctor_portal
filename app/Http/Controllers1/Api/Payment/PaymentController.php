<?php

namespace App\Http\Controllers\Api\Payment;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Helpers\Helper;

use Razorpay\Api\Api;

use App\User;
use App\Model\UserRole;
use App\Model\Appointment\TempAppointment;
use App\Model\Doctor\DoctorTimeSlots;
use App\Model\Doctor\DoctorAppointments;
use App\Model\Doctor\DoctorProfile;
use App\Model\Appointment\AppointmentDetails;
use App\Model\Appointment\AppointmentCallStatus;
use App\Model\User\CancelRescheduleCount;
use App\Model\Appointment\CancelFeeSlabs;
use App\Model\Appointment\RescheduleFeeSlabs;
use App\Model\Patient\PatientCredits;
use App\Model\Patient\PatientCreditLogs;
use App\Model\Payment;
use App\Model\AdminCoupan;
use App\Model\Doctor\DoctorLedger;
use App\Model\DoctorCommissionSlabs;

use DB;
use URL;
use Mail;
use Config;
use Validator;
use Carbon\Carbon;

class PaymentController extends Controller
{
	public function index(Request $request)
	{

		try{
			$user = Helper::isUserLoggedIn();

			if (!$user) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => "Unauthorized"], 401);
			}

			$user_id = $user->id;

			$validator = Validator::make($request->all(),[
				'temp_appointment_id' => 'required',
				'total_price' => 'required',
				'payable_price' => 'required',
				'credits_used' => 'required'
			]);

			if ($validator->fails()) {
				return response()->json(array('success' => false, 'error' => 'validation_error', 'message' => "Something went wrong<br />We were unable to complete your request"));
			}

			$discount = 0;
			if ($request->has('discount')) {
				$discount = $request->discount;
			}
			

			if ($request->payable_price + $request->credits_used + $discount != $request->total_price) {
				return response()->json(['success' => false, 'error' => 'data_mismatch', 'message' => 'Did not get proper data']);
			}

			// Razorpay Api Object
			$api = new Api('rzp_live_YPNLzEazu4XG5q', 'nJPmVgOlneQx4PvdOeBW88X3');

			$payment_gateway = false;
			$payment_fetch = false;
			$transaction_id = NULL;

			if ($request->payable_price > 0) {
				if (!$request->has('razorpay_payment_id')) {
					return response()->json(array('success' => false, 'error' => 'validation_error', 'message' => "Did not get payment details"));
				}

				// Fetch Payment Details from gateway
				$payment_fetch = $api->payment->fetch($request->razorpay_payment_id);

				if ($request->payable_price != $payment_fetch->amount/100) {
					return response()->json(['success' => false, 'error' => 'payment_error', 'message' => 'Price does not match details sent by the payment gateway']);
				}

				if($payment_fetch->status == "authorized"){
					$payment_gateway = true;
					$transaction_id = $request->razorpay_payment_id;
				}
				else{
					return response()->json(['success' => false, 'message' => 'Payment not authorized by bank']);
				}
			}

			$temp_booking = TempAppointment::find($request->temp_appointment_id);
			if (!$temp_booking) {
				return response()->json(['success' => false, 'error' => 'not_found', 'message' => 'Temp Booking not found']);
			}

			$shedoctrid = '';
			$shedoctrid_length = Config::get('sheDoctr.db.numberLength');

			$shedoctrid = Config::get('sheDoctr.db.appointmentPrefix');

			$max_appt_count = DoctorAppointments::max('id');
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
				$doc_app->transaction_id = $transaction_id;
				$doc_app->save();
				
				if ($doc_app->id != $max_appt_count) {
					$shedoctrid = Config::get('sheDoctr.db.appointmentPrefix');
					$appt_id = str_pad($doc_app->id, $shedoctrid_length, "0", STR_PAD_LEFT);
					$shedoctrid .= $appt_id;

					$doc_app->shdct_appt_id = $shedoctrid;
				}

				// Change status in appointment details
				$appointment_details = AppointmentDetails::where('appointment_id', $temp_booking->id)->where('appointment_type', 0)->first();
				$appointment_details->appointment_id = $doc_app->id;
				$appointment_details->appointment_type = 1;
				$appointment_details->save();

				$slot = DoctorTimeSlots::find($temp_booking->slotDetails->id);
				// Remove temp booking
				$temp_booking->delete();
				DoctorAppointments::where('id', $doc_app->id)->update(['time_end' => $slot->time_end]);

				// Remove Slot
				$slot = DoctorTimeSlots::find($temp_booking->slotDetails->id);
				$slot->delete();

				// Deduct Credits if applicable
				if ($request->credits_used > 0) {
					$debit_amount = $request->credits_used;

					$credits = PatientCredits::where('patient_id', $doc_app->patient_id)->first();
					if (!$credits) {
						throw new Exception('Patient does not have credits', 500);
					}

					$credits->credits = $credits->credits - $debit_amount;
					$credits->save();

					$credit_log = new PatientCreditLogs();
					$credit_log->patient_id = $doc_app->patient_id;
					$credit_log->remarks = "Paid towards booking Appointment ID - ".$doc_app->shdct_appt_id;
					$credit_log->type = 'Debit';
					$credit_log->delta = $debit_amount;
					$credit_log->transaction_date = Carbon::now()->toDateTimeString();
					$credit_log->save();
				}

				if ($request->total_price == $request->payable_price) {
					$payment_type = 'gateway';
				}
				else{
					if ($request->payable_price == 0) {
						$payment_type = 'credits';
					}
					else{
						$payment_type = 'partial';
					}
				}
				
				$payment = new Payment();
				$payment->appointment_id = $doc_app->id;
				$payment->total_price = $request->total_price;
				$payment->payable_price = $request->payable_price;
				$payment->credits_used = $request->credits_used;
				$payment->user_id = $user_id;

				$payment->razorpay_payment_id = NULL;
				$payment->status = 'Captured';
				$payment->response = NULL;
				$payment->coupon_code = ($request->has('coupon_code'))?$request->coupon_code:NULL;
				$payment->discount = ($request->has('discount'))?$request->discount:NULL;
				$payment->type = $payment_type;
                
				// Capture Payment if applicable
				if ($payment_gateway) {
					$capture = $api->payment->fetch($request->razorpay_payment_id)->capture(array('amount'=>$payment_fetch->amount));

					$payment->razorpay_payment_id = $payment_fetch->id;
					$payment->status = $payment_fetch->status;
					$payment->response = serialize($capture->toArray());
				}

				$payment->save();

				$doctor = DoctorProfile::where('doctor_id', $doc_app->doctor_id)->first();

				$doc_slab = $doctor->commission_slab;
				$slab = DoctorCommissionSlabs::find($doc_slab);
				if (!$slab) {
					$slab = DoctorCommissionSlabs::find(1);
				}

				if ($slab) {
					$shedct_fee = $slab->value;
				}
				else{
					$shedct_fee = (int)$this->settings['shedct_fee'];
				}

				$cp = $doc_app->consultation_price;
				$shp = ($cp * $shedct_fee)/100;
				$docp = $cp - $shp;

				$ledger = new DoctorLedger();
				$ledger->doctor_id = $doc_app->doctor_id;
				$ledger->appointment_id = $doc_app->id;
				$ledger->shedoctr_fees = $shp;
				$ledger->doctor_fees = $docp;
				$ledger->save();
				
				// Update Coupon used count
				if ($request->has('coupon_code')) {
	                $coupon = AdminCoupan::where('name',$request->coupon_code)->first();
	                $coupon->current_user = $coupon->current_user+1;
	                $coupon->save();
				}

                /* $updated_coupan_count=$coupan_count++;
				 AdminCoupan::where('name',$request->coupon_code)
                 ->update(['current_user' => $updated_coupan_count]);*/
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

			/*$sendemail = Mail::send('emails.doctorNewAppointment', $data, function ($message) use ($du)
			{
				$message->to($du->email, $du->name);
				$message->subject('SheDoctr - New Appointment');
			});*/

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
				$message->subject('SheDoctr - Appointment Confirmed');
			});

			// Send SMS
			$msgtxt = "You appointment with Dr. ".$data['doctor_name']." has been confirmed for ".$data['datetime'];

			$msgData = array(
				'recipient_no' => $pu->mobile_no,
				'msgtxt' => $msgtxt
			);

			$sendsms = Helper::sendSMS($msgData);

			return response()->json(['success' => true, 'notification_msg'=>$patient_notification_text]);			
		}
		catch(Exception $e){
			return response()->json(['success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again", 'data' => $e->getMessage()], 500);
		}
	}
	public function coupan(Request $request)
	{
		try
		{
             $coupan = AdminCoupan::where('name', $request->coupancode)->where('active',1)->first();
			if (empty($coupan)) 
			{
				 return response()->json(['success' => false,'message' => 'Invalid Coupon Code']);
			}
			else
			{
				$coupan_type=$coupan->type;
				$coupan_val =(int)$coupan->val;
				$total_user =$coupan->total_user;
				$current_user =$coupan->current_user;

                if($total_user>$current_user)
                {
                	return response()->json(['success' => true,'data'=>['type' => $coupan_type, 'val' => $coupan_val]]);	  
                }	
				else
				{
					return response()->json(['success' => false,'message' => 'Invalid Coupon Code']);
				}

			}	
		}
		catch(Exception $e){
			return response()->json(['success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again", 'data' => $e->getMessage()], 500);
		}
	}
}