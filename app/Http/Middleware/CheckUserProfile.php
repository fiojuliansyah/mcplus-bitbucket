<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserProfile
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return $next($request);
        }

        $user = Auth::user();

        $excludedRoutes = [
            'logout',
            'create.account',
            'create.account.store',
            'user.select-profile',
        ];

        if ($request->routeIs($excludedRoutes)) {
            return $next($request);
        }

        if ($user->profiles()->doesntExist()) {
            return redirect()->route('create.account');
        }

        if ($user->profile_id === null) {
            return redirect()->route('user.select-profile');
        }

        return $next($request);
    }
}