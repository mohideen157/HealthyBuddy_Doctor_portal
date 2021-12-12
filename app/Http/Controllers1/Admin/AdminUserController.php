<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;

use App\Helpers\Helper;

use Hash;
use Redirect;
use Validator;

class AdminUserController extends Controller
{
	public function edit($id){
		$user = User::find($id);

		if (!$user) {
			return Redirect::back()->with('error', 'User not found');
		}

		return view('admin.user.edit', [
			'user' => $user
		]);
	}

	public function update(Request $request, $id){
		$user = User::find($id);

		if (!$user) {
			return Redirect::back()->with('error', 'User not found');
		}

		$data = $request->all();

		$validator = Validator::make($data,[
			'password'     => 'required',
			'confirm_password' => 'required'
		]);

		if ($validator->fails()) {
			return Redirect::back()
					->withErrors($validator)
					->withInput();
		}

		if ($data['password'] != $data['confirm_password']) {
			return Redirect::back()
					->withErrors(['confirm_password' => 'This should be same as the password'])
					->withInput();
		}

		$user->password = bcrypt($data['password']);
		$user->save();

		return redirect('/admin/patients')->with('status', 'User Updated');
	}
}
