<?php

namespace App\Services;

use Twilio\Rest\Client;
use Exception;

class TwilioService
{
    protected $client;
    protected $from;


    public function __construct()
    {
        $sid = config('services.twilio.sid');
        $token = config('services.twilio.token');
        $this->from = config('services.twilio.whatsapp_from');
        
        if (!$sid || !$token || !$this->from) {
            throw new Exception('Kredensial Twilio tidak lengkap. Pastikan TWILIO_SID, TWILIO_TOKEN, dan TWILIO_WHATSAPP_FROM sudah diatur di file .env');
        }

        $this->client = new Client($sid, $token);
    }


    public function sendWhatsApp(string $to, string $message)
    {
        return $this->client->messages->create(
            $to,
            [
                'from' => $this->from,
                'body' => $message,
            ]
        );
    }

    public function sendWhatsAppTemplate(string $to, string $contentSid, array $contentVariables = [])
    {
        return $this->client->messages->create(
            $to,
            [
                "from" => $this->from,
                "contentSid" => $contentSid,
                "contentVariables" => json_encode($contentVariables),
            ]
        );
    }
}