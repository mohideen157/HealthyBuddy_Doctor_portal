<?php

namespace App\Http\Controllers\Caregiver;

use App\Http\Controllers\Controller;
use App\Http\Requests\DietPlansRequest;
use App\Model\DietPlan;
use App\User;
use Auth;
use Storage;
use Illuminate\Http\Request;

class DietController extends Controller
{
    public function index()
    {
    	$articles = DietPlan::with('user')->whereUserId(Auth::id())->get();
   		return view('caregiver.diet.index', compact('articles'));
    }

    public function create(){
   		return view('caregiver.diet.create-edit');
   	}

   	public function store(DietPlansRequest $request){
   		$new  = new DietPlan();
   		$new->title = $request->title;
   		$new->content = $request->content;
   		$new->user_id = Auth::id();

   		if($request->hasFile('image')){
   			$new->image =  Storage::disk('localroot')->put('uploads/articles', $request->file('image'));
   		}
   		$new->active = $request->active;
   		$new->save();

        alert()->success('Diet Created Successfully', 'Success');
   		return redirect('caregiver/diet-plan');
   	}

   	public function edit($id){
   		$article = DietPlan::find($id);
   		return view('caregiver.diet.create-edit', compact('article'));
   	}

   	public function update(DietPlansRequest $request, $id){

   		$DietPlan = DietPlan::find($id);
   		$DietPlan->title = $request->title;
   		$DietPlan->content = $request->content;

   		if($request->hasFile('image')){
            // Delete previous image
            Storage::disk('localroot')->delete($DietPlan->image);
   			$DietPlan->image =  Storage::disk('localroot')->put('uploads/articles', $request->file('image'));
   		}
         elseif(empty($request->hasImage)){
            Storage::disk('localroot')->delete($DietPlan->image);
            $DietPlan->image = null; 
         }
         $DietPlan->active = $request->active;
   		$DietPlan->save();

   		alert()->success('Diet Plan Updated', 'Success');
		   return redirect('caregiver/diet-plan');	
   	}


   	public function delete(Request $request){
		 
   		$status = DietPlan::destroy($request->id);
   		return response()->json($status);
   	}
}
