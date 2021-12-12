<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Patient\PatientAdvice;
use Illuminate\Http\Request;
use Validator;
use Auth;

class PatientAdviceController extends Controller
{
    public function store(Request $request){

    	$validator = Validator::make($request->all(),[
    		'description' => 'required',
    	]);

    	if($validator->fails()){
    		$errors = collect($validator->messages())->flatten()->toArray();
    		return response()->json(['status' => false, 'errors' => $errors]);
    	}

        $new = new PatientAdvice();
        $new->patient_id = $request->patient_id;
        $new->doctor_id = Auth::id();
        $new->type = $request->type;
        $new->description = $request->description;
        $data = $new->save();

    	if($data){
    		return response()->json(['status' => true]);
    	}
    	return response()->json(['status' => false]);
    }
}
