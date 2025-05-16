<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\TwilioService;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class OTPController extends Controller
{
    protected $twilioService;

    public function __construct(TwilioService $twilioService)
    {
        $this->twilioService = $twilioService;
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|regex:/^\+?[1-9]\d{1,14}$/',
        ]);

        $phone = $request->input('phone');

        $otp = rand(100000, 999999);

        $otpRecord = Otp::create([
            'number' => $phone,
            'otp' => $otp,
            'status' => 'pending',
            'type' => 'login',
            'user_id' => null,
        ]);

        $this->twilioService->sendOtp($phone, $otp);

        return response()->json([
            'message' => 'OTP sent successfully.',
            'otp_id' => $otpRecord->id,
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric',
            'otp_id' => 'required|exists:otps,id',
        ]);

        $otp = Otp::find($request->otp_id);

        if ($otp->otp == $request->otp) {
            $otp->status = 'verified';
            $otp->save();

            return response()->json(['message' => 'OTP verified successfully.']);
        }

        return response()->json(['message' => 'Invalid OTP.'], 400);
    }
}
