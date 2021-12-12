<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;

use App\Model\Medcheck\medcheckuser;
use App\Model\Medcheck\medcheckuserstable;
use App\Model\Medcheck\medcheckecgdata;
use App\Model\Medcheck\medcheckweightscale;
use App\Model\Medcheck\medcheckspo2;
use App\Model\Medcheck\medchecktemparature;
use App\Model\Medcheck\medcheckglucosedata;


use App\Helpers\Helper;

use Validator;
use Carbon\Carbon;
use URL;
use DB;

class AdminPatientMedcheckReadingController extends Controller
{

public function index()
      {
        $users = medcheckuserstable::all();
        

      return view('admin.medcheck.index', compact('users'));

      }

      public function show($id)
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

        return view('admin.medcheck.show', compact('user','bp','hr','bgm','spo2','temperature','weightscale'));
  
      }
      public function store($id)
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
                                     
         return view('admin.medcheck.store', compact('user','bp','hr','bgm','spo2','temperature','weightscale','bp1','hr1','bgm1','spo21','temperature1','weightscale1'));
  

      }
  }













































