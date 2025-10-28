<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncidentComment extends Model
{
    protected $fillable = [
        'incident_id',
        'playbook_id',
        'action_id',
        'user_id',
        'comment',
        'file_display_name',
        'file_unique_name'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function incident()
    // {
    //     return $this->belongsTo(Incident::class);
    // }

    // public function playbook()
    // {
    //     return $this->belongsTo(Playbook::class);
    // }

    // public function action()
    // {
    //     return $this->belongsTo(IncidentPlayBookAction::class);
    // }
}