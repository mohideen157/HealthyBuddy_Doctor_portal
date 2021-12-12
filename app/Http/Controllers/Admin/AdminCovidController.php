<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;

use App\Model\Medcheck\medcheckuserstable;
use App\Model\Symptomcheck\patientcovid19;

use App\Helpers\Helper;

use Validator;
use Carbon\Carbon;
use URL;
use DB;

class AdminCovidController extends Controller
{

public function index()
      {
        $users = patientcovid19::all();

      return view('admin.covid19.index', compact('users'));

      }
  }