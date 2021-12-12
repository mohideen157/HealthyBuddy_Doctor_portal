<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\Model\UserRole;
use App\Model\Doctor\DoctorProfile;
use App\Model\Doctor\DoctorDocuments;
use App\Model\Doctor\DoctorAppointments;
use App\Model\DoctorCommissionSlabs;

use Mail;

use App\Helpers\Helper;

use Carbon\Carbon;

use Validator;
use Redirect;

class AdminDoctorController extends Controller
{
	private $user_role;

	/**
	 * Instantiate a new AdminDoctorController instance.
	 *
	 * @return void
	 */
	public function __construct(){
		$this->user_role = $this->getDoctorUserRole();
	}

        public function appointmentslist()
        {
    	  $appointment_list = DoctorAppointments::
    	         join('appointment_details as ad', 'ad.appointment_id', '=', 'doctor_appointments.id')
                 ->join('users as u', 'doctor_appointments.patient_id', '=', 'u.id')
    	         ->join('appointment_call_status as acs', 'acs.appointment_id', '=', 'doctor_appointments.id')
    	         ->join('doctor_profile as dp', 'dp.doctor_id', '=', 'doctor_appointments.doctor_id')
                 ->orderBy('doctor_appointments.date', 'DESC')
    	         ->get();
          
    	return view('admin.doctors.appointment_list')
				->with('appointment_list', $appointment_list);         
        }
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
        public function specialty_list()
	{ 
            $doctor_specialitylist = DoctorProfile::join('users as u', 'u.id', '=', 'doctor_profile.doctor_id')
                                         ->join('doctor_specialty as ds', 'u.id', '=', 'ds.doctor_id')
                                         ->join('specialty as s', 's.id', '=', 'ds.specialty_id')	
											->get();
            
		
		return view('admin.doctors.specialitylist')
				->with('doctors', $doctor_specialitylist);
        } 
	public function inactiveDoctors()
	{
		$inactive_doctors = DoctorProfile::join('users as u', 'u.id', '=', 'doctor_profile.doctor_id')
											->where('doctor_profile.is_verified', 0)
											->orWhere('u.active', 0)
											->select('doctor_profile.*')
											->get();

		/*$inactive_doctors = User::where('user_role', $this->user_role)
									->where('active', 0)
									->get();*/


		return view('admin.doctors.inactive')
				->with('inactive_doctors', $inactive_doctors);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function activeDoctors()
	{
		$active_doctors = DoctorProfile::join('users as u', 'u.id', '=', 'doctor_profile.doctor_id')
											->where('doctor_profile.is_verified', 1)
											->where('u.active', 1)
											//->select('doctor_profile.*')
											->get();
                

										
		

               // var_dump($active_doctors);
                //var_dump(count($active_doctors));
                //exit;

		return view('admin.doctors.active')
				->with('active_doctors', $active_doctors);
	}

	public function approve(Request $request){
		$validator = Validator::make($request->all(),[
			'user_id'     => 'required',
		]);

		if ($validator->fails()) {
		 return redirect('admin/doctors/inactive')
					->withErrors($validator)
					->withInput();
		}

		$doctor = DoctorProfile::where('doctor_id', $request->user_id)->first();

		$doctor->is_verified = 1;
		$doctor->save();

		$u = User::find($request->user_id);

		// Send Mail
		$sendemail = Mail::send('emails.profileapproved', $u->toArray(), function ($message) use ($u)
		{
			$message->to($u->email, $u->name);
			$message->cc('appt@shedoctr.com', 'Admin');
			$message->subject('SheDoctr - Documents Verfied');
		});

		return redirect('admin/doctors/inactive')->with('status', 'Doctor Profile Approved');
	}

	public function activate(Request $request){
		$validator = Validator::make($request->all(),[
			'user_id'     => 'required',
		]);

		if ($validator->fails()) {
		 return redirect('admin/doctors/inactive')
					->withErrors($validator)
					->withInput();
		}

		$u = User::find($request->user_id);

		$u->active = 1;
                //echo date('d-m-Y');
                //exit();
                $u->activated_at = date('Y-m-d H:i:s');
		$u->save();

		return redirect('admin/doctors/inactive')->with('status', 'Doctor Profile Activated');
	}

	public function deactivate(Request $request){
		$validator = Validator::make($request->all(),[
			'user_id'     => 'required',
		]);

		if ($validator->fails()) {
		 return redirect('admin/doctors/active')
					->withErrors($validator)
					->withInput();
		}

		$u = User::find($request->user_id);
		//echo $request->user_id;exit;
		if (!$u) {
			return redirect('admin/doctors/active')->with('error', 'Doctor Not Found');
		}

		$appointments = DoctorAppointments::where('doctor_id', $u->id)
											->whereRaw('CONCAT(date, " " ,time_start) > NOW()')
											->count();

		if ($appointments > 0) {
			return redirect('admin/doctors/active')->with('error', 'Cannot deactivate doctor account. There are appointments pending for the doctor');
		}
		else{
			$u->active = 0;
			$u->save();
		}

		return redirect('admin/doctors/active')->with('status', 'Doctor Profile Deactivated');
	}

	public function showOnHomepage(Request $request){
		$validator = Validator::make($request->all(),[
			'profile_id'     => 'required',
		]);

		if ($validator->fails()) {
		 return redirect('admin/doctors/active')
					->withErrors($validator)
					->withInput();
		}
                 $profile = DoctorProfile::where('doctor_id', $request->profile_id)->first();
		//$profile = DoctorProfile::find($request->profile_id);
		$profile->show_on_homepage = 1;
		$profile->save();

		return redirect('admin/doctors/active')->with('status', 'Doctor Profile Added on Homepage');
	}

	public function removeFromHomepage(Request $request){
		$validator = Validator::make($request->all(),[
			'profile_id'     => 'required',
		]);
		

		if ($validator->fails()) {
		 return redirect('admin/doctors/active')
					->withErrors($validator)
					->withInput();
		}

                $profile = DoctorProfile::where('doctor_id', $request->profile_id)->first();
		//$profile = DoctorProfile::find($request->profile_id);
		$profile->show_on_homepage = 0;
		$profile->save();
		//dd($profile);exit;

		return redirect('admin/doctors/active')->with('status', 'Doctor Profile Removed From Homepage');
	}

	public function documentStatusUpdate(Request $request){
		 $validator = Validator::make($request->all(),[
			'user_id'     => 'required',
		]);

		if ($validator->fails()) {
		 return redirect('admin/doctors/inactive')
					->withErrors($validator)
					->withInput();
		}

		$document = DoctorDocuments::where('doctor_id', $request->user_id)->first();

		if ($request->has('medical_degree_verified')) {
			$document->medical_degree_verified = $request->medical_degree_verified;
			if ($request->has('reason')) {
				$document->medical_degree_reject_reason = $request->reason;
			}
		}

		if ($request->has('government_id_verified')) {
			$document->government_id_verified = $request->government_id_verified;
			if ($request->has('reason')) {
				$document->government_id_reject_reason = $request->reason;
			}
		}

		if ($request->has('medical_registration_certificate_verified')) {
			$document->medical_registration_certificate_verified = $request->medical_registration_certificate_verified;
			if ($request->has('reason')) {
				$document->medical_registration_certificate_reject_reason = $request->reason;
			}
		}


		$document->save();

		return redirect('admin/doctors/inactive')->with('status', 'Document Status Updated');
	}

	public function markPriority(Request $request){
		$validator = Validator::make($request->all(),[
			'profile_id'     => 'required',
		]);

		if ($validator->fails()) {
		 return redirect('admin/doctors/active')
					->withErrors($validator)
					->withInput();
		}

		$profile = DoctorProfile::find($request->profile_id);
		$profile->priority_doctor = 1;
		$profile->save();

		return redirect('admin/doctors/active')->with('status', 'Doctor Profile will be shown on priority');
	}

	public function unmarkPriority(Request $request){
		$validator = Validator::make($request->all(),[
			'profile_id'     => 'required',
		]);

		if ($validator->fails()) {
		 return redirect('admin/doctors/active')
					->withErrors($validator)
					->withInput();
		}

		$profile = DoctorProfile::find($request->profile_id);
		$profile->priority_doctor = 0;
		$profile->save();

		return redirect('admin/doctors/active')->with('status', 'Doctor Profile removed from priority');
	}

	public function commissionSlab($id){
		$doctor = DoctorProfile::where('doctor_id', $id)->first();

		if (!$doctor) {
			return Redirect::back()->with('error', 'Doctor Not Found');
		}

		$doctor_slabs = array();

		$doctor_commission_slabs = DoctorCommissionSlabs::all();
		foreach ($doctor_commission_slabs as $slab) {
			$doctor_slabs[$slab->id] = $slab->key.' ('.$slab->value.'%)';
		}

		return view('admin.doctor-slab-category.edit')->with([
			'doctor' => $doctor,
			'doctor_slabs' => $doctor_slabs
		]);
	}

	public function updateCommissionSlab(Request $request, $id){
		$doctor = DoctorProfile::where('doctor_id', $id)->first();

		if (!$doctor) {
			return Redirect::back()->with('error', 'Doctor Not Found');
		}

		$validator = Validator::make($request->all(),[
			'slab'     => 'required',
		]);

		if ($validator->fails()) {
		 return Redirect::back()
					->withErrors($validator)
					->withInput();
		}

		if ($doctor->commission_slab != $request->slab) {
			$doctor->commission_slab = $request->slab;
			$doctor->save();
		}

		return Redirect::back()->with('status', 'Doctor Slab Updated');
	}

	public function show($id){
		$doctor = DoctorProfile::where('doctor_id', $id)->first();

		if (!$doctor) {
			return redirect('admin/doctors/active')->with('error', 'Doctor Not Found');
		}

		return view('admin.doctors.show')->with([
			'doctor' => $doctor
		]);
	}

	private function getDoctorUserRole(){
		$user_role = UserRole::where('user_role', 'doctor')->first();

		return $user_role->id;
	}
}
