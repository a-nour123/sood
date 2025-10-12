<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ThirdPartyQuestionnaire extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'instructions',
        'request_id',
        'assessment_id',
        'all_questions_mandatory'
    ];

    public function request()
    {
        return $this->belongsTo(ThirdPartyRequest::class, 'request_id');
    }

    public function assessment()
    {
        return $this->belongsTo(Assessment::class, 'assessment_id');
    }

    public function questions(): BelongsToMany
    {
        return $this->belongsToMany(Question::class, ThirdPartyQuestionnaireQuestion::class, 'questionnaire_id', 'question_id');
    }

    public function contacts(): BelongsToMany
    {
        return $this->belongsToMany(ThirdPartyProfileContact::class, 'third_party_contact_questionnaire', 'questionnaire_id', 'contact_id');
    }

    public function answers()
    {
        return $this->hasMany(ThirdPartyContactQuestionnaireAnswer::class);
    }

    public function risks()
    {
        return $this->hasMany(ThirdPartyQuestionnaireRisk::class);
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
