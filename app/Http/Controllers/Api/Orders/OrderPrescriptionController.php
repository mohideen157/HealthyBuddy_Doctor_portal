<?php

namespace App\Http\Controllers\Api\Orders;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\Orders\Order;

use App\Helpers\Helper;

use Storage;

class OrderPrescriptionController extends Controller
{
    public function show($id){
		try{
			$user = Helper::isUserLoggedIn();

			if (!$user) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => "Unauthorized"], 401);
			}

			$order = Order::find($id);
			if (!$order) {
				return response()->json(['success' => false, 'error' => 'not_found', 'message' => 'Order Not Found']);
			}

			if ($order->user_id != $user->id) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => 'You are trying to access order of another user']);
			}

			$prescription = $order->prescription;

			if(Storage::has($prescription)){
				$file = storage_path('app/'.$prescription);
				return response()->download($file);
			}
			else{
				return response()->json(['success' => false, 'error' => 'not_found', 'message' => 'Order Prescription Not Found']);
			}
		}
		catch(Exception $e){
			return response()->json(['success' => false, 'error' => 'server_error', 'message' => 'Something went wrong.<br />Please try again'], 500);
		}
	}
}
