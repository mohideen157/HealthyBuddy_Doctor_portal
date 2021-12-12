<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\PromoCodeBanner;

use Validator;
use Redirect;

class AdminPromoCodeBannerController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$data = PromoCodeBanner::all();

		return view('admin.promo-code-banner.index')->with([
			'data' => $data
		]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('admin.promo-code-banner.add');
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
			'title' => 'required',
			'image' => 'image',
		]);

		if ($validator->fails()) {
		 return Redirect::back()
					->withErrors($validator)
					->withInput();
		}

		$banner = new PromoCodeBanner();
		$banner->title = $request->title;
		if ($request->has('content')) {
			$banner->content = $request->content;
		}

		if($request->hasFile('image')) {
			$file = $request->image;
			$timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
			$image_path = $timestamp. '-' .$file->getClientOriginalName();
			$file->move(public_path().'/uploads/', $image_path);

			$banner->image = '/uploads/'.$image_path;
		}

		if ($request->has('active')) {
			$banner->is_active = 1;
		}
		else{
			$banner->is_active = 0;
		}

		$banner->save();

		return redirect('admin/promo-code-banner')->with('status', 'Promo Code Banner Added');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$data = PromoCodeBanner::find($id);

		if ($data) {
			return view('admin.promo-code-banner.show')->with('data', $data);
		}
		else{
			return Redirect::back()->with('error', 'Did not find the promo code banner');
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$banner = PromoCodeBanner::find($id);
		if (!$banner) {
			return Redirect::back()->with('error', 'Did not find the promo code banner');
		}

		if ($banner) {
			return view('admin.promo-code-banner.edit')->with(['data' => $banner]);
		}
		else{
			return Redirect::back()->with('error', 'Did not find the promo code banner');
		}
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
		$banner = PromoCodeBanner::find($id);
		if (!$banner) {
			return Redirect::back()->with('error', 'Did not find the promo code banner');
		}

		$validator = Validator::make($request->all(),[
			'title' => 'required',
			'image' => 'image',
		]);

		if ($validator->fails()) {
		 return Redirect::back()
					->withErrors($validator)
					->withInput();
		}

		$banner->title = $request->title;
		if ($request->has('content')) {
			$banner->content = $request->content;
		}

		if($request->hasFile('image')) {
			$file = $request->image;
			$timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
			$image_path = $timestamp. '-' .$file->getClientOriginalName();
			$file->move(public_path().'/uploads/', $image_path);

			$banner->image = '/uploads/'.$image_path;
		}

		if ($request->has('active')) {
			$banner->is_active = 1;
		}
		else{
			$banner->is_active = 0;
		}

		$banner->save();

		return redirect('admin/promo-code-banner')->with('status', 'Promo Code Banner Updated');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$banner = PromoCodeBanner::find($id);
		if (!$banner) {
			return Redirect::back()->with('error', 'Did not find the promo code banner');
		}

		$banner->delete();

		return redirect('/admin/promo-code-banner')->with('status', 'Promo Code Banner Removed');
	}
}
