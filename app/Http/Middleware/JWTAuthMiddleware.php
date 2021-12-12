<?php

namespace App\Http\Middleware;

use Closure;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class JWTAuthMiddleware
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
		try {
			if (! $user = JWTAuth::parseToken()->authenticate()) {
				return response()->json(['user_not_found'], 404);
			}
		}
		catch (TokenExpiredException $e) {
			return response()->json(['success' => false, 'message' => 'token_expired'], $e->getStatusCode());
		}
		catch (TokenInvalidException $e) {
			return response()->json([ 'success' => false, 'message' => 'token_invalid', 'error' => $e->getMessage()], $e->getStatusCode());
		}
		catch (JWTException $e) {
			return response()->json([ 'success' => false, 'message' => 'token_absent'], $e->getStatusCode());
		}
		catch (Exception $e) {
			return response()->json(['success' => false, 'message' => 'server_error'], $e->getStatusCode());
		}

		if ($user->active != 1) {
			return response()->json(['success' => false, 'message' => 'account_inactive'], 401);
		}

		return $next($request);
	}
}
