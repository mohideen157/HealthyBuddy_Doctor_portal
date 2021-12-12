<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\Symptom;
use App\Model\SymptomSpecialty;
use App\Model\Specialty;
use App\Model\Doctor\DoctorSpecialty;
use App\Model\Doctor\DoctorSubSpecialty;

use Validator;
use Carbon\Carbon;
use DB;

class AdminSpecialtyController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$specialties_arr = array(0 => 'N.A.');
		$specialties = Specialty::where('parent', 0)->pluck('specialty', 'id')->toArray();
		$specialties_arr = $specialties_arr + $specialties;

		$specialities = Specialty::all();
		return view('admin.specialty.index')
					->with(['specialities' => $specialities, 'spec' => $specialties_arr]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$specialties_arr = array(0 => 'N.A.');
		$specialties = Specialty::where('parent', 0)->pluck('specialty', 'id')->toArray();
		$specialties_arr = $specialties_arr + $specialties;
		return view('admin.specialty.add')->with('specialties', $specialties_arr);
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
			'name'     => 'required',
			'details' => 'required',
			'image'    => 'required',
		]);

		if ($validator->fails()) {
		 return redirect('admin/specialty/create')
					->withErrors($validator)
					->withInput();
		}

		if($request->hasFile('image')) {
			$file = $request->image;
			$timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
			$image_path = $timestamp. '-' .$file->getClientOriginalName();
			$file->move(public_path().'/uploads/', $image_path);
		}

		$speciality           = new Specialty();
		$speciality->specialty     = $request->name;
		$speciality->details = $request->details;
		$speciality->image    = '/uploads/'.$image_path;

		if ($request->has('parent')) {
        	$speciality->parent = $request->parent;
        }
        else{
        	$speciality->parent = 0;
        }

		$speciality->save();

		return redirect('admin/specialty');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$speciality = Specialty::find($id);
		return view('admin.specialty.show')->with('speciality',$speciality);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$speciality = Specialty::find($id);
		$specialties_arr = array(0 => 'N.A.');
		$specialties = Specialty::where('parent', 0)->pluck('specialty', 'id')->toArray();
		$specialties_arr = $specialties_arr + $specialties;
		return view('admin.specialty.edit')->with(['speciality' => $speciality, 'specialties' => $specialties_arr]);
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
			'specialty'      => 'required',
			'details'  => 'required',
		]);

		if ($validator->fails()) {
		 return redirect('admin/specialty/create')
					->withErrors($validator)
					->withInput();
		}

		$speciality = Specialty::find($id);
		$speciality->specialty = $request->specialty;
		$speciality->details = $request->details;

		if ($request->has('parent')) {
			$speciality->parent = $request->parent;
			if ($speciality->parent != $request->parent) {
				DoctorSubSpecialty::where('specialty_id', $id)->delete();
			}
		}
		else{
			$speciality->parent = 0;
			DoctorSubSpecialty::where('specialty_id', $id)->delete();
		}
		

		if($request->hasFile('image')) {
			$file = $request->image;
			$timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
			$image_path = $timestamp. '-' .$file->getClientOriginalName();
			$file->move(public_path().'/uploads/', $image_path);
			$speciality->image = '/uploads/'.$image_path;
		}
		$speciality->save();
		return redirect('admin/specialty');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		try{
			DB::beginTransaction();
			
			$speciality = Specialty::find($id);

			// Check if any doctor associated with specialty
			$doctor_count = DoctorSpecialty::where('specialty_id', $id)->count();
			if ($doctor_count > 0) {
				return redirect('admin/specialty')->with('error', 'Cannot remove specialty already associated with a doctor');
			}

			Specialty::where('parent', $id)->update(['parent' => 0]);
			
			// Remove association with symptoms
			SymptomSpecialty::where('specialty_id', $id)->delete();

			$speciality->delete();

			DB::commit();
		}
		catch(Exception $e){
			DB::rollBack();
		}

		return redirect('admin/specialty')->with('status', 'Specialty Deleted');
	}
}
