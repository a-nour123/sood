<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ControlComplianceDocument extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
    'document_actions' => 'array',
];
    public function compliance()
    {
        return $this->belongsTo(MappedControlsCompliance::class, 'mapped_controls_compliance_id');
    }

    public function controls()
    {
        return $this->belongsTo(FrameworkControl::class, 'control_id');
    }

   
}