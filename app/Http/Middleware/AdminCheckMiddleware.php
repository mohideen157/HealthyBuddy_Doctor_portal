<?php

namespace App\Http\Middleware;

use Closure;

use Auth;
use Toastr;

use App\Helpers\Helper;
use App\Model\UserRole;

class AdminCheckMiddleware
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if (Auth::check()) {
			$user = Auth::user();

			$user_role = UserRole::find($user->user_role);

			if ($user_role->user_role != 'admin') {
				Auth::logout();
				return redirect('/')->withErrors(['email' => 'These credentials do not match our records.']);
			}
		}

		return $next($request);
	}
}
