<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\Feedback;
use App\Model\CallFeedback;

use App\Helpers\Helper;

class AdminFeedbackController extends Controller
{
    public function index(){
    	$feedback = Feedback::all();

    	return view('admin.feedback.index', [
    		'feedback' => $feedback
		]);
    }
}
