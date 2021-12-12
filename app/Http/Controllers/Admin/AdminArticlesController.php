<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\HealthTip;
use App\User;

use Carbon\Carbon;
use Redirect;
use Validator;

class AdminArticlesController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function inactiveArticles()
	{
		$inactive_articles = HealthTip::where('active', 0)->get();
		//dd($inactive_articles);exit;

		return view('admin.articles.inactive')
				->with('articles', $inactive_articles);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function activeArticles()
	{
		$active_articles = HealthTip::where('active', 1)->get();

		return view('admin.articles.active')
				->with('articles', $active_articles);
	}

	public function activate(Request $request){
		$validator = Validator::make($request->all(),[
			'article_id'     => 'required',
		]);

		if ($validator->fails()) {
		 return redirect('admin/articles/inactive')
					->withErrors($validator)
					->withInput();
		}

		$article = HealthTip::find($request->article_id);
		$article->active = 1;
		$article->save();

		return redirect('admin/articles/inactive');
	}

	public function deactivate(Request $request){
		$validator = Validator::make($request->all(),[
			'article_id'     => 'required',
		]);

		if ($validator->fails()) {
		 return redirect('admin/articles/inactive')
					->withErrors($validator)
					->withInput();
		}

		$article = HealthTip::find($request->article_id);
		$article->active = 0;
		$article->save();

		return redirect('admin/articles/active');
	}

	public function updateArticleImage(Request $request, $id){

		$validator = Validator::make($request->all(),[
			'file'     => 'required|image',
		]);

		if ($validator->fails()) {
		 return redirect::back()
					->withErrors($validator)
					->withInput();
		}

		$article = HealthTip::find($id);

		$doctor = User::find($article->doctor_id);

		$file = $request->file('file');

		$timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
		$image_path = $timestamp. '-' .$file->getClientOriginalName();
		$file->move(public_path().'/uploads/doctors/'.$doctor->id.'/', $image_path);

		$image = '/uploads/doctors/'.$doctor->id.'/'.$image_path;

		$article->image = $image;

		$article->save();

		return Redirect::back()->with('status', 'Image Updated');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$article = HealthTip::find($id);

		return view('admin.articles.show')
					->with('article', $article);
	}
}
