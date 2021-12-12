<?php

namespace App\Http\Middleware;

use App\User;
use Auth;
use Closure;
use Illuminate\Support\Facades\URL;

class TenantRoleCheck
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

        if(Auth::check() && User::isTenant()){

            $user = auth()->user();
            $user->load('tenant_details');
            if($request->slug!=$user->tenant_details->slug) {
                abort(404);
            }

            URL::defaults(['slug' => $request->slug]);

            return $next($request);
        }
        abort(404);
    }
}
