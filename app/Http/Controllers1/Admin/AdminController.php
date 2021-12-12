<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\Model\Doctor\DoctorAppointments;

use App\Helpers\Helper;

class AdminController extends Controller
{
	public function index()
	{
		$admin_role = Helper::getUserRoleID('admin');

		$total_users = User::where('user_role', '!=', $admin_role)->count();

		$doctor_role = Helper::getUserRoleID('doctor');
		$total_doctors = User::where('user_role', $doctor_role)->count();

		$patient_role = Helper::getUserRoleID('patient');
		$total_patients = User::where('user_role', $patient_role)->count();

		$total_appointments = DoctorAppointments::all()->count();

		$arr = array(
			'total_users' => $total_users,
			'total_doctors' => $total_doctors,
			'total_patients' => $total_patients,
			'total_appointments' => $total_appointments
		);

		return view('admin.dashboard')->with('totals', $arr);
	}
}
