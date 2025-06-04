<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        
        $request->authenticate();

        
        $request->session()->regenerate();

        
        $user = Auth::user();

        if ($user->account_type == 'admin') {
            return redirect()->route('admin.dashboard'); 
        } elseif ($user->account_type == 'tutor') {
            return redirect()->route('tutor.dashboard'); 
        } else {
            return redirect()->route('user.select-profile');
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function destroyUserProfile(Request $request): RedirectResponse
    {
        
        $user = Auth::guard('web')->user();

        
        if ($user) {
            $user->profile_id = null;
            $user->save();
        }

        
        Auth::guard('web')->logout();

        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        
        return redirect('/');
    }

}
