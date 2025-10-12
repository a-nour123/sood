<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ControlAuditObjective extends Model
{
    use HasFactory;
    
    protected $table ='control_audits_objectives';
    protected $guarded =[];

    public function controlControlObjective()
    {
       return $this->belongsTo(ControlControlObjective::class)->with('objective:id,name','responsibleUser:id,name','responsibleTeam:id,name');
    }


}
