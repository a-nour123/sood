<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\FrameworkControl;
use App\Models\Family;
use App\Models\User;
use App\Models\TestStatus;
use App\Models\FrameworkControlTestAudit;

class FrameworkControlTest extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
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
        'additional_stakeholders'
    ];

     /**
     * Get the Control for the test.
     */
    public function FrameworkControl()
    {
        return $this->belongsTo(FrameworkControl::class,'framework_control_id');
    }
    /**
     * Get the tester for the test.
     */
    public function UserTester()
    {
        return $this->belongsTo(User::class,'tester','id');
    }

    /**
     * Get the Audits for the test.
     */
    public function FrameworkControlTestAudits()
    {
        return $this->hasMany(FrameworkControlTestAudit::class,'test_id','id');
    }

    public function testStatus()
    {
        return $this->belongsTo(TestStatus::class, 'status', 'id');
    }
}
