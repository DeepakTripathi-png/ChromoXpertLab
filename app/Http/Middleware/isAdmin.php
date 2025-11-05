<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Session;
use Auth;

class isAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Session::has('MasterAdmin*%') && Auth::guard('master_admins')->user() && Auth::guard('master_admins')->user()->status == 'active'){     
            return $next($request);
        }
        Auth::logout();
        Session::flush();
        return redirect('/admin');
    }
}
