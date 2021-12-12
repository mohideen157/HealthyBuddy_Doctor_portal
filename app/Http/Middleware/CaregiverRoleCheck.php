<?php

namespace App\Http\Middleware;

use App\User;
use Auth;
use Closure;

class CaregiverRoleCheck
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
        if(Auth::check() && User::Caregiver()){
            return $next($request);
        }
        
        Auth::logout();
        return redirect()->route('/');
    }
}
