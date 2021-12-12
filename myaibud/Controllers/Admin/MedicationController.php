<?php

namespace Myaibud\Controllers\Admin;

use App\Allergy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MedicationController extends Controller
{
	public function index()
	{
		return view('admin.medications.index');
	}
}