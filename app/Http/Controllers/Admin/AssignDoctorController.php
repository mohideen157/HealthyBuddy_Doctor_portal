<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Model\AssignDoctor;
use App\User;
use Illuminate\Http\Request;
use Validator;

class AssignDoctorController extends Controller
{
	public function index()
	{
		$doctors = User::whereUserRole(2)->get();
		$tenants = User::whereUserRole(9)->get();
		$doc_orgs = AssignDoctor::with('tenant:id,name','organisation:id,name', 'doctor:id,name')->get();
		
	 	return view('admin.assign-doctor.index', compact('doctors', 'tenants', 'doc_orgs'));	
	}

	public function store(Request $request)
	{
	 	$validator = Validator::make($request->all(), [
	 		'doctor' => 'required|exists:users,id',
	 		'tenant' => 'required|exists:users,id',
	 		'organisation' => 'required'
	 	])->validate();

	 	foreach ($request->organisation as $org) {
	 		$status = AssignDoctor::whereOrgUserId($org)->whereDoctorUserId($request->doctor)->exists();
	 		if($status){
	 			continue;
	 		}

	 		$ass_org = new AssignDoctor();
	 		$ass_org->doctor_user_id = $request->doctor;
	 		$ass_org->tenant_user_id = $request->tenant;
	 		$ass_org->org_user_id = $org;
	 		$ass_org->save();
 	 	}

 	 	alert()->success('Doctor Assigned Successfully', 'Success');
 	 	return redirect()->route('admin.assign.doctor');
	}

	public function delete(Request $request)
	{
		$status = AssignDoctor::destroy($request->id);
	 	return response()->json($status);	
	} 
}
