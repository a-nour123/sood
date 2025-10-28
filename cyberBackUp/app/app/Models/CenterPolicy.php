<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CenterPolicy extends Model
{
    use HasFactory;

    protected $fillable = ['policy_name', 'document_ids'];
    protected $table = 'center_policies';
    public function documents()
    {
        return $this->belongsToMany(Document::class, 'document_policies', 'policy_id', 'document_id');
    }
    
}
