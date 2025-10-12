<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PolicyAdoption extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'introduction_content' => 'array',
    ];

    public function getIntroductionContentAttribute($value)
    {
        $questions = json_decode($value, true) ?? [];
        $locale = app()->getLocale(); // current language

        // Return the description in the current language, fallback to English
        return $questions[$locale] ?? $questions['en'] ?? '';
    }

    public function category()
    {
        return $this->belongsTo(DocumentTypes::class, 'category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function signature()
    {
        return $this->hasOne(PolicySignature::class, 'policy_id');
    }
}