<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mitigation extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $guarded = [];

    /**
     * Get files
     */
    public function files()
    {
        return $this->hasMany(File::class)->where('view_type', '=', 2);
    }

    /**
     * Get teams
     */
    public function teams()
    {
        return $this->belongsToMany(Team::class, 'mitigation_to_teams', );
    }

    public function controls()
    {
        return $this->belongsToMany(FrameworkControl::class, 'mitigation_to_controls','mitigation_id', 'control_id');
    }

    public function planningStrategies()
    {
        return $this->belongsTo(PlanningStrategy::class, 'planning_strategy', );
    }
    
    public function mitigationEfforts()
    {
        return $this->belongsTo(MitigationEffort::class, 'mitigation_effort', );
    }
}
