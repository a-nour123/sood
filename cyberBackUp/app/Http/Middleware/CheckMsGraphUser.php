<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckMsGraphUser
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Add any additional checks here
            // For example, check if user is active:
            if (!$user->is_active) {
                Auth::logout();
                return redirect()->route('login')->with('error', 'Account disabled');
            }
        }

        return $next($request);
    }
}
