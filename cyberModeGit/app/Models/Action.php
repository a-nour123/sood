<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * Get the system notification settings of action.
     */
    public function systemNotificationSettings()
    {
        return $this->hasOne(SystemNotificationSetting::class);
    }

    /**
     * Get the mail settings of action.
     */
    public function MailSettings()
    {
        return $this->hasOne(MailSetting::class);
    }

    /**
     * Get the sms settings of action.
     */
    public function SmsSettings()
    {
        return $this->hasOne(SmsSetting::class);
    }
    public function AutoNotify()
    {
        return $this->hasOne(AutoNotify::class);
    }

    public function MailAutoNotify()
    {
        return $this->hasOne(MailAutoNotify::class);
    }
}
