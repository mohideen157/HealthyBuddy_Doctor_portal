<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\DeviceRegistration;



class AppNotification extends Controller
{
    protected function deviceRegistration(Request $request)
    {
    	$referrer = DeviceRegistration::where('user_id', $request['userId'])->count();
    	if(!$referrer){
        $result = DeviceRegistration::create([
        	'user_id' => $request['userId'],
           'device_type' => $request['deviceType'],
            'device_token' => $request['deviceToken']   
        ]);
        if($result){
        	$res['isSuccess'] = true;
        	$res['msg'] = 'Success!';
        	return response()->json($res);
        	
        }else{
        	$res['isSuccess'] = false;
        	$res['msg'] = 'Something went worng!';
        	return response()->json($res);       	
        }
    }
    else{
    	try{
    	$getUpdate=DeviceRegistration::where('user_id', $request['userId'])
          ->update(['device_type' => $request['deviceType'],'device_token'=>$request['deviceToken']]);
    	if($getUpdate){

    	$flights = DeviceRegistration::where('user_id','!=' ,$request['userId'])
                ->where('device_token',$request['deviceToken'])
                ->delete();

        //$getDetail = $flight->history()->withTrashed()->get();
        //print_r($getDetail);
                
    		$res['isSuccess'] = true;
        	$res['msg'] = 'Updated!';
        	return response()->json($res);
        }else{
        	$res['isSuccess'] = false;
        	$res['msg'] = 'Success!';
        	return response()->json($res);
        }
    }catch(Exception $e){
    	return response()->json($e);
    }
    }
    }
}
