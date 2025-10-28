<?php

namespace App\Services\Sms;

use App\Interfaces\SmsInterface;
use App\Models\User;
use Twilio\Rest\Client;

class Twilio implements SmsInterface
{
    public function sendSms($userId, $message)
    {
        //getting the phone number of user
        $userPhone = User::where('id', $userId)->value('phone_number');
        if ($userPhone) {
            //creating a new client with twilio  sid and twilio token
            $client = new Client(env('TWILIO_SID'), env('TWILIO_TOKEN'));
            // sending the message to user
            $client->messages->create($userPhone, [
                'from' => env('TWILIO_FROM'),
                'body' => $message,
            ]);
        }
    }
}
