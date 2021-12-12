<?php

namespace App\Http\Controllers\Api\Doctor;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\Model\UserRole;
use App\Model\Doctor\DoctorAppointments;
use App\Model\Appointment\AppointmentDetails;
use App\Model\Appointment\AppointmentCallStatus;

use App\Helpers\Helper;

use Validator;

class CallStatusController extends Controller
{
    public function update(Request $request){
    	try{
			$user = Helper::isUserLoggedIn();

			if (!$user) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => "Unauthorized"], 401);
			}

			$validator = Validator::make($request->all(),[
				'appointment_id' => 'required',
				'status' => 'required',
				'reason' => 'required',
				'details' => 'required',
			]);

			if ($validator->fails()) {
				return response()->json(array('success' => false, 'error' => 'validation_error', 'message' => "Did not get proper input"));
			}

			$appointment = DoctorAppointments::find($request->appointment_id);

			if ($appointment->doctor_id != $user->id) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => "You are trying to access appointment of another doctor"]);
			}

			$call_status = AppointmentCallStatus::where('appointment_id', $request->appointment_id)->count();

			if ($call_status > 0) {
				return respone()->json(['success' => false, 'message' => 'Appointment Status already added']);
			}

			$call_status = new AppointmentCallStatus();
			$call_status->appointment_id = $request->appointment_id;
			$call_status->status = $request->status;
			$call_status->reason = $request->reason;
			$call_status->details = $request->details;
			$call_status->user_id = $user->id;
			$call_status->save();

			// Add admin notification
			$status = ($call_status->status == 1)?'successful':'failed';

			$not_text = "Doctor marked appointment ".$appointment->shdct_appt_id.' as '.$status."\r\nReason - ".$request->reason."\r\nDetails - ".$request->details;

			$admin_user = UserRole::where('user_role', 'admin')->value('id');
			$admin_users = User::where('user_role', $admin_user)->get();
			foreach ($admin_users as $u) {
				$u->newNotification()
					->withType('CallStatusAdded')
					->withSubject('Call Status Added For Appointment '.$appointment->shdct_appt_id)
					->withBody($not_text)
					->regarding($call_status)
					->deliver();
			}

			return response()->json(['success' => true, 'message' => 'Appointment Status Saved']);
		}
		catch(Exception $e){
			return response()->json(['success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"], 500);
		}
    }
}
