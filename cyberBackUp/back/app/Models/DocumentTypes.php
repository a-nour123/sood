<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Document;

class DocumentTypes extends Model
{
    use HasFactory;

    public $guarded = [];

    /**
     * Get the comments for the blog post.
     */

    public function documents()
    {
        return $this->hasMany(Document::class,'document_type');
    }

    public function hasRelations()
    {
        // Get the count of related documents
        $relations = [
            'documents' => $this->documents()->count(), // Get the count of related documents
        ];
    
        // Filter out relations with count zero
        return array_filter($relations, fn($count) => $count > 0);
    }
    
 }
