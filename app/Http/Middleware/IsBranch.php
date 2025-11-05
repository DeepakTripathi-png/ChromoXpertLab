<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Session;
use Auth;

class IsBranch
{
    
    // public function handle(Request $request, Closure $next): Response
    // {
    //     if(Session::has('BranchAdmin*%') && Auth::guard('branch')->user() && Auth::guard('branch')->user()->status == 'active'){     
    //         return $next($request);
    //     }
    //     Auth::guard('branch')->logout();
    //     Session::flush();
    //     return redirect('/branch-login');
    // }


    public function handle(Request $request, Closure $next): Response
    {
        if(Session::has('BranchAdmin*%') && Auth::guard('branch')->user() && Auth::guard('branch')->user()->status == 'active'){     
            return $next($request)->withHeaders([
                'Access-Control-Allow-Origin' => '*',
                'Access-Control-Allow-Methods' => '*',
                'Access-Control-Allow-Credentials' => 'true',
                'Access-Control-Allow-Headers' => 'X-Requested-With,Content-Type,X-Token-Auth,Authorization',
                'Accept' => 'application/json'
            ]);
        }
        Auth::guard('branch')->logout();
        Session::flush();
        return redirect('/branch-login');
    }

    
}