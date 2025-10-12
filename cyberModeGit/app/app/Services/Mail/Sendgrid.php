<?php

namespace App\Services\Mail;

use App\Interfaces\MailInterface;
use App\Mail\SendgridMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class Sendgrid implements MailInterface
{
    public function sendMail($userId, $subject, $body)
    {
        //getting the mail of user
        $email = new SendgridMail($subject, $body);
        $userEmail = User::where('id', $userId)->value('email');
        if ($userEmail) {
            try {
                //code...
                Mail::to($userEmail)->send($email);
            } catch (\Throwable $th) {
                dd($th->getMessage());
            }
        }
    }
}
