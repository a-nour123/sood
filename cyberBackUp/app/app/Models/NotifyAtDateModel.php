<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotifyAtDateModel extends Model
{
    use HasFactory;
    protected $table = 'notify_at_date_models';

    protected $fillable = ['action_id','model_type','link', 'notification_date','model','roles','model_id','proccess'];

}
