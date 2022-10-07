<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
use URL;

class AdminAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        if(Auth::check()) {
            if ($request->user()->authorizeRoles('Admin')) {
                return $next($request);
            } else {
                 abort(401, 'Admin Access Only');
            }
        } else {
            return redirect()->route('login',['nexturl' => urldecode(\URL::full())]); // to get the current url with request parameters and redirect on login
        }
    }
}
