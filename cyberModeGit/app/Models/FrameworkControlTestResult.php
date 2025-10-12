<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\FrameworkControlTestAudit;
use App\Traits\Auditable;
class FrameworkControlTestResult extends Model
{
    use HasFactory,Auditable;

    public $timestamps = false;
    protected $fillable = [
        'test_audit_id',
        'test_result',
        'summary',
        'test_date',
        'submitted_by',
        'submission_date',
        'last_updated',
        'remediation'
    ];
    /**
     * Get audit that owns result.
     */
    public function FrameworkControlTestAudit()
    {
        return $this->belongsTo(FrameworkControlTestAudit::class, 'test_audit_id');
    }

    public function testResult()
    {
        return $this->belongsTo(TestResult::class, 'test_result');
    }



}
