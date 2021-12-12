<?php

namespace App\Http\Controllers\Api\Receptionist;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Helpers\Helper;

use App\Model\Doctor\DoctorReceptionist;


use App\Model\Doctor\DoctorSlot;

use App\Model\Doctor\DoctorTimeSlots;

use App\Model\Doctor\DoctorAppointments;

use Validator;
use Carbon\Carbon;
use DB;
use URL;
use Config;
use Exception;

class ConsultationSlotController extends Controller
{
    public function index(){
    	try{
			$user = Helper::isUserLoggedIn();

			if (!$user) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => "Unauthorized"], 401);
			}
			
			$doc_receptionist = DoctorReceptionist::where('receptionist_id', $user->id)->first();
			 $d_slots = DoctorSlot::where('doctor_id', $doc_receptionist->doctor_id)->first();
            if (!$d_slots)
                $d_slots->slot = 15;

           $slot = DB::table('doctor_slots')
            ->join('doctor_appointments', 'doctor_appointments.doctor_id', '=', 'doctor_slots.doctor_id','left')
             ->join('doctor_time_slots', 'doctor_time_slots.doctor_id', '=', 'doctor_slots.doctor_id','left')
            ->select('doctor_slots.slot', 'doctor_appointments.date', 'doctor_appointments.time_start')
            ->where('doctor_slots.doctor_id', $user->id)
             ->whereRaw('Date(doctor_time_slots.date) >= CURDATE()')
           // ->where('doctor_appointments.doctor_id', $user->id)
             ->orderBy('doctor_appointments.date', 'desc')->first();
          //  ->orderBy('doctor_time_slots.date', 'desc')->first();
           //  ->orderBy('doctor_appointments.date', 'desc');

             if (!$slot) {
                 $return_arr = array(    
                'slot' => $d_slots->slot,
                'date' => date("Y-m-d"),
                'time_start' => '',
                'overall_selected' => '',
               
            );
                return response()->json(['success' => true, 'data' => $return_arr, 'message' => 'Slots not yet added']);
            }
           
            if(is_null($slot->date))
                $slot->date = date("Y-m-d");

             $my_slot = DB::table('doctor_slots')
             ->join('doctor_time_slots', 'doctor_time_slots.doctor_id', '=', 'doctor_slots.doctor_id','left')
            ->select('doctor_time_slots.date','doctor_time_slots.time_start')
            // ->distinct()
            // ->select('doctor_time_slots.time_start')
            ->where('doctor_slots.doctor_id', $user->id)
            ->whereRaw('Date(doctor_time_slots.date) >= CURDATE()')
           //  ->orderBy('doctor_appointments.date', 'desc')->first();
            ->orderBy('doctor_time_slots.date', 'asc')
            ->groupBy('doctor_time_slots.date')->get();
	    if($slot->date < date("Y-m-d"))
                $slot->date = date("Y-m-d");
            $return_arr = array(    
                'slot' => $slot->slot,
                'date' => $slot->date,
                'time_start' => $slot->time_start,
                'overall_selected' => $my_slot,
               
            );


           // $return_arr = $slot;

            return response()->json(['success' => true, 'data' =>$return_arr]);

    	}
    	catch(Exception $e){
    		return response()->json(array('success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"));
    	}
    }

    public function min(){
        try{
            $user = Helper::isUserLoggedIn();

            if (!$user) {
                return response()->json(['success' => false, 'error' => 'auth_error', 'message' => "Unauthorized"], 401);
            }
          $doc_receptionist = DoctorReceptionist::where('receptionist_id', $user->id)->first();
			$user->id = $doc_receptionist->doctor_id;
			 
			 
           $slot = DB::table('doctor_slots')
            ->join('doctor_appointments', 'doctor_appointments.doctor_id', '=', 'doctor_slots.doctor_id','left')
             ->join('doctor_time_slots', 'doctor_time_slots.doctor_id', '=', 'doctor_slots.doctor_id','left')
            ->select('doctor_slots.slot', 'doctor_time_slots.date', 'doctor_appointments.time_start')
            ->where('doctor_slots.doctor_id', $user->id)
             ->whereRaw('Date(doctor_time_slots.date) >= CURDATE()')
           //  ->orderBy('doctor_appointments.date', 'desc')->first();
            ->orderBy('doctor_time_slots.date', 'asc')->first();
           //  ->orderBy('doctor_appointments.date', 'desc');

             if (!$slot) {
                return response()->json(['success' => true, 'data' => array(), 'message' => 'Slots not yet added']);
            }
            if(is_null($slot->date))
                $slot->date = date("Y-m-d");

             $my_slot = DB::table('doctor_slots')
             ->join('doctor_time_slots', 'doctor_time_slots.doctor_id', '=', 'doctor_slots.doctor_id','left')
            ->select('doctor_time_slots.date')
             ->distinct()
            ->where('doctor_slots.doctor_id', $user->id)
             ->whereRaw('Date(doctor_time_slots.date) >= CURDATE()')
           //  ->orderBy('doctor_appointments.date', 'desc')->first();
            ->orderBy('doctor_time_slots.date', 'asc')->get();

            $return_arr = array(    
                'slot' => $slot->slot,
                'date' => $slot->date,
                'time_start' => $slot->time_start,
                'overall_selected' => $my_slot,
               
            );

           // $return_arr = $slot;

            return response()->json(['success' => true, 'data' =>$return_arr]);

        }
        catch(Exception $e){
            return response()->json(array('success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"));
        }
    }


     public function selected(){
        try{
            $user = Helper::isUserLoggedIn();

            if (!$user) {
                return response()->json(['success' => false, 'error' => 'auth_error', 'message' => "Unauthorized"], 401);
            }
           // $slot = DoctorSlot::where('doctor_id', $user->id)->first();
           // $d_appointments = DoctorAppointments::where('doctor_id', $user->id)->first();

           $slot = DB::table('doctor_slots')
            ->join('doctor_appointments', 'doctor_appointments.doctor_id', '=', 'doctor_slots.doctor_id','left')
             ->join('doctor_time_slots', 'doctor_time_slots.doctor_id', '=', 'doctor_slots.doctor_id','left')
            ->select('doctor_slots.slot', 'doctor_time_slots.date', 'doctor_appointments.time_start')
            ->where('doctor_slots.doctor_id', $user->id)
           //  ->orderBy('doctor_appointments.date', 'desc')->first();
            ->orderBy('doctor_time_slots.date', 'desc')->first();
           //  ->orderBy('doctor_appointments.date', 'desc');

             if (!$slot) {
                return response()->json(['success' => true, 'data' => array(), 'message' => 'Slots not yet added']);
            }
            if(is_null($slot->date))
                $slot->date = date("Y-m-d");

            $return_arr = array(    
                'slot' => $slot->slot,
                'date' => $slot->date,
                'time_start' => $slot->time_start,
               
            );
           // $return_arr = $slot;

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

            $validator = Validator::make($request->all(),[
                'slot' => 'required',
               
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'error' => 'validation_error', 'message' => "Did not get proper input"]);
            }
            $doc_receptionist = DoctorReceptionist::where('receptionist_id', $user->id)->first();
	    $user->id = $doc_receptionist->doctor_id;
            $slot = DoctorSlot::where('doctor_id', $user->id)->first();

            if (!$slot) {
                $slot = new DoctorSlot();
                $slot->doctor_id = $user->id;
            }

            $slot->slot = $request->slot;


            $slot->save();

             $slot = DB::table('doctor_slots')
            ->join('doctor_appointments', 'doctor_appointments.doctor_id', '=', 'doctor_slots.doctor_id','left')
             ->join('doctor_time_slots', 'doctor_time_slots.doctor_id', '=', 'doctor_slots.doctor_id','left')
            ->select('doctor_slots.slot', 'doctor_appointments.date', 'doctor_appointments.time_start')
            ->where('doctor_slots.doctor_id', $user->id)
           // ->where('doctor_appointments.doctor_id', $user->id)
             ->orderBy('doctor_appointments.date', 'desc')->first();

             if(is_null($slot->date))
                $slot->date = date("Y-m-d");


                $delete_query = DoctorTimeSlots::where('doctor_id', $user->id)
                                            ->where('date','>=', $slot->date)
                                            ->delete();

//$slot_date = date('Y-m-d', strtotime('+1 day', strtotime($slot->date)))

          //  $bank_details = DoctotTimeSlot::where('doctor_id', $user->id)->delete();





            return response()->json(['success' => true, 'message' => 'Consultation Slot Updated']);
        }
        catch(Exception $e){
            return response()->json(array('success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"));
        }
    }
}
