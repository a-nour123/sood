<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditDocumentPolicyComment extends Model
{
    use HasFactory;

    protected $fillable = ['comment', 'user_id', 'aduit_id', 'document_policy_id','replier_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function replier()
    {
        return $this->belongsTo(User::class,'replier_id');
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
