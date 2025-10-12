<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailAutoNotify extends Model
{
    use HasFactory;

    protected $table = 'mail_auto_notfies';
    protected $fillable = [
        'action_id',
        'subject',
        'message',
        'date',
        'status',
    ];

    public function action()
    {
        return $this->belongsTo(Action::class);
    }

    /**
     * Get all of the users for the notification.
     */
    public function users()
    {
        return $this->morphToMany(User::class, 'notifiable');
    }

    public function roles()
    {
        return $this->morphMany(NotificationRole::class, 'notifiable');
    }
}
