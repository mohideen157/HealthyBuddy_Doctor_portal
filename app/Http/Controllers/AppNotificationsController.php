<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Helpers\Helper;

use App\Model\Notification;
use App\User;

class AppNotificationsController extends Controller
{
    public function index(Request $request){
    	try{
    		$user = Helper::isUserLoggedIn();

			if (!$user) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => "Unauthorized"], 401);
			}

			$start = 0;
			$limit = 5;

			if ($request->has('start')) {
				$start = $request->start;
			}

			if ($request->has('limit')) {
				$limit = $request->limit;
			}

			$notifications_qry = $user->notifications()->unread();

			if ($limit > 0) {
				$notifications_qry->take($limit);
			}

			$notifications = $notifications_qry->select('id', 'subject', 'body', 'created_at')->orderBy('created_at', 'desc')->get();

			$unread_count = $user->notifications()->unread()->count();

			return response()->json(['success' => true, 'data' => ['count' => $unread_count, 'notifications' => $notifications]]);
    	}
    	catch(Exception $e){
    		return response()->json(['success' => false, 'error' => 'server_error', 'message' => 'Something went wrong'], 500);
    	}
    }

    public function clear(Request $request, $id){
    	try{
    		$user = Helper::isUserLoggedIn();

			if (!$user) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => "Unauthorized"], 401);
			}

			$notification = Notification::find($id);

			if ($notification->user_id != $user->id) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => 'You are trying access notification of another user']);
			}

			$notification->is_read = 1;
			$notification->save();

			return response()->json(['success' => true, 'message' => 'Notification Marked as read']);
    	}
    	catch(Exception $e){
    		return response()->json(['success' => false, 'error' => 'server_error', 'message' => 'Something went wrong'], 500);
    	}
    }

    public function clearAll(Request $request){
    	try{
    		$user = Helper::isUserLoggedIn();

			if (!$user) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => "Unauthorized"], 401);
			}

			Notification::where('user_id', $user->id)->where('is_read', 0)->update(['is_read' => 1]);

			return response()->json(['success' => true, 'message' => 'All Notifications marked as read']);
    	}
    	catch(Exception $e){
    		return response()->json(['success' => false, 'error' => 'server_error', 'message' => 'Something went wrong'], 500);
    	}
    }
}
