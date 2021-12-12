<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\Appointment\CancelFeeSlabs;

use Redirect;
use DB;
use Validator;

class AdminCancelSlabsController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$slabs = CancelFeeSlabs::all();

		$max_slab_fee = CancelFeeSlabs::max('to');

		return view('admin.fee-slabs.cancel-fee.index', [
			'slabs' => $slabs,
			'new_from' => ($max_slab_fee > 0)?$max_slab_fee+1:0
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
			'from'     => 'required|numeric',
			'to' => 'required|numeric',
			'fee'    => 'required|numeric',
		]);

		if ($validator->fails()) {
		 return Redirect::back()
					->withErrors($validator)
					->withInput();
		}

		if ($data['from'] >= $data['to']) {
			return Redirect::back()->withErrors(['from' => 'From value cannot be greater than or equal to "to" value']);
		}

		$slab = new CancelFeeSlabs();
		$slab->from = $data['from'];
		$slab->to = $data['to'];
		$slab->fee = $data['fee'];
		$slab->save();

		return redirect('/admin/cancel-fee-slabs')->with('status', 'Slab created');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$slab = CancelFeeSlabs::find($id);

		if (!$slab) {
			return Redirect::back()->with('error', 'Cancellation Fee Slab not found');
		}

		return view('admin.fee-slabs.cancel-fee.edit', [
			'slab' => $slab
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
		$slab = CancelFeeSlabs::find($id);

		if (!$slab) {
			return Redirect::back()->with('error', 'Cancellation Fee Slab not found');
		}

		$data = $request->all();

		$validator = Validator::make($data,[
			'from'     => 'required|numeric',
			'to' => 'required|numeric',
			'fee'    => 'required|numeric',
		]);

		if ($validator->fails()) {
		 return Redirect::back()
					->withErrors($validator)
					->withInput();
		}

		if ($data['from'] >= $data['to']) {
			return Redirect::back()->withErrors(['from' => 'From value cannot be greater than or equal to "to" value']);
		}

		try{
			DB::beginTransaction();

			$from = $slab->from;
			$to = $slab->to;

			if ($from != $data['from']) {
				// Change To value of prev slab to new from value - 1
				$prev_slab = CancelFeeSlabs::where('to', $from-1)->first();
				if ($prev_slab) {
					if ( ($data['from']-1) > $prev_slab->from) {
						$prev_slab->to = $data['from']-1;
					}
					else{
						return Redirect::back()->withErrors(['from' => 'This value cannot be lesser than or equal to "from" value of prev slot']);
					}

					$prev_slab->save();
				}

				$slab->from = $data['from'];
			}

			if ($to != $data['to']) {
				// Change from value of next slab to new to value - 1
				$next_slab = CancelFeeSlabs::where('from', $to+1)->first();
				if ($next_slab) {
					if ( ($data['to']+1) < $next_slab->to) {
						$next_slab->from = $data['to']+1;
					}
					else{
						return Redirect::back()->withErrors(['to' => 'This value cannot be greater than or equal to "to" value of next slot']);
					}

					$next_slab->save();
				}

				$slab->to = $data['to'];
			}

			if ($slab->fee != (int)$data['fee']) {
				$slab->fee = (int)$data['fee'];
			}
			
			$slab->save();		

			DB::commit();
		}
		catch(Exception $e){
			DB::rollback();
			return Redirect::back()->with('error', $e->getMessage());
		}

		return redirect('/admin/cancel-fee-slabs')->with('status', 'Slabs Updated');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$slab = CancelFeeSlabs::find($id);

		if (!$slab) {
			return Redirect::back()->with('error', 'Cancellation Fee Slab not found');
		}

		$from = $slab->from;
		$to = $slab->to;

		try{
			DB::beginTransaction();

			$slab->delete();

			// Change the from value of next slab to maintain consistent slabs
			$next_slab = CancelFeeSlabs::where('from', $to+1)->first();
			if ($next_slab) {
				$next_slab->from = $from;
				$next_slab->save();
			}

			DB::commit();
		}
		catch(Exception $e){
			DB::rollback();
			return Redirect::back()->with('error', $e->getMessage());
		}

		return redirect('/admin/cancel-fee-slabs')->with('status', 'Slab Removed');
	}
}
