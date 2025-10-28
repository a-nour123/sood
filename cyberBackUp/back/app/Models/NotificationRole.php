<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationRole extends Model
{
    use HasFactory;
    protected $table = 'notifications_roles';
    public $guarded = [];
    public $timestamps = false;

    public function notifiable()
    {
        return $this->morphTo();
    }
}
