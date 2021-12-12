<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\Model\Orders\Order;
use App\Model\Orders\OrderMedicines;

use Mail;
use Storage;
use File;
use Redirect;
use Response;
use Carbon\Carbon;

class AdminMedicineOrdersController extends Controller
{
	public function index(){
		$orders = Order::where('order_type', 'medicine')->orderBy('id', 'desc')->get();

		return view('admin.orders.medicine.index', [
			'orders' => $orders
		]);
	}

	public function show($id){
		$order = Order::find($id);

		if (!$order || $order->order_type != 'medicine') {
			return redirect('/admin/medicine-orders')->with('error', 'Order not found');
		}

		$order_user = User::find($order->user_id);

		$status_arr = array(
			'Pending' => 'Pending',
			'Accepted' => 'Accepted',
			'Dispatched' => 'Dispatched',
			'Delivered' => 'Delivered',
			'Cancelled' => 'Cancelled',
			'Failed' => 'Failed'
		);

		return view('admin.orders.medicine.show', [
			'order' => $order,
			'user' => $order_user,
			'possible_status' => $status_arr
		]);
	}

	public function update(Request $request, $id){
		$order = Order::find($id);

		if (!$order || $order->order_type != 'medicine') {
			return Redirect::back()->with('error', 'Order not found');
		}

		if ($request->has('status')) {
			$order->status = $request->status;
		}

		if ($request->has('remarks')) {
			$order->remarks = $request->remarks;
		}
		else{
			$order->remarks = NULL;
		}

		if ($request->has('deliver_by')) {
			$order->deliver_by = Carbon::parse($request->deliver_by)->toDateString();
		}
		else{
			$order->deliver_by = NULL;
		}

		if ($request->has('delivered_on')) {
			$order->delivered_on = Carbon::parse($request->delivered_on)->toDateString();
		}
		else{
			$order->delivered_on = NULL;
		}

		$order->save();

		// Send Mail To User
		$user = User::find($order->user_id);
		$sendemail = Mail::send('emails.orderStatusChange', array('name' => $user->name, 'order_id' => $order->shdct_id, 'order_type' => 'medicine', 'status' => $request->status), function ($message) use ($user)
		{
			$message->to($user->email, $user->name);
			$message->subject('SheDoctr - Order Status');
		});

		return redirect('/admin/medicine-orders')->with('status', 'Order Updated');
	}

	public function prescription($id){
		$order = Order::find($id);
		if (!$order || $order->order_type != 'medicine') {
			return Redirect::back()->with('error', 'Order not found');
		}

		$filename = $order->prescription;

		if (!Storage::has($filename)) {
			return Redirect::back()->with('error', 'Order Prescription not found');
		}

		$path = storage_path('app') . '/' . $filename;

		$file = File::get($path);
		$type = File::mimeType($path);

		$response = Response::make($file, 200);
		$response->header("Content-Type", $type);

		return $response;
	}
}
