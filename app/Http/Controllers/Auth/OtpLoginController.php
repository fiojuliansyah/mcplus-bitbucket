<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Otp;
use App\Models\User;
use App\Services\TwilioService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OtpLoginController extends Controller
{
    protected $twilioService;

    public function __construct(TwilioService $twilioService)
    {
        $this->twilioService = $twilioService;
    }

    public function sendOtp(Request $request)
    {
        $request->validate(['phone' => 'required|string']);

        $user = User::where('phone', $request->phone)->first();

        if (!$user) {
            return response()->json(['message' => 'Phone number not registered.'], 404);
        }

        $otpCode = rand(100000, 999999);
        Otp::create([
            'number' => $user->phone,
            'otp' => $otpCode,
            'status' => 'pending',
            'type' => 'login',
        ]);

        $recipientNumber = 'whatsapp:' . $user->phone;

        try {
            $message = "Your login code is: {$otpCode}";
            $this->twilioService->sendWhatsApp($recipientNumber, $message);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to send OTP. Please try again.'], 500);
        }

        return redirect()->route('verify.otp', ['userId' => $user->id]);
    }
}