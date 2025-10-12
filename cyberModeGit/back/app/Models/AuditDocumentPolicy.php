<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditDocumentPolicy extends Model
{
    use HasFactory;

    protected $fillable = [
        'aduit_name',
        'document_id',
        'owner_id',
        'start_date',
        'due_date',
        'periodical_time',
        'next_initiate_date',
        'enable_audit',
        'requires_file',
        'document_type',
    ];

    // Many-to-Many relationship with DocumentPolicy
    public function policies()
    {
        return $this->belongsToMany(DocumentPolicy::class, 'audit_document_policy_policy_document', 'audit_document_policy_id', 'policy_document_id');
    }

    // Relationship to Document
    public function document()
    {
        return $this->belongsTo(Document::class, 'document_id', 'id');
    }

    // Relationship to User (owner)
    public function users()
    {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }

    // Relationship to Comments
    public function comments()
    {
        return $this->hasMany(AuditDocumentPolicyComment::class, 'aduit_id', 'id');
    }

    // Relationship to Files
    public function files()
    {
        return $this->hasMany(AuditDocumentPolicyFile::class, 'aduit_id', 'id');
    }

    // Relationship to Status
    public function status()
    {
        return $this->hasMany(AuditDocumentPolicyStatus::class, 'aduit_id', 'id');
    }
    
    public function auditDocumentTotalStatuses()
    {
        return $this->hasMany(AuditDocumentTotalStatus::class);
    }
 
        public function documentType()
        {
            return $this->belongsTo(DocumentTypes::class, 'document_type', 'id');
        }
}
