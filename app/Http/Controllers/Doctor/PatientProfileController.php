<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Model\AssignDoctor;
use App\Model\History;
use App\User;
use Auth;
use Carbon\Carbon;
use Helper;
use Illuminate\Http\Request;
use Myaibud\Models\Patient\PatientHealthProfile;

class PatientProfileController extends Controller
{
    public function index()
    {
        $organisation_ids = $this->doctor_organisation();

        $users = User::whereUserRole(4)
                        ->whereActive(1)
                        ->whereIn('organisation_id', $organisation_ids)
                        ->get();

        return view('common.patient-profile.index', compact('users'));
    }

    public function filter_by_afib(){
        $users = Helper::filter_by_afib($this->doctor_organisation());
        return view('common.patient-profile.index', compact('users'));
    }

    public function filter_by_arrhythmia(){
        $users = Helper::filter_by_arrhythmia($this->doctor_organisation());
        return view('common.patient-profile.index', compact('users'));
    }

    public function filter_abnormal(){
        $users = Helper::filter_abnormal($this->doctor_organisation());
        return view('common.patient-profile.index', compact('users'));
    }

    public function doctor_organisation(){
        return AssignDoctor::where('doctor_user_id', Auth::id())
                    ->pluck('org_user_id')->toArray();
    }
}
