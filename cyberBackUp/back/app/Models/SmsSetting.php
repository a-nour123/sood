<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsSetting extends Model
{
    use HasFactory;

    protected $table = 'sms_settings';
    protected $fillable = [
        'action_id',
        'message',
        'status'
    ];


    /**
     * Get the action of sms.
     */
    public function action()
    {
        return $this->belongsTo(Action::class);
    }

    /**
     * Get all of the users for the sms.
     */
    public function users()
    {
        return $this->morphToMany(User::class, 'notifiable');
    }

    /**
     * Get all of the roles associated with the sms.
     */
    public function roles()
    {
        return $this->morphMany(NotificationRole::class, 'notifiable');
    }
}
