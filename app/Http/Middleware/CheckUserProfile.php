<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserProfile
{
    public function handle(Request $request, Closure $next)
    {
        
        $user = Auth::user();

        
        if ($user && $user->profile_id == null) {
            return redirect()->route('user.select-profile');
        }

        
        if (!$user) {
            return $next($request);
        }

        
        return $next($request);
    }
}
