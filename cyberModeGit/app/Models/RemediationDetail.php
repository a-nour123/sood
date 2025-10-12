<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RemediationDetail extends Model
{
    protected $fillable = [
        'responsible_user',
        'corrective_action_plan',
        'budgetary',
        'status',
        'due_date',
        'comments',
        'control_test_id'
    ];

    /**
     * Get the user that is responsible for this remediation detail.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'responsible_user');
    }

    /**
     * Get the framework control test audit associated with this remediation detail.
     */
    public function controlTestAudit()
    {
        return $this->belongsTo(FrameworkControlTestAudit::class, 'control_test_id');
    }
}
