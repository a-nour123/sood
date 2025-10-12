<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Questionnaire extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'questionnaires';

    public function assessment()
    {
        return $this->belongsTo(Assessment::class, 'assessment_id');
    }

    public function questions(): BelongsToMany
    {
        return $this->belongsToMany(Question::class, QuestionnaireQuestion::class, 'questionnaire_id', 'question_id');
    }

    public function contacts(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'contact_questionnaires', 'questionnaire_id', 'user_id');
    }

    public function questionnaireAnswers()
    {
        return $this->hasMany(ContactQuestionnaireAnswer::class);
    }

    public function latestAnswers()
    {
        return $this->hasOne(ContactQuestionnaireAnswer::class)->where('contact_id', auth()->id())/*->where('submission_type', 'draft')*/->latest();
    }

    public function risks()
    {
        return $this->hasMany(QuestionnaireRisk::class);
    }

    public function pendingRisks()
    {
        return $this->risks()->where('status', 'pending');
    }

    public function rejectedRisks()
    {
        return $this->risks()->where('status', 'rejected');
    }

    public function AddedRisks()
    {
        return $this->risks()->where('status', 'added');
    }


}
