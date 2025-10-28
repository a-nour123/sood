<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\FrameworkControlTestAudit;
use App\Models\User;
use App\Traits\Auditable;
class FrameworkControlTestComment extends Model
{
    use HasFactory,Auditable;

    public $timestamps = false;
    protected $fillable = [
        'test_audit_id',
        'date',
        'user',
        'comment'
    ];
    /**
     * Get the FrameworkControlTestAudit that owns the comment.
     */
    public function FrameworkControlTestAudit()
    {
        return $this->belongsTo(FrameworkControlTestAudit::class,'test_audit_id');
    }

    /**
     * Get user that owns the comment.
     */
    public function UserCommented()
    {
        return $this->belongsTo(User::class,'user');
    }
}
