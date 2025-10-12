<?php

namespace App\Services\Sms;

use App\Interfaces\SmsInterface;

class SmsServiceProvider
{
    public function send(SmsInterface $smsMethod, $userId, $message)
    {
        return $smsMethod->sendSms($userId, $message);
    }
}
