<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ControlAuditPolicy extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $guarded = [];


    public function document()
   {
      return $this->belongsTo(Document::class)->with('documentStatus', 'file:id,unique_name');
   }
   public function frameworkcontrol()
   {
      return $this->belongsTo(FrameworkControlTestAudit::class , 'framework_control_test_audit_id');
   }
}
