<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncidentLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'incident_id',
        'playbook_id',
        'action_id',
        'user_id',
        'old_value',
        'new_value',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}