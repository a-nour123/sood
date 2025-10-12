<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailSetting extends Model
{
    use HasFactory;

    protected $table = 'mail_settings';
    protected $fillable = [
        'action_id',
        'subject',
        'body',
        'status'
    ];


    /**
     * Get the action of mail.
     */
    public function action()
    {
        return $this->belongsTo(Action::class);
    }

    /**
     * Get all of the users for the mail.
     */
    public function users()
    {
        return $this->morphToMany(User::class, 'notifiable');
    }

    /**
     * Get all of the roles associated with the mail.
     */
    public function roles()
    {
        return $this->morphMany(NotificationRole::class, 'notifiable');
    }
}
