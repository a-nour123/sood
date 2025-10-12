<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemNotificationSetting extends Model
{
    use HasFactory;

    protected $table = 'system_notifications_settings';
    protected $fillable = [
        'action_id',
        'message',
        'status'
    ];


    /**
     * Get the action of notification.
     */
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
