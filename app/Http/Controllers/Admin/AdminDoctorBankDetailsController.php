<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\Doctor\DoctorProfile;

use Crypt;

class AdminDoctorBankDetailsController extends Controller
{
    public function show($id){
    	$doctor = DoctorProfile::where('doctor_id', $id)->first();

    	return view('admin.doctors.bank-details.show')->with([
    		'doctor' => $doctor
		]);
    }
}
