<?php

namespace App\Services;

use Twilio\Rest\Client;

class TwilioService
{
    protected $twilio;

    public function __construct()
    {
        $this->twilio = new Client(
            env('TWILIO_SID'),
            env('TWILIO_AUTH_TOKEN')
        );
    }

    public function sendOtp($phone, $otp)
    {
        try {
            $message = $this->twilio->messages->create(
                $phone, 
                [
                    'from' => env('TWILIO_PHONE_NUMBER'),
                    'body' => "Your OTP code is: $otp"
                ]
            );

            return $message;
        } catch (\Exception $e) {
            return null;
        }
    }
}
