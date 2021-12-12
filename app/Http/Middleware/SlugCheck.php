<?php

namespace App\Http\Middleware;

use App\Model\TenantDetail;
use Closure;

class SlugCheck
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
        $slug = $request->route('slug');

        $status = TenantDetail::whereSlug($slug)->exists();

        if($status || ($slug === 'admin') || ($slug === 'doctor') || ($slug === 'organisation'))
            return $next($request);
        else
            abort(404);
    }
}
