<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Twilio\TwiML\Voice\Play;

class IncidentPlayBookAction extends Model
{
    use HasFactory;
    public $guarded = [];

    public $timestamps = false;

    public function evidences()
    {
        return $this->hasMany(IncidentEvidence::class, 'incident_play_book_action_id');
    }
        public function playBookAction()
    {
        return $this->belongsTo(PlayBookAction::class);
    }
}