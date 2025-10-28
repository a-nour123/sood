<?php

namespace App\Services\Mail;

use App\Interfaces\MailInterface;

class MailServiceProvider
{
    public function send(MailInterface $mailMethod, $userId, $subject, $body)
    {
        return $mailMethod->sendMail($userId, $subject, $body);
    }
}
