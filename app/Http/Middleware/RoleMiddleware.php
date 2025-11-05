<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $guard): Response|RedirectResponse
    {
        // Check if authenticated for the specific guard
        if (!Auth::guard($guard)->check()) {
            $redirectTo = match ($guard) {
                'master_admins' => route('admin.login'),
                'doctor' => route('doctor.login'),
                'branch' => route('branch.login'),
                default => route('admin.login')
            };

            return redirect($redirectTo)->with('error', 'Session out! Login again.');
        }

        $user = Auth::guard($guard)->user();

        // Check status (inactive or soft-deleted)
        if ($user->status !== 'active') {
            // Logout the guard
            Auth::guard($guard)->logout();

            $redirectTo = match ($guard) {
                'master_admins' => route('admin.login'),
                'doctor' => route('doctor.login'),
                'branch' => route('branch.login'),
                default => route('admin.login')
            };

            return redirect($redirectTo)->with('error', 'Inactive user! Contact admin for activation.');
        }

        return $next($request);
    }
}