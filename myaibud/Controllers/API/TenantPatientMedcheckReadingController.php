<?php

namespace Myaibud\Controllers\API;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use Auth;
use Config;

use App\Model\Medcheck\medcheckuser;
use App\Model\Medcheck\medcheckuserstable;
use App\Model\Medcheck\medcheckecgdata;
use App\Model\Medcheck\medcheckweightscale;
use App\Model\Medcheck\medcheckspo2;
use App\Model\Medcheck\medchecktemparature;
use App\Model\Medcheck\medcheckglucosedata;
use App\Model\Tenant\OrganisationDetail;
use App\Helpers\Helper;

use Validator;
use Carbon\Carbon;
use URL;
use DB;

class TenantPatientMedcheckReadingController extends Controller
{

      public function index()
      {
        /*$organisation = OrganisationDetail::whereParentUserId(Auth::id())->first();
        $users = medcheckuserstable::whereorganisation_id($organisation->id)->get();
        
        return view('tenant.medcheck.index', compact('users'));*/

        $organisation = OrganisationDetail::whereParentUserId(Auth::id())->first();//row
        $users = medcheckuserstable::whereorganisation_id($organisation->id)->get();
        $users2= medcheckuserstable::select('id')->where('organisation_id',$organisation->id)->get();
        
       
        $users1 = medchecktemparature::whereIn('user_id',$users2)
                                      ->where('ptt_value','>',37.50)
                                      ->get();

        $users3 = medcheckecgdata::whereIn('user_id',$users2)
                                      ->where('qtc','>',450)
                                      ->get();
        $users4 = medcheckspo2::whereIn('user_id',$users2)
                                       ->where('spo2_value','<',95)
                                       ->get();

 
        return view('tenant.medcheck.index', compact('users','users1','users2','users3','users4'));
        //return view('tenant.medcheck.index', compact('users','users1','users2'));

      }

      public function abnormal()
      {
        $organisation = OrganisationDetail::whereParentUserId(Auth::id())->first();//one row 
        $users = medcheckuserstable::whereorganisation_id($organisation->id)->get();
        $users2= medcheckuserstable::select('id')->where('organisation_id',$organisation->id)->get();
        
        $users1 = medchecktemparature::join('users', 'users.id', '=', 'patient_temparaturedata.user_id')
                                    ->select('users.*')
                                    ->whereIn('user_id',$users2)
                                     ->where('ptt_value','>',37.50)
                                     ->get();
        $users3 = medcheckecgdata::join('users', 'users.id', '=', 'patient_ecg.user_id')
                                     ->select('users.*')
                                     ->whereIn('user_id',$users2)
                                      ->where('qtc','>',450)
                                      ->get();
        $users4 = medcheckspo2::join('users', 'users.id', '=', 'patient_spo2.user_id')
                                     ->select('users.*')
                                     ->whereIn('user_id',$users2)
                                      ->where('spo2_value','<',95)
                                      ->get();
        //return view('tenant.medcheck.abnormal', compact('users','users1')); 
        return view('tenant.medcheck.abnormal', compact('users','users1','users2','users3','users4'));   
      }

      public function abnormalecg()
      {
        $organisation = OrganisationDetail::whereParentUserId(Auth::id())->first();//one row 
        $users = medcheckuserstable::whereorganisation_id($organisation->id)->get();
        $users2= medcheckuserstable::select('id')->where('organisation_id',$organisation->id)->get();
        
        $users1 = medchecktemparature::join('users', 'users.id', '=', 'patient_temparaturedata.user_id')
                                    ->select('users.*')
                                    ->whereIn('user_id',$users2)
                                     ->where('ptt_value','>',37.50)
                                     ->get();
     
     
        $users3 = medcheckecgdata::join('users', 'users.id', '=', 'patient_ecg.user_id')
                                    ->select('users.*')
                                    ->whereIn('user_id',$users2)
                                     ->where('qtc','>',450)
                                     ->get();
        $users4 = medcheckspo2::join('users', 'users.id', '=', 'patient_spo2.user_id')
                                    ->select('users.*')
                                    ->whereIn('user_id',$users2)
                                     ->where('spo2_value','<',95)
                                     ->get();

        return view('tenant.medcheck.abnormalecg', compact('users','users1','users2','users3','users4'));  
      }

      public function abnormalspo2()
      {
        $organisation = OrganisationDetail::whereParentUserId(Auth::id())->first();//one row 
        $users = medcheckuserstable::whereorganisation_id($organisation->id)->get();
        $users2= medcheckuserstable::select('id')->where('organisation_id',$organisation->id)->get();
        
        $users1 = medchecktemparature::join('users', 'users.id', '=', 'patient_temparaturedata.user_id')
                                    ->select('users.*')
                                    ->whereIn('user_id',$users2)
                                     ->where('ptt_value','>',37.50)
                                     ->get();
    
     
        $users3 = medcheckecgdata::join('users', 'users.id', '=', 'patient_ecg.user_id')
                                    ->select('users.*')
                                    ->whereIn('user_id',$users2)
                                     ->where('qtc','>',450)
                                     ->get();
        $users4 = medcheckspo2::join('users', 'users.id', '=', 'patient_spo2.user_id')
                                    ->select('users.*')
                                    ->whereIn('user_id',$users2)
                                     ->where('spo2_value','<',95)
                                     ->get();


       
        
        return view('tenant.medcheck.abnormalspo2', compact('users','users1','users2','users3','users4'));  
      }

      public function show($tenant_name, $id)
      {
      	//$data = History::whereUserId($id)
          //              ->orderByDesc('date')
            //            ->first();
      	$user = medcheckuserstable::whereid($id)->first();
        
      	$bp = medcheckuser::whereuser_id($id)
      	                      ->orderByDesc('device_reading_time')
      	                      ->first();

        $hr = medcheckecgdata::whereuser_id($id)
                                   ->orderByDesc('device_reading_time')
                                   ->first();
        $bgm = medcheckglucosedata::whereuser_id($id)
                                     ->orderByDesc('device_reading_time')
                                     ->first();
        $spo2 = medcheckspo2::whereuser_id($id)
                              ->orderByDesc('device_reading_time')
                              ->first();
        $temperature = medchecktemparature::whereuser_id($id)
                                     ->orderByDesc('device_reading_time')
                                     ->first();
        $weightscale = medcheckweightscale::whereuser_id($id)
                                     ->orderByDesc('device_reading_time')
                                     ->first();

       // $user = medcheckuserstable::with('medcheck')->find($id);

        return view('tenant.medcheck.show', compact('user','bp','hr','bgm','spo2','temperature','weightscale'));
  
      }
      public function store($tenant_name, $id)
      {
        $user = medcheckuserstable::whereid($id)->first();
        
        $bp = medcheckuser::whereuser_id($id)
                              ->orderByDesc('device_reading_time')
                              ->first();

        $hr = medcheckecgdata::whereuser_id($id)
                                   ->orderByDesc('device_reading_time')
                                   ->first();
        $bgm = medcheckglucosedata::whereuser_id($id)
                                     ->orderByDesc('device_reading_time')
                                     ->first();
        $spo2 = medcheckspo2::whereuser_id($id)
                              ->orderByDesc('device_reading_time')
                              ->first();
        $temperature = medchecktemparature::whereuser_id($id)
                                     ->orderByDesc('device_reading_time')
                                     ->first();
        $weightscale = medcheckweightscale::whereuser_id($id)
                                     ->orderByDesc('device_reading_time')
                                     ->first();


      	$bp1 = medcheckuser::whereuser_id($id)
                                      ->orderByDesc('device_reading_time')
                                      ->get();
      	                  
      	                      
        $hr1 = medcheckecgdata::whereuser_id($id)
                                         ->orderByDesc('device_reading_time')
                                         ->get();
                                   
                                   
        $bgm1 = medcheckglucosedata::whereuser_id($id)
                                               ->orderByDesc('device_reading_time')
                                               ->get();
                                     
                                     
        $spo21 = medcheckspo2::whereuser_id($id)
                                         ->orderByDesc('device_reading_time')
                                         ->get();
                              
                              
        $temperature1 = medchecktemparature::whereuser_id($id)
                                                       ->orderByDesc('device_reading_time')
                                                       ->get();
                                     
        $weightscale1 = medcheckweightscale::whereuser_id($id)
                                                        ->orderByDesc('device_reading_time')
                                                        ->get();
                                     
         return view('tenant.medcheck.store', compact('user','bp','hr','bgm','spo2','temperature','weightscale','bp1','hr1','bgm1','spo21','temperature1','weightscale1'));
  

      }
  }













































