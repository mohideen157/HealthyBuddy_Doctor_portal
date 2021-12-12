<?php

namespace App\Http\Middleware;

use Closure;

use App\Helpers\Helper;
use App\Model\UserRole;

class UserRoleMiddleware
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next, $role)
	{
		$user = Helper::isUserLoggedIn();

		if (!$user) {
			return response()->json(['success' => false, 'error' => 'auth_error', 'message' => "Unauthorized"], 401);
		}

		$user_role = UserRole::find($user->user_role);

		if ($user_role->user_role != $role) {
			return response()->json(['success' => false, 'error' => 'auth_error', 'message' => "You are trying to access a page that is only allowed for ".ucwords($role)]);
		}
		
		return $next($request);
	}
}
