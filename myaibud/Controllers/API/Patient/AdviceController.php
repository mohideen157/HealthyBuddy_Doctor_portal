<?php

namespace Myaibud\Controllers\API\Patient;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdviceResource;
use App\Model\Patient\PatientAdvice;
use Auth;
use Illuminate\Http\Request;

class AdviceController extends Controller
{
	public function index(Request $request)
	{	
		$patient_advice = PatientAdvice::wherePatientId(Auth::id())
										->whereDate('created_at', $request->date)
										->get();

		return AdviceResource::collection($patient_advice)
								->additional(['success' => true ]);
	}
}