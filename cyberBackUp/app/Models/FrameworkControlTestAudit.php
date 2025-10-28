<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\FrameworkControlTest;
use App\Models\TestStatus;
use App\Models\FrameworkControlTestResult;
use App\Models\FrameworkControlTestComment;
use App\Traits\Auditable;
use App\Events\AuditCreated;

class FrameworkControlTestAudit extends Model
{
    use HasFactory, Auditable;

    public $timestamps = false;
    protected $fillable = [
        'test_id',
        'tester',
        'test_frequency',
        'last_date',
        'next_date',
        'name',
        'test_steps',
        'approximate_time',
        'expected_results',
        'framework_control_id',
        'desired_frequency',
        'status',
        'created_at',
        'test_number',
        'audit_name',
        'action_status',
        'audit_id',
    ];
    // protected $dispatchesEvents = [
    //     'created' => AuditCreated::class,
    // ];
    /**
     * Get the test that owns the Audit.
     */
    public function FrameworkControlTest()
    {
        return $this->belongsTo(FrameworkControlTest::class, 'test_id');
    }
    public function FrameworkControl()
    {
        return $this->belongsTo(FrameworkControl::class, 'framework_control_id');
    }
    /**
     * Get the tester for the test.
     */
    public function UserTester()
    {
        return $this->belongsTo(User::class, 'tester', 'id');
    }
    public function testers()
    {
        return $this->hasMany("App\Models\User", "id", "tester");
    }
    /**
     * Get result associated with audit.
     */
    public function FrameworkControlTestResult()
    {
        return $this->hasOne(FrameworkControlTestResult::class, 'test_audit_id', 'id');
    }
    /**
     * Get the FrameworkControlTestComments for the FrameworkControlTestAudit.
     */
    public function FrameworkControlTestComments()
    {
        return $this->hasMany(FrameworkControlTestComment::class, 'test_audit_id');
    }

    public static function itemLogs($id)
    {
        return AuditLog::whereIn('log_type', [FrameworkControlTestAudit::class, 'audit'])
                       ->where('risk_id', $id)
                       ->get();
    }
    

    /**
     * Get the ControlAuditPolicies for the FrameworkControlTestAudit.
     */
    public function ControlAuditPolicies()
    {
        return $this->hasMany(ControlAuditPolicy::class)->with('document:id,file_id,document_name,document_status,last_review_date,approval_date');
    }

    public function FrameworkControlWithFramworks()
    {
        return $this->belongsTo(FrameworkControl::class, 'framework_control_id')->with(['Frameworks:id,name', 'Families:id,name']);
    }

    /**
     * Get the ComplianceFile for the FrameworkControlTestAudit.
     */
    public function compliance_files()
    {
        return $this->hasMany(ComplianceFile::class, 'ref_id');
    }
    public function controlAuditObjectives()
    {
        return $this->hasMany(ControlAuditObjective::class)
            ->with([
                'controlControlObjective:id,objective_id,responsible_type,responsible_id,responsible_team_id,due_date'
            ]);
    }
    public function controlAuditEvidences()
    {
        return $this->hasMany(ControlAuditEvidence::class);
    }

    public function TestStatus()
    {
        return $this->belongsTo(TestStatus::class, 'status');
    }
    public function auditResponsible()
    {
        return $this->belongsTo(AuditResponsible::class, 'audit_id');
    }
}
