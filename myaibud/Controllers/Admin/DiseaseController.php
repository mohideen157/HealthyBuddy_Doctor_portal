<?php

namespace Myaibud\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DiseaseController extends Controller
{
    public function index()
    {
    	return view('admin.disease.index');
    }
}
