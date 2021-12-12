<?php

namespace App\Http\Controllers\Organisation;

use App\Http\Controllers\Controller;
use App\Model\History;
use App\User;
use Auth;
use Helper;
use Illuminate\Http\Request;
use Myaibud\Models\Patient\PatientHealthProfile;

class PatientProfileController extends Controller
{
    public function index()
    {
    	$users = User::whereUserRole(4)
                        ->whereActive(1)
                        ->whereOrganisationId(Auth::id())
                        ->get();

    	return view('common.patient-profile.index', compact('users'));
    }

    public function filter_by_afib(){
        $users = Helper::filter_by_afib([Auth::id()]);
        return view('common.patient-profile.index', compact('users'));
    }

    public function filter_by_arrhythmia(){
        $users = Helper::filter_by_arrhythmia([Auth::id()]);
        return view('common.patient-profile.index', compact('users'));
    }

    public function filter_abnormal(){
        $users = Helper::filter_abnormal([Auth::id()]);
        return view('common.patient-profile.index', compact('users'));
    }
}
