<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentContentChange extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_id',
        'old_content',
        'new_content',
        'changed_by',
        'status',
        'file_path',
        'file_name'
    ];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function changedByUser()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
 public function getOldContentAttribute($value)
{
    return str_replace('&nbsp;', ' ', strip_tags($value));
}

public function getNewContentAttribute($value)
{
    return str_replace('&nbsp;', ' ', strip_tags($value));
}
}