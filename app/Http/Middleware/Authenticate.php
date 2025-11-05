<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        // Map URL prefixes to login routes (centralized for all guards)
        $redirects = [
            'admin' => route('admin.login'),
            'doctor' => route('doctor.login'),
            'branch' => route('branch.login'),
        ];

        // Check URL prefix and redirect accordingly
        foreach ($redirects as $prefix => $loginRoute) {
            if (str_contains($request->url(), $prefix)) {
                return $loginRoute;
            }
        }

        // Fallback to admin login (no change to existing)
        return $request->expectsJson() ? null : route('admin.login');
    }
}