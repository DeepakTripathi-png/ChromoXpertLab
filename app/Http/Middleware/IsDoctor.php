<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsDoctor
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('doctor')->check()) {
            return $next($request);
        }
        return redirect('/doctor')->with('error', 'Unauthorized access.');
    }
}
