<?php

namespace Myaibud\Controllers\Admin;

use App\Allergy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AllergyController extends Controller
{
	public function index()
	{
		return view('admin.allergies.index');
	}
}