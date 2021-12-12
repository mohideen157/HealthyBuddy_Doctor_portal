<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Model\PasswordResetCodes;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;

class ResetPasswordController extends Controller
{
    public function show($token)
    {
    	return view('reset_password',compact('token'));
    }

    public function store(Request $request)
    {
    	$validator = Validator::make($request->all(),[

    		'token' => 'required',
    		'email' => 'required|exists:users,email',
    		'password' => 'required|min:8',
    		'confirm_password' => 'required|same:password'
    	])->validate();

    	$user = User::whereEmail($request->email)->first();

    	$password_reset_code = PasswordResetCodes::where('user_id', $user->id)->first();


        if($password_reset_code)
        {
            $code = decrypt($password_reset_code->code);

            if(Carbon::now()->toDateTimeString() <= $code[0]['expiry'] && $request->token == $code[0]['token'])
            {
                $user->password = bcrypt($request->password);
                $status = $user->save();

                alert()->success('Success', 'Password Reset Successfully');

                return redirect()->route('/');
            }
        }

    	alert()->error('Failed', 'Failed to Reset Password');

    	return redirect()->route('/');
    }
}
