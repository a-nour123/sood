<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AssessmentAnswer extends Model
{
    use HasFactory;

    protected $table = 'assessment_answers';
    protected $guarded = [];
    public $timestamps = true;

    protected $casts = [
        'answer' => 'array',
    ];

    public function getAnswerAttribute($value)
    {
        $questions = json_decode($value, true) ?? [];
        $locale = app()->getLocale(); // Get current language (en/ar)

        // Return the description in the current language, fallback to English
        return $questions[$locale] ?? $questions['en'] ?? '';
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class, 'question_id', 'id');
    }

    public function sub_questions(): BelongsToMany
    {
        return $this->belongsToMany(Question::class, 'answer_sub_questions', 'answer_id', 'question_id')->withPivot('question_id');
    }

    public function maturity_control(): BelongsTo
    {
        return $this->belongsTo(ControlMaturity::class, 'maturity_control_id', 'id');
    }

    public function scoring_method()
    {
        return $this->belongsTo(ScoringMethod::class, 'risk_scoring_method_id');
    }

    public function likelihood()
    {
        return $this->belongsTo(Likelihood::class, 'likelihood_id');
    }

    public function impact()
    {
        return $this->belongsTo(Impact::class, 'impact_id');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function nda()
    {
        return $this->belongsTo(Nda::class, 'nda_id');
    }
}
