<?php

namespace App\Http\Controllers\Common;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Model\AssignDoctor;
use App\Model\History;
use App\User;
use App\Http\Traits\HhiTrait;
use App\Model\Patient\PatientHhi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Myaibud\Models\Patient\PatientHealthProfile;
use DB;
use Validator;
use App\Model\Sleep;
class PatientProfileController extends Controller
{
    use HhiTrait;
    public function show($id)
    {
          
        $user =  User::with('patientProfile')
                        ->find($id);
        $date = null;
        $synched_ids = [];
         $Sleep=Sleep::where('patient_id',$id)->latest()->first();
        //Get all nutrition data based on current date
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
            $total = 125;
            //$hhi = $this->calculate_hhi($id);
            $hhi=$this->PatientHhi($id);
            $HHI=[];
            $temp=[];
            foreach ($hhi as $key => $value) {
                
               $HHI['date'][]= date('d-m-Y',strtotime($value->date));
               $HHI['hhi'][]=$value->hhi;
               $temp[]=$value->hhi;
               $avg=array_sum($temp)/count($temp);
               $HHI['avg'][]=round($avg,2);

            }
             //dd($HHI);
            //$hhi = $this->calculate_hhi($id);
             //dd($hhi);
            // Helper to find date where User Updated its profile
            $patient_health_profile_changed_date = Helper::patient_health_profile_changed_date($id);
            $patient_history_change_date = Helper::patient_history_change_date($id);
            $nutrition_change_date = Helper::nutrition_change_date($id);
              //dd($bp);
            return view('common.patient-profile.show', compact('user', 'bp', 'arrhythmia', 'arterial_age', 'date', 'synched_ids', 'nutritions', 'afib', 'rpwv', 'patient_health_profile_changed_date', 'patient_history_change_date', 'nutrition_change_date', 'hr','HHI', 'calories','Sleep'));
        }

        alert()->error('Failed!', 'Failed to Open.', 'error');
        return back();
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

    public function hr_history(Request $request){
        $hr = Helper::get_hr($request->user_id, $request->date);
        return response()->json($hr);
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

    public function calories_history(Request $request){
        $calories = Helper::get_calories($request->user_id, $request->date);
        return response()->json($calories);   
    }

    public function PatientHhi($id)
    {
         $today=date('Y-m-d H:s:i');
         $beforeday=date('Y-m-d H:s:i',strtotime('-30 day'));
         $hhi= PatientHhi::select('id','hhi','created_at as date')->where('patient_id',$id)->whereBetween('created_at',[$beforeday,$today])->get();
         return $hhi;
    }

   public function aws_setting()
   {
       $rs=DB::table('aws_setting')->where('id',1)->get();
       $row=[];
       foreach ($rs as $key => $value) {
        $row['Aws_key']=$value->Aws_key;
        $row['Aws_Secret']=$value->Aws_Secret;
        $row['success']=true;
       }
       return response()->json([ 'data' => $row],200);
   }
 public function DeviceJson(Request $request)
   {
      $validator = Validator::make($request->all(), [
            'data' => 'required',
             
        ]);

        if($validator->fails()){
            $errors = collect($validator->messages())->flatten()->toArray();
            return response()->json(['success' => false, 'message' => 'Validation Failed', 'validation' => $errors]);
        }
        try {
             $rs=DB::table('device_data')->insert(
                ['data' => json_encode($request->data,true)]
            );
             
            return response()->json(['success' => true, 'message' => 'data save successfully']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Some thing wrong.']);
        }
   }

   public function Getdevicejson(Request $request)
   {

        try {
             $rs=DB::table('device_data')->get();
             
            return response()->json(['success' => true, 'data'=>$rs]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Some thing wrong.']);
        }
   }
}
