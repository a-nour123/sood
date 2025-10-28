<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecurityAwarenessExam extends Model
{
    use HasFactory;

    public $guarded = [];

    public $timestamps = false;

    /**
     * Get questions for this exam.
     */
    public function questions()
    {
        return $this->hasMany(SecurityAwarenessExamQuestion::class, 'security_awareness_exams_id');
    }

    /**
     * Get questions for this exam.
     */
    public function answers()
    {
        return $this->hasMany(SecurityAwarenessExamAnswer::class, 'security_awareness_exams_id')
                    ->with('employee:id,name','employeeOut:id,username');
    }
    
}
