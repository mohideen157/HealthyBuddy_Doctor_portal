<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\Notification;
use App\User;
use Auth;

use Carbon\Carbon;

class AdminNotificationsController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(){
		$user = Auth::user();

		$notifications = $user->notifications()->unread()->select('id', 'subject', 'body', 'created_at')->orderBy('created_at', 'desc')->get();

		 return view('admin.notifications.index', [
                    'all_notifications' => $notifications
                ]);
	}

	public function clear($id){
		$notification = Notification::find($id);

		$notification->is_read = 1;
		$notification->save();

		return redirect('admin/notifications')->with('status', 'Notification marked as read');
	}

	public function clearAll(){
		$user = Auth::user();
		Notification::where('user_id', $user->id)->where('is_read', 0)->update(['is_read' => 1]);

		return redirect('admin/notifications')->with('status', 'All Notifications marked as read');
	}
}
