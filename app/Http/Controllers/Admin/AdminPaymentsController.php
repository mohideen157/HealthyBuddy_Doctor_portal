<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\Payments;
use App\User;
use App\Model\Doctor\DoctorProfile;

use Validator;
use Redirect;
use Carbon\Carbon;

class AdminPaymentsController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$payments = Payments::all();

		$payment_arr = array();

		foreach ($payments as $pay) {
			$doc = User::find($pay->doctor_id);

			$arr = array(
				'id' => $pay->id,
				'doctor_id' => $pay->doctor_id,
				'doctor_shdct_id' => $doc->shdct_user_id,
				'amount' => $pay->amount,
				'transaction_id' => $pay->transaction_id,
				'status' => $pay->status,
				'payment_date' => $pay->payment_date,
				'remarks' => $pay->remarks
			);

			array_push($payment_arr, $arr);
		}

		return view('admin.payments.index')->with(['payments' => $payment_arr]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(Request $request)
	{
		if (!$request->has('doctor_id')) {
			return redirect('admin/doctors/ledger')->with('error', 'Did not get the doctor you want to add payment for. Please click on the add payment button');
		}

		// $doc = User::find($request->doctor_id);

		$doctor = DoctorProfile::where('doctor_id', $request->doctor_id)->first();

		return view('admin.payments.create')->with(['doctor' => $doctor]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$validator = Validator::make($request->all(),[
			'doctor_id'     => 'required',
			'transaction_id' => 'required',
			'payment_date' => 'required|date',
			'amount' => 'required|numeric',
			'status' => 'required',
			'remarks' => 'required'
		]);

		if ($validator->fails()) {
		 return Redirect::back()
					->withErrors($validator)
					->withInput();
		}

		$payment = new Payments();
		$payment->doctor_id = $request->doctor_id;
		$payment->transaction_id = $request->transaction_id;
		$payment->payment_date = Carbon::parse($request->payment_date)->toDateString();
		$payment->amount = $request->amount;
		$payment->status = $request->status;
		$payment->remarks = $request->remarks;
		$payment->save();

		return redirect('admin/doctors/ledger')->with('status', 'Payment Added for doctor');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	/*public function show($id)
	{
		
	}*/

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$payment = Payments::find($id);

		$doc = User::find($payment->doctor_id);

		$arr = array(
			'id' => $payment->id,
			'doctor_id' => $payment->doctor_id,
			'doctor_shdct_id' => $doc->shdct_user_id,
			'amount' => $payment->amount,
			'transaction_id' => $payment->transaction_id,
			'status' => $payment->status,
			'payment_date' => $payment->payment_date,
			'remarks' => $payment->remarks
		);

		return view('admin.payments.edit')->with(['payment' => $arr]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		$validator = Validator::make($request->all(),[
			'payment_date' => 'required|date',
			'amount' => 'required|numeric',
			'status' => 'required',
			'remarks' => 'required'
		]);

		if ($validator->fails()) {
		 return Redirect::back()
					->withErrors($validator)
					->withInput();
		}

		$payment = Payments::find($id);
		$payment->payment_date = Carbon::parse($request->payment_date)->toDateString();
		$payment->amount = $request->amount;
		$payment->status = $request->status;
		$payment->remarks = $request->remarks;
		$payment->save();

		return redirect('admin/payments')->with('status', 'Payment Updated');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	/*public function destroy($id)
	{
		
	}*/
}
