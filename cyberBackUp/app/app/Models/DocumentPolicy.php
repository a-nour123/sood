<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentPolicy extends Model
{
    use HasFactory;

    protected $fillable = [
        'policy_id',
        'document_id',
    ];
    protected $table = 'document_policies';

    // Define relationships if needed
    public function policy()
    {
        return $this->belongsTo(CenterPolicy::class, 'policy_id');
    }

    public function document()
    {
        return $this->belongsTo(Document::class, 'document_id');
    }
    public function auditComments()
    {
        return $this->hasMany(AuditDocumentPolicyComment::class, 'document_policy_id', 'id');
    }

    public function auditFiles()
    {
        return $this->hasMany(AuditDocumentPolicyFile::class, 'document_policy_id', 'id');
    }

    public function auditStatuses()
    {
        return $this->hasMany(AuditDocumentPolicyStatus::class, 'document_policy_id', 'id');
    }
}
