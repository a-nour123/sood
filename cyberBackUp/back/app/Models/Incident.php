<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    use HasFactory;
    public $guarded = [];


    // In Incident.php model
    public function occurrence()
    {
        return $this->belongsTo(Occurrence::class, 'occurrence_id');
    }

    public function direction()
    {
        return $this->belongsTo(Direction::class, 'direction_id');
    }

    public function attack()
    {
        return $this->belongsTo(Attack::class, 'attack_id');
    }

    public function detected()
    {
        return $this->belongsTo(Detected::class, 'detected_id');
    }

    public function incidentUsers()
    {
        return $this->belongsToMany(User::class, 'incident_users', 'incident_id', 'user_id');
    }

    public function incidentTeams()
    {
        return $this->belongsToMany(Team::class, 'incident_teams', 'incident_id', 'team_id');
    }

    public function relatedIncidents()
    {
        return $this->belongsToMany(Incident::class, 'related_incidents', 'incident_id', 'related_incident_id');
    }

    public function relatedRisks()
    {
        return $this->belongsToMany(Risk::class, 'incident_risks', 'incident_id', 'risk_id');
    }

    public function affectedAssets()
    {
        return $this->belongsToMany(Asset::class, 'incident_assets', 'incident_id', 'asset_id');
    }

    public function criteriaScores()
    {
        return $this->belongsToMany( IncidentCriteria::class,  // The related model
            'incident_criteria_scores',    // The pivot table
            'incident_id',                 // Foreign key on pivot table for Incident
            'incident_criteria_id'         // Foreign key on pivot table for IncidentCriteriaScore
        )
        ->withPivot('incident_score_id');    // Include the 'incident_score_id' from the pivot table
    }

    public function playbookUsers()
    {
        return $this->belongsToMany(User::class, 'incident_play_book_users', 'incident_id', 'user_id');
    }

    public function playbookTeams()
    {
        return $this->belongsToMany(Team::class, 'incident_play_book_teams', 'incident_id', 'team_id');
    }
}
