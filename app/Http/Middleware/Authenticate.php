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
        // Redirect to admin login if the route uses the 'admin' guard
        if ($request->route()->middleware() && in_array('auth:admin', $request->route()->middleware())) {
            return route('admin.login');
        }

        // Redirect to employee login if the route uses the 'employee' guard
        if ($request->route()->middleware() && in_array('auth:employee', $request->route()->middleware())) {
            return route('employee.login');
        }

        // Fallback (optional)
        return $request->expectsJson() ? null : route('login');
    }
}
