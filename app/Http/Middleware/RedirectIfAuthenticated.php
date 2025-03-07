<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            /** @var \App\Models\User $user */
            $user = Auth::user();

            return $user->hasRole('doctor')
                ? redirect()->route('doctor.dashboard')
                : redirect()->route('patient.dashboard');
        }

        return $next($request);
    }
    
}
