<?php

namespace App\Interfaces;

interface MailInterface
{
    public function sendMail($userId, $subject, $body);
}
