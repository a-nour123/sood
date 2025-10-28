<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use LdapRecord\Models\Relations\HasOne;

class Question extends Model
{
    use HasFactory;

    protected $table = 'questions';
    protected $guarded = [];

    public function assessments(): BelongsToMany
    {
        return $this->belongsToMany(Assessment::class, AssessmentQuestion::class, 'question_id', 'assessment_id');
    }

    public function control(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(FrameworkControl::class,'id','control_id');
    }

    public function answers(): HasMany
    {
        return $this->hasMany(AssessmentAnswer::class /*'question_id', 'id'*/);
    }

    public function parentAnswers(): BelongsToMany
    {
        return $this->belongsToMany(AssessmentAnswer::class, 'answer_sub_questions', 'answer_id', 'question_id');
    }

    public function ContactQuestionnaireAnswerResult()
    {
        return $this->hasMany(ContactQuestionnaireAnswerResult::class);
    }


}
