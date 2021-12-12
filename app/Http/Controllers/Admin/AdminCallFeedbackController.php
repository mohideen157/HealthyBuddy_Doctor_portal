<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\Feedback;
use App\Model\CallFeedback;

use App\User;
use App\Model\UserRole;

use App\Helpers\Helper;

class AdminCallFeedbackController extends Controller
{
    public function index(){
    	$feedback = CallFeedback::all();

    	$return_arr = array();

    	foreach ($feedback as $fb) {
    		if (!array_key_exists($fb->appointment_id, $return_arr)) {
    			$return_arr[$fb->appointment_id] = array(
    				'appointment_id' => $fb->appointment->shdct_appt_id,
    				'doctor_rating' => 'N.A',
    				'patient_rating' => 'N.A'
				);
    		}

    		$user = User::find($fb->user_id);
    		$user_role = UserRole::find($user->user_role);

    		if ($user_role->user_role == 'patient') {
    			$return_arr[$fb->appointment_id]['patient_rating'] = $fb->rating;
    		}

    		if ($user_role->user_role == 'doctor') {
    			$return_arr[$fb->appointment_id]['doctor_rating'] = $fb->rating;
    		}
    	}

    	// dd($return_arr);

    	return view('admin.call-feedback.index', [
    		'feedback' => $return_arr
		]);
    }
}
