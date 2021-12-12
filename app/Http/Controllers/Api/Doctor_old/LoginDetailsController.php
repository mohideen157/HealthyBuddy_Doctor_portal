<?php

namespace App\Http\Controllers\Api\Doctor;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;

use App\Helpers\Helper;

use Hash;

class LoginDetailsController extends Controller
{
	public function update(Request $request){
		try{
			$user = Helper::isUserLoggedIn();

			if (!$user) {
				return response()->json(['success' => false, 'error' => 'auth_error', 'message' => "Unauthorized"], 401);
			}

			$change = false;

			if ($request->has('email')) {
				if ($user->email != $request->email) {
					$email_exists = User::where('email', $request->email)->count();

					if ($email_exists > 0) {
						return response()->json(['success' => false, 'message' => 'Entered Email Address already exists.<br />Please enter a different email address']);
					}

					$user->email = $request->email;
					$change = true;
				}
			}

			if ($request->has('mobile_no')) {
				if ($user->mobile_no != $request->mobile_no) {
					$mobile_no_exists = User::where('mobile_no', $request->mobile_no)->count();

					if ($mobile_no_exists > 0) {
						return response()->json(['success' => false, 'message' => 'Entered Mobile No. already exists.<br />Please enter a different mobile no']);
					}

					$user->mobile_no = $request->mobile_no;
					$change = true;
				}
			}

			if ($request->has('password')) {
				$user->password = bcrypt($request->password);
				$change = true;
			}

			if ($change) {
				$user->save();
			}

			return response()->json(['success' => true, 'message' => 'Login Details Updated']);
		}
		catch(Exception $e){
			return response()->json(['success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"], 500);
		}
	}
}
