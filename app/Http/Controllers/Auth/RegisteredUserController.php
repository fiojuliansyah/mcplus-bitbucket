<?php

namespace App\Http\Controllers\Auth;

use App\Models\Otp;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Services\TwilioService;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;

class RegisteredUserController extends Controller
{
    protected $twilioService;

    public function __construct(TwilioService $twilioService)
    {
        $this->twilioService = $twilioService;
    }

    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'phone' => ['required', 'string', 'regex:/^\+?[1-9]\d{1,14}$/', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $otp = rand(100000, 999999);

        $otpRecord = Otp::create([
            'number' => $request->phone,
            'otp' => $otp,
            'status' => 'pending',
            'type' => 'registration',
        ]);

        $this->twilioService->sendOtp($request->phone, $otp);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'account_type' => $request->account_type,
            'phone_verified' => 'unverified',
            'password' => Hash::make($request->password),
        ]);

        return redirect(route('verify.otp'));
    }

    public function verifyOtp(Request $request, $userId)
    {
        $request->validate([
            'otp' => 'required|numeric',
        ]);

        $user = User::findOrFail($userId);
        $otpRecord = Otp::where('number', $user->phone)->where('otp', $request->otp)->where('status', 'pending')->first();

        if ($otpRecord) {
            $otpRecord->status = 'verified';
            $otpRecord->save();

            $user->phone_verified = 'verified';
            $user->save();

            Auth::login($user);

            return redirect(route('user.home'));
        }

        return redirect()
            ->back()
            ->withErrors(['otp' => 'Invalid OTP.']);
    }
}
