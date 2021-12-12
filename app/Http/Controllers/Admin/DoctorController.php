<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\DoctorRequest;
use App\Model\Doctor;
use App\Model\Expertise;
use App\User;
use Config;
use DB;
use Illuminate\Http\Request;
use Validator;

class DoctorController extends Controller
{
    public function index()
    {
        $users = User::with('doctor')->whereUserRole(2)->get();         
    	return view('admin.doctor.index', compact('users'));
    }

    public function create()
    {
        $expertises = Expertise::all();
    	return view('admin.doctor.create-edit', compact('expertises'));
    }

    public function store(DoctorRequest $request)
    {
        try{
            DB::beginTransaction();
             // create new tenanat with role 2
            $user = new User();
            $user->user_role = '2';  
            $user->name = $request->name;
            $user->email =  $request->email;
            $user->mobile_no = $request->mobile_no;
            $user->password = bcrypt('123456');
            $user->save();

            $user->shdct_user_id = Config::get('sheDoctr.db.doctorPrefix').$user->id;
            $user->save();

            //Create Doctor table
            $doctor = new Doctor();
            $doctor->user_id = $user->id;
            $doctor->landline = $request->landline;
            $doctor->experiance = $request->experiance;
            $doctor->current_hospital = $request->current_hospital;
            $doctor->expertise = json_encode($request->expertise);
            $doctor->address = $request->address;
            $doctor->profile_details = $request->profile_details;
            $status = $doctor->save();

            DB::commit();
            Helper::send_welcome_and_reset_password_email($user);
            alert()->success('Doctor Created Successfully', 'Success');
        }
        catch(\Exception $e){
            DB::rollback();
            alert()->error('Something Went Wrong', 'Failed');
        }
        return redirect()->route('admin.doctor');
    }

    public function edit($id)
    {
    	$user = User::with('doctor')->find($id);
        $expertises = Expertise::all();
        return view('admin.doctor.create-edit', compact('user', 'expertises'));
    }

    public function update(DoctorRequest $request, $id)
    {
        $user = User::find($id);
        if($user)
        {
            $user->name = $request->name;
            $user->email =  $request->email;
            $user->mobile_no = $request->mobile_no;
            $user->save();

            $doctor = Doctor::whereUserId($id)->first();
            $doctor->landline = $request->landline;
            $doctor->experiance = $request->experiance;
            $doctor->current_hospital = $request->current_hospital;
            $doctor->expertise = json_encode($request->expertise);
            $doctor->address = $request->address;
            $doctor->profile_details = $request->profile_details;
            $status = $doctor->save();

            alert()->success('Doctor Updated Successfully', 'Success');
        }else{
            alert()->error('Something Went Wrong', 'Failed');
        }
        return redirect()->route('admin.doctor');
    }

    public function delete(Request $request)
    {
    	$status = User::destroy($request->id);
        return response()->json($status);
    }
}
