<?php

namespace Myaibud\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Model\HealthTip;
use Auth;
use Illuminate\Http\Request;

class ArticleController extends Controller
{		
	public function index(){

		$health_tips = HealthTip::whereActive(1)
								->paginate(10);

		return ArticleResource::collection($health_tips)->additional([
			'success' => true
		]); 
	}
}