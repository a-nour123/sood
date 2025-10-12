<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditDocumentTotalStatus extends Model
{
    use HasFactory;

    protected $fillable = ['audit_id', 'document_id', 'user_id', 'total_status'];

    // Define relationships
    public function audits()
    {
        return $this->belongsTo(AuditDocumentPolicy::class, 'audit_id');
    }

    public function documents()
    {
        return $this->belongsTo(Document::class, 'document_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

