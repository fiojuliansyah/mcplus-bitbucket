<?php

namespace App\Http\Controllers\Auth;

use App\Models\Otp;
use App\Models\User;
use App\Mail\SendOtpMail;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;

class RegisteredUserEmailController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'string', 'lowercase', 'email', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'email' => $request->email,
            'email_verified' => 'unverified',
            'password' => Hash::make($request->password),
        ]);

        try {
            $otp = rand(100000, 999999);
    
            Otp::create([
                'email' => $request->email,
                'otp' => $otp,
                'status' => 'pending',
                'type' => 'registration',
            ]);

            Mail::to($request->email)->send(new SendOtpMail($otp));

        } catch (\Exception $e) {

            Log::error('Failed Send OTP: ' . $e->getMessage());
        }

        return redirect()->route('verify.otp', ['userId' => $user->id]);
    }

    public function showVerifyForm($userId)
    {
        $user = User::findOrFail($userId);
        return view('auth.verify-email', [
            'userId' => $userId,
            'user'   => $user 
        ]);
    }

    public function verifyOtp(Request $request, $userId)
    {
        $request->validate([
            'otp' => 'required|numeric',
        ]);

        $user = User::findOrFail($userId);
        $otpRecord = Otp::where('email', $user->email)
                        ->where('otp', $request->otp)
                        ->where('status', 'pending')
                        ->latest() 
                        ->first();

        if ($otpRecord) {

            $otpRecord->status = 'verified';
            $otpRecord->save();

            $user->email_verified = 'verified';
            $user->save();

            Auth::login($user);

            return redirect(route('choose.account'));
        }

        return redirect()
            ->back()
            ->withErrors(['otp' => 'Invalid OTP.']);
    }
}