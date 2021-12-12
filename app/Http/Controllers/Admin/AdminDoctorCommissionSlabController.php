<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\DoctorCommissionSlabs;
use App\Model\Doctor\DoctorProfile;

use Validator;
use Redirect;
use DB;

class AdminDoctorCommissionSlabController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$data = DoctorCommissionSlabs::all();

		return view('admin.fee-slabs.doctor-commission.index')->with([
			'data' => $data
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$data = $request->all();

		$validator = Validator::make($data,[
			'key'     => 'required',
			'value'    => 'required|numeric',
		]);

		if ($validator->fails()) {
		 return Redirect::back()
					->withErrors($validator)
					->withInput();
		}

		$slab = new DoctorCommissionSlabs();
		$slab->key = $data['key'];
		$slab->value = $data['value'];
		$slab->save();

		return redirect('/admin/doctor-commission-slabs')->with('status', 'Slab created');        
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$data = DoctorCommissionSlabs::find($id);

		return view('admin.fee-slabs.doctor-commission.edit')->with([
			'slab' => $data
		]);
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
		$data = $request->all();

		$validator = Validator::make($data,[
			'key'     => 'required',
			'value'    => 'required|numeric',
		]);

		if ($validator->fails()) {
		 return Redirect::back()
					->withErrors($validator)
					->withInput();
		}

		$slab = DoctorCommissionSlabs::find($id);
		$slab->key = $data['key'];
		$slab->value = $data['value'];
		$slab->save();

		return redirect('/admin/doctor-commission-slabs')->with('status', 'Slab Updated');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if ($id == 1) {
			return redirect('/admin/doctor-commission-slabs')->with('error', 'Default Slab cannot be deleted');
		}

		DoctorProfile::where('commission_slab', $id)->update(['commission_slab' => 1]);

		DoctorCommissionSlabs::find($id)->delete();

		return redirect('/admin/doctor-commission-slabs')->with('status', 'Slab Deleted');
	}
}
