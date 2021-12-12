<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\Language;
use App\Model\Doctor\DoctorLanguages;

use Validator;
use Carbon\Carbon;
use DB;

class AdminLanguageController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$languages = Language::all();
		return view('admin.languages.index')
				->with('languages', $languages);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	/*public function create()
	{
		//
	}*/

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$validator = Validator::make($request->all(),[
			'language'     => 'required',
		]);

		if ($validator->fails()) {
		 return redirect('admin/languages')
					->withErrors($validator)
					->withInput();
		}

		$language = new Language();
		$language->language = $request->language;
		$language->save();

		return redirect('admin/languages');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	/*public function show($id)
	{
		//
	}*/

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	/*public function edit($id)
	{
		//
	}*/

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
			'language_new'     => 'required',
		]);

		if ($validator->fails()) {
		 return redirect('admin/languages')
					->withErrors($validator)
					->withInput();
		}

		$language = Language::find($id);
		$language->language = $request->language_new;
		$language->save();

		return redirect('admin/languages');
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
			
			$language = Language::find($id);

			// Check if any doctor associated with specialty
			$doctor_count = DoctorLanguages::where('language_id', $id)->count();
			if ($doctor_count > 0) {
				return redirect('admin/languages')->with('error', 'Cannot remove language already associated with a doctor');
			}

			$language->delete();

			DB::commit();
		}
		catch(Exception $e){
			DB::rollBack();
		}

		return redirect('admin/languages')->with('status', 'Language Deleted');
	}
}
