<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CenterPolicy extends Model
{
    use HasFactory;

    protected $fillable = ['policy_name', 'document_ids'];
    protected $table = 'center_policies';
    protected $casts = [
        'policy_name' => 'array',
    ];

    public function getPolicyNameAttribute($value)
    {
        $descriptions = json_decode($value, true) ?? [];
        $locale = app()->getLocale(); // Get current language (en/ar)

        // Return the description in the current language, fallback to English
        return $descriptions[$locale] ?? $descriptions['en'] ?? '';
    }

    public function documents()
    {
        return $this->belongsToMany(Document::class, 'document_policies', 'policy_id', 'document_id');
    }
}