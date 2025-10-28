<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditDocumentPolicyStatus extends Model
{
    use HasFactory;

    protected $fillable = ['status', 'user_id', 'aduit_id', 'document_policy_id','auditer_status','pending_status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function auditDocumentPolicy()
    {
        return $this->belongsTo(AuditDocumentPolicy::class, 'aduit_id');
    }

    public function documentPolicy()
    {
        return $this->belongsTo(DocumentPolicy::class);
    }
}
