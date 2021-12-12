<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Model\Expertise;
use Validator;
use Illuminate\Http\Request;

class AdminExpertiseController extends Controller
{
    public function index()
    {
    	$expertises  = Expertise::all();
    	return view('admin.expertises.index', compact('expertises'));
    }

    public function create(Request $request)
    {
    	$validator = Validator::make($request->all(), [
    		'name' => 'required|max:255|unique:expertises,name',
    	]);

    	if($validator->fails()){
    		return response()->json(false);
    	}

    	$expertise = new Expertise();
    	$expertise->name = strtolower($request->name);
    	$status = $expertise->save();

        return response()->json($status);
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'exists:expertises,id'
        ]);

        if($validator->fails()){
            return response()->json(false);
        }

        $status = Expertise::destroy($request->id);

        return response()->json($status);
    }
}
