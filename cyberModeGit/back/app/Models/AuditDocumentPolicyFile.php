<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditDocumentPolicyFile extends Model
{
    use HasFactory;

    protected $fillable = ['file_path', 'file_name', 'uploaded_by', 'aduit_id', 'document_policy_id','evidenc_name','description'];

    public function user()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
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
