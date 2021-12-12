<?php

namespace Myaibud\Controllers\API;

use Exception;
use App\Allergy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Http\Resources\AllergyListResource;

class AllergyController extends Controller
{
	public function index()
	{
		try {
			return response()->json([
				'success' => true,
				'data' => AllergyListResource::collection(Allergy::all())
			],200);	
		} catch(Exception $e) {
			return response()->json([
				'success' => false,
				'error' => '500 Server Error',
				'message' => 'Something went wrong, please try again..'
			], 500);
		}
	}

	public function search(Request $request)
	{
		$query = !empty(Input::get('query')) ? Input::get('query') :'';

		try {
			return response()->json([
				'success' => true,
				'data' => AllergyListResource::collection(Allergy::where(
					'name', 'LIKE', "%$query%")->orWhere('slug', 'LIKE', "%$query%")->get())
			],200);	
		} catch(Exception $e) {
			return response()->json([
				'success' => false,
				'error' => '500 Server Error',
				'message' => 'Something went wrong, please try again..'
			], 500);
		}
	}
}