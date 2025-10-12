<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ControlControlObjective extends Model
{
    use HasFactory;

    protected $table = 'controls_control_objectives';
    
    protected $fillable = [
        'control_id',
        'objective_id',
        'responsible_type',
        'responsible_id',
        'responsible_team_id',
        'due_date'
    ];

    public function control()
    {
        return $this->belongsTo(FrameworkControl::class,'control_id');
    }

    public function objective()
    {
        return $this->belongsTo(ControlObjective::class,'objective_id');
    }
    public function responsibleUser()
    {
        return $this->belongsTo(User::class,'responsible_id');
    }
    public function responsibleTeam()
    {
        return $this->belongsTo(Team::class,'responsible_team_id');
    }
    public function evidences()
    {
        return $this->hasMany(Evidence::class);
    }
    public function responsible()
    {
        return $this->belongsTo(User::class,'responsible_id');
    }
    public function objectivestest()
    {
        return $this->belongsTo(ControlObjective::class, 'objective_id');
    }
    public function controlAuditObjectives1()
    {
        return $this->hasMany(ControlAuditObjective::class, 'control_control_objective_id');
    }
    
}
