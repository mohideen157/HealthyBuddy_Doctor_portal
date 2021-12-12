<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\History;
use App\User;
use Illuminate\Http\Request;

class AdminHistoryController extends Controller
{
	public function index()
	{
		$users = User::whereActive(1)
                    ->whereUserRole(4)
                    ->get();

		return view('admin.history.index', compact('users'));
	}

	public function show(User $user)
	{
		$user->load('history');
		return view('admin.history.show', compact('user'));
	}

	public function graph(History $history)
	{
		$history->load('user');
		return view('admin.history.graph', compact('history'));
	}
}