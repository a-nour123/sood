<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncidentEvidence extends Model
{
    use HasFactory;

    public $guarded = [];

    public function creator()
{
    return $this->belongsTo(User::class, 'creator_id');
}

public function playBookAction()
{
    return $this->belongsTo(IncidentPlayBookAction::class, 'incident_play_book_action_id');
}
}
