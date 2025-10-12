<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncidentPlayBookAction extends Model
{
    use HasFactory;
    public $guarded = [];

    public $timestamps = false;

    public function evidences()
{
    return $this->hasMany(IncidentEvidence::class, 'incident_play_book_action_id');
}
}
