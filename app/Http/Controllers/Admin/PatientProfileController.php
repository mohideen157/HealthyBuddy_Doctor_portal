<?php

namespace App\Http\Controllers\Admin;

use Alert;
use App\Http\Controllers\Controller;
use App\Model\History;
use App\User;
use Carbon\Carbon;
use DB;
use Helper;
use Illuminate\Http\Request;
use Myaibud\Models\Patient\PatientHealthProfile;

class PatientProfileController extends Controller
{
    public function index()
    {
    	$users = User::whereActive(1)
                    ->whereUserRole(4)
                    ->get();

    	return view('common.patient-profile.index', compact('users'));
    }

    public function filter_by_afib(){
        $users = Helper::filter_by_afib();
        return view('common.patient-profile.index', compact('users'));
    }

    public function filter_by_arrhythmia(){
        $users = Helper::filter_by_arrhythmia();
        return view('common.patient-profile.index', compact('users'));
    }

    public function filter_abnormal(){
        $users = Helper::filter_abnormal();
        return view('common.patient-profile.index', compact('users'));
    }
}
