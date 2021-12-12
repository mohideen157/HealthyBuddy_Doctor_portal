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
		$total_users = User::where('user_role', '!=', 1)->count();

		$total_doctors = User::where('user_role', 2)->count();

		$total_patients = User::where('user_role', 4)->count();

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
