<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncidentIra extends Model
{
    use HasFactory;
    public $guarded = [];


    // In IncidentIra.php model
    public function users()
    {
        return $this->belongsToMany(User::class, 'incident_ira_users', 'incident_ira_id', 'user_id');
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'incident_ira_teams', 'incident_ira_id', 'team_id');
    }
}
