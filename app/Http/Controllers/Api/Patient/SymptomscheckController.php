<?php

namespace App\Http\Controllers\Api\Patient;

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

class SymptomscheckController extends Controller
{
    public function InsertPatientCovid19(Request $request){

		$validator = Validator::make($request->all(), [
            'mobile_no' => 'required|numeric',
            'triage_level' => 'required',
		        'label'=> 'nullable',
		        'description'=> 'nullable',
		        'serious' => 'nullable',
            'root_cause' => 'nullable',
            'checked_datetime' => 'required'
            ]);
            
            if($validator->fails()){
            $errors = collect($validator->messages())->flatten()->toArray();
            return response()->json(['success' => false, 'message' => 'Validation Failed', 'validation' => $errors]);
            }
            
            //return json_encode($request->serious, true);

            if(strlen(trim($request->mobile_no)) > 10){
              $mobnum=trim($request->mobile_no);
              //$mobnum=substr(trim($id), 2, 10); 
            }
            else{
              $mobnum="91".trim($request->mobile_no);
              //$mobnum=substr_replace("91",trim($id),2);
            }
            
            //return $mobnum;
            $userid =medcheckuserstable::where('mobile_no', $mobnum)->value('id');
            
            if(!$userid){
              $userid="9999999";
            }
            
            //foreach($response_data['data'] as $v){ 
                            
              $device_reading_time= patientcovid19::wherechecked_datetime($request->checked_datetime)
                                                  ->whereuser_id($userid)
                                                  ->exists();
            
            if(!$device_reading_time){            
            try {
            
                DB::beginTransaction();
                // Create Patient 
                $patient = new patientcovid19();
                $patient->user_id = $userid;
                $patient->mobile_no=$mobnum;
                $patient->triage_level = $request->triage_level;
                $patient->label =$request->label;
                $patient->description=$request->description;
                $patient->serious=json_encode($request->serious,true);
                $patient->root_cause=$request->root_cause;
                $patient->checked_datetime=$request->checked_datetime;
                $patient->save();
                //commit
                DB::commit();
                
            }
            catch(\Exception $e){
                 
                DB::rollBack();    
                return response()->json(['success' => false, 'message' => $e]);
            }
              
            }// checked_datetime exist check end
            else
            {
              return response()->json(['success' => false, 'message' => 'Duplicate symptoms checked date time: '.$request->checked_datetime]);
            }
            
            
            return response()->json(['success' => true, 'message' => 'Insert COVID19 Symptoms data Successfully.']);
            
	}

  public function GetPatientCovid19Data(Request $request){
		$validator = Validator::make($request->all(), [
      'mobile_no' => 'required|numeric',
      'start_datetime' => 'required',
      'end_datetime' => 'required'
      ]);
      
      if($validator->fails()){
      $errors = collect($validator->messages())->flatten()->toArray();
      return response()->json(['success' => false, 'message' => 'Validation Failed', 'validation' => $errors]);
      }
      
      if(strlen(trim($request->mobile_no)) > 10){
        $mobnum=trim($request->mobile_no);
        //$mobnum=substr(trim($id), 2, 10); 
      }
      else{
        $mobnum="91".trim($request->mobile_no);
        //$mobnum=substr_replace("91",trim($id),2);
      }
      
      $from = date($request->start_datetime);
      $to = date($request->end_datetime);
      //echo ($from.';'. $to);
      $data =patientcovid19::where('mobile_no',$mobnum)
                            ->whereBetween('checked_datetime', [$from, $to])
                            ->get();
    
    $datacount = $data->count();
    //echo 'datacount: '.$datacount;
    if($datacount > 0)
    {  
      return response()->json(['success' => true, 'message' =>'Records Found.','data'=>$data]);
    }
    else
    {  
      return response()->json(['success' => false, 'message' =>'No Record(s) Found.']);
    }       
	}

	
}
