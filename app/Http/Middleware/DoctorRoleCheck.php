<?php

namespace App\Http\Middleware;

use App\User;
use Auth;
use Closure;

class DoctorRoleCheck
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
        if(Auth::check() && User::isDoctor()){
            return $next($request);
        }
        
        Auth::logout();
        return redirect()->route('/');
    }
}
