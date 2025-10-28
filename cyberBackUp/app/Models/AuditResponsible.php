<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditResponsible extends Model
{
    use HasFactory;

    public $table = 'audits_responsibles';
    protected $fillable = [
        'owner_id',
        'audit_name',
        'responsible',
        'responsible_type',
        'start_date',
        'due_date',
        'periodical_time',
        'next_initiate_date',
        'regulator_id',
        'framework_id',
        'test_number_initiated',
        'initiate_date',
        'created_by',
        'audit_type',
        'audit_function',
        
    ];
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
    public function regulatoraduit()
    {
        return $this->belongsTo(Regulator::class, 'regulator_id');
    }
    public function frameworkaduit()
    {
        return $this->belongsTo(Framework::class, 'framework_id');
    }
    public function frameworkControlTestAudits()
    {
        return $this->hasMany(FrameworkControlTestAudit::class, 'audit_id');
    }
}