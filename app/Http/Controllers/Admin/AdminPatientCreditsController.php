<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\Model\UserRole;

use App\Model\Patient\PatientCredits;
use App\Model\Patient\PatientCreditLogs;

use App\Helpers\Helper;

use Carbon\Carbon;
use Validator;
use Redirect;

class AdminPatientCreditsController extends Controller
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

	public function edit($id){
		$user = User::find($id);

		if ($user->user_role != $this->user_role) {
			return Redirect::back()->with('error', 'Patient not found');
		}

		$credits = PatientCredits::where('patient_id', $id)->first();

		if (!$credits) {
			$credits = new PatientCredits();
			$credits->patient_id = $id;
			$credits->credits = 0;
			$credits->save();
		}

		return view('admin.patients.credits.edit', [
			'credits' => $credits,
			'user' => $user
		]);
	}

	public function update(Request $request, $id){
		$user = User::find($id);

		if ($user->user_role != $this->user_role) {
			return Redirect::back()->with('error', 'Patient not found');
		}
		
		$data = $request->all();

		$validator = Validator::make($data,[
			'credits'     => 'required|numeric',
		]);

		if ($validator->fails()) {
		 return Redirect::back()
					->withErrors($validator)
					->withInput();
		}

		$add_amount = $data['credits'];

		$credits = PatientCredits::where('patient_id', $id)->first();
		if (!$credits) {
			$credits = new PatientCredits();
			$credits->patient_id = $id;
			$credits->credits = 0;
			$credits->save();
		}

		$credits->credits = $credits->credits + $add_amount;
		$credits->save();

		$credit_log = new PatientCreditLogs();
		$credit_log->patient_id = $id;
		$credit_log->remarks = "Added By SheDoctr";
		$credit_log->type = 'Credit';
		$credit_log->delta = $add_amount;
		$credit_log->transaction_date = Carbon::now()->toDateTimeString();
		$credit_log->save();

		return Redirect::back()->with('status', 'Credits added to users account');
	}

	 private function getPatientUserRole(){
		$user_role = UserRole::where('user_role', 'patient')->first();

		return $user_role->id;
	}
}
