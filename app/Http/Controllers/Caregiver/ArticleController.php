<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\HealthTipsRequest;
use App\Model\HealthTip;
use Auth;
use Storage;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
    	$articles = HealthTip::whereUserId(Auth::id())->get();
   		return view('common.article.index', compact('articles'));
    }

    public function create(){
   		return view('common.article.create-edit');
   	}

   	public function store(HealthTipsRequest $request){
   		$new  = new HealthTip();
   		$new->title = $request->title;
   		$new->content = $request->content;
   		$new->user_id = Auth::id();

   		if($request->hasFile('image')){
   			$new->image =  Storage::disk('localroot')->put('uploads/articles', $request->file('image'));
   		}
   		$new->active = $request->active;
   		$new->save();

        alert()->success('Article Created Successfully', 'Success');
   		return redirect()->route('doctor.article');
   	}

   	public function edit($id){
   		$article = HealthTip::find($id);
   		return view('common.article.create-edit', compact('article'));
   	}

   	public function update(HealthTipsRequest $request, $id){

   		$healthTip = HealthTip::find($id);
   		$healthTip->title = $request->title;
   		$healthTip->content = $request->content;

   		if($request->hasFile('image')){
            // Delete previous image
            Storage::disk('localroot')->delete($healthTip->image);
   			$healthTip->image =  Storage::disk('localroot')->put('uploads/articles', $request->file('image'));
   		}
         elseif(empty($request->hasImage)){
            Storage::disk('localroot')->delete($healthTip->image);
            $healthTip->image = null; 
         }
         $healthTip->active = $request->active;
   		$healthTip->save();

   		alert()->success('Article Updated', 'Success');
   		return redirect()->route('doctor.article');   	
   	}


   	public function delete(Request $request){
   		$status = HealthTip::destroy($request->id);
   		return response()->json($status);
   	}
}
