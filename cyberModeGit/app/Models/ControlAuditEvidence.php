<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ControlAuditEvidence extends Model
{
    use HasFactory;
    
    protected $table ='control_audits_evidences';
    protected $guarded =[];

    public function evidence()
    {
       return $this->belongsTo(Evidence::class)->with('creator:id,name');
    }
}
