<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Model\AssignDoctor;
use App\Model\History;
use App\Model\Tenant\OrganisationDetail;
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
        $organisation_ids = $this->tenant_organisation();

    	$users = User::whereUserRole(4)
                        ->whereActive(1)
                        ->whereIn('organisation_id', $organisation_ids)
                        ->get();
                        
    	return view('common.patient-profile.index', compact('users'));
    }

    public function show($tenant_name, $id)
    {
    	$user =  User::with('patientProfile')
                        ->find($id);

        $date = null;
        $synched_ids = [];

        // Get All Active Nutrition
        $nutritions = PatientHealthProfile::select('extra_info')
                                        ->where('patient_id', $id)
                                        ->where('parent_key', 'nutrition')
                                        ->where('value', Carbon::today()->toDateString())
                                        ->get();

        $nutritions = $nutritions->map(function($nutrition){
            $nutrition = json_decode($nutrition->extra_info, true);
            return $nutrition;
        });

        // Get all Sync Id of the User
        $data = History::whereUserId($id)
                        ->orderByDesc('date')
                        ->first();

        if($data){
            array_push($synched_ids, $data->synched);
        }

        if($user)
        {
            $bp = Helper::get_bp($id);
            $arrhythmia = Helper::get_arrhythmia($id);
            $arterial_age = Helper::get_arterial_age($id);
            $afib = Helper::get_afib($id);
            $rpwv = Helper::get_rpwv($id);
            $hr = Helper::get_hr($id);
            $calories = Helper::get_calories($id);

            // Helper to find date where User Updated its profile
            $patient_health_profile_changed_date = Helper::patient_health_profile_changed_date($id);
            $patient_history_change_date = Helper::patient_history_change_date($id);
            $nutrition_change_date = Helper::nutrition_change_date($id);

            return view('common.patient-profile.show', compact('user', 'bp', 'arrhythmia', 'arterial_age', 'date', 'synched_ids', 'nutritions', 'afib', 'rpwv', 'patient_health_profile_changed_date', 'patient_history_change_date', 'nutrition_change_date','hr','calories'));
        }

        alert()->error('Failed!', 'Failed to Open.', 'error');
        return back();
    }
    public function filter_by_afib(){
        $users = Helper::filter_by_afib($this->tenant_organisation());
        return view('common.patient-profile.index', compact('users'));
    }

    public function filter_by_arrhythmia(){
        $users = Helper::filter_by_arrhythmia($this->tenant_organisation());
        return view('common.patient-profile.index', compact('users'));
    }

    public function filter_abnormal(){
        $users = Helper::filter_abnormal($this->tenant_organisation());
        return view('common.patient-profile.index', compact('users'));
    }

    public function additional_info_history(Request $request){
        $user = User::find($request->user_id);
        $date = $request->date;
        $additional_info = view('common.patient-profile.additional-info', compact('user', 'date'))->render();
        return response()->json($additional_info);
    }

    public function nutrition_history(Request $request){
        $nutritions = PatientHealthProfile::select('extra_info')
                                        ->where('patient_id', $request->user_id)
                                        ->where('parent_key', 'nutrition')
                                        ->where('value', $request->date)
                                        ->get();

        $nutritions = $nutritions->map(function($nutrition){
            $nutrition = json_decode($nutrition->extra_info, true);
            return $nutrition;
        });

        $nutrition = view('common.patient-profile.nutrition', ['nutritions' => $nutritions])->render();
        return response()->json($nutrition);
    }

    public function ecg_ppg_history(Request $request){

        $synched_ids = [];
        $date = $request->date;
        $data = History::whereUserId($request->user_id)
                        ->when(!is_null($date), function($query) use ($date){
                            $query->whereDate('date', $date);
                        })
                        ->pluck('synched')
                        ->toArray();

        $data = view('common.patient-profile.ecg-ppg', ['synched_ids' => $data])->render();
        return response()->json($data);
    }

    public function bp_history(Request $request){
        $bp = Helper::get_bp($request->user_id, $request->date);
        return response()->json($bp);
    }

    public function arrhythmia_history(Request $request){
        $arrhythmia = Helper::get_arrhythmia($request->user_id, $request->date);
        return response()->json($arrhythmia);
    }

    public function arterial_history(Request $request){
        $arterial_age = Helper::get_arterial_age($request->user_id, $request->date);
        return response()->json($arterial_age);

    }

    public function afib_history(Request $request){
        $afib = Helper::get_afib($request->user_id, $request->date);
        return response()->json($afib);
        
    }

    public function rpwv_history(Request $request){
        $rpwv = Helper::get_rpwv($request->user_id, $request->date);
        return response()->json($rpwv); 
    }

    public function hr_history(Request $request){
        $hr = Helper::get_hr($request->user_id, $request->date);
        return response()->json($hr);
    }
    
    public function tenant_organisation(){
        $organisation_ids = OrganisationDetail::whereParentUserId(Auth::id())
                                                ->pluck('user_id')
                                                ->toArray();
        return $organisation_ids;
    }
}
