<?php

namespace App\Http\Controllers\Api\Doctor;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Helpers\Helper;

use App\Model\Doctor\DoctorConsultationPrices;

use Validator;

class ConsultationFeesController extends Controller
{
    public function index(){
    	try{
			$user = Helper::isUserLoggedIn();

			if (!$user) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => "Unauthorized"], 401);
			}

			$prices = DoctorConsultationPrices::where('doctor_id', $user->id)->first();

            if (!$prices) {
                return response()->json(['success' => true, 'data' => array(), 'message' => 'Prices not yet added']);
            }

            $return_arr = array(
                'video_call_price' => $prices->video_call_price,
                'video_call_available' => ($prices->video_call_available?true:false),
                'voice_call_price' => $prices->voice_call_price,
                'voice_call_available' => ($prices->voice_call_available?true:false)
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

            $validator = Validator::make($request->all(),[
                'video_call_price' => 'required',
                'video_call_available' => 'required',
                'voice_call_price' => 'required',
                'voice_call_available' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'error' => 'validation_error', 'message' => "Did not get proper input"]);
            }

            $prices = DoctorConsultationPrices::where('doctor_id', $user->id)->first();

            if (!$prices) {
                $prices = new DoctorConsultationPrices();
                $prices->doctor_id = $user->id;
            }

            $prices->video_call_price = $request->video_call_price;
            $prices->video_call_available = $request->video_call_available;

            if ($prices->video_call_available == 0) {
                $prices->video_call_price = 0;
            }

            $prices->voice_call_price = $request->voice_call_price;
            $prices->voice_call_available = $request->voice_call_available;

            if ($prices->voice_call_available == 0) {
                $prices->voice_call_price = 0;
            }

            $prices->save();

            return response()->json(['success' => true, 'message' => 'Consultation Prices Updated']);
        }
        catch(Exception $e){
            return response()->json(array('success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"));
        }
    }
}
