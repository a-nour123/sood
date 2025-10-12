<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Twilio\Jwt\TaskRouter\Policy;

class Exception extends Model
{
    use HasFactory;

    // protected $fillable = [];
    protected $guarded = [];

    public function policies()
    {
        return $this->belongsToMany(Document::class, 'exception_policy', 'exception_id', 'policy_id');
    }

    public function controls()
    {
        return $this->belongsToMany(FrameworkControl::class, 'control_exception', 'exception_id', 'control_id');
    }

    public function risks()
    {
        return $this->belongsToMany(Risk::class, 'exception_risk', 'exception_id', 'risk_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'exception_creator');
    }

    public function policy_approver()
{
    return $this->belongsTo(User::class, 'policy_approver_id');
}
}
