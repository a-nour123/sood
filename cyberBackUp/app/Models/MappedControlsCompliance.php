<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MappedControlsCompliance extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function regulator()
    {
        return $this->belongsTo(Regulator::class, 'regulator_id');
    }
    public function framework()
    {
        return $this->belongsTo(Framework::class, 'framework_id');
    }

    public function controlDocuments()
    {
        return $this->hasMany(ControlComplianceDocument::class, 'mapped_controls_compliance_id');
    }
    
}