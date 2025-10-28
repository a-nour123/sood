<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class AutoNotify extends Model
{
    use HasFactory;
    protected $table = 'auto_notifies';
    protected $fillable = [
        'action_id',
        'message',
        'date',
        'status',
    ];



    /**
     * Get the action of Autonotify.
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
