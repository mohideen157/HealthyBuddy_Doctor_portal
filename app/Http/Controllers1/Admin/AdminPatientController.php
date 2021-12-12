<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\Model\UserRole;

use App\Helpers\Helper;

use Mail;
use Carbon\Carbon;
use Validator;

class AdminPatientController extends Controller
{
	private $user_role;

	/**
	 * Instantiate a new AdminDoctorController instance.
	 *
	 * @return void
	 */
	public function __construct(){
		$this->user_role = $this->getPatientUserRole();
	}


    public function index(){

    	$patients = User::where('user_role', $this->user_role)->get();

    	return view('admin.patients.index', [
    		'patients' => $patients
		]);
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

		$user = User::find($request->user_id);
		if (!$user) {
			return redirect('admin/patients')->with('error', 'Patient Not Found');
		}

		$user->active = 1;
		$user->save();

		return redirect('admin/patients')->with('status', 'Patient Account Activated');
    }

    public function deactivate(Request $request){
    	$validator = Validator::make($request->all(),[
			'user_id'     => 'required',
		]);

		if ($validator->fails()) {
		 return redirect('admin/doctors/inactive')
					->withErrors($validator)
					->withInput();
		}

		$user = User::find($request->user_id);
		if (!$user) {
			return redirect('admin/patients')->with('error', 'Patient Not Found');
		}

		$user->active = 0;
		$user->save();

		return redirect('admin/patients')->with('status', 'Patient Account Deactivated');
    }

    private function getPatientUserRole(){
		$user_role = UserRole::where('user_role', 'patient')->first();

		return $user_role->id;
	}
}
