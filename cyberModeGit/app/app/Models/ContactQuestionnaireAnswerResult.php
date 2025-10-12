<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactQuestionnaireAnswerResult extends Model
{
    use HasFactory;

    protected $table = 'contact_questionnaire_answer_results';

    protected $guarded = [];

    public function contactQuestionnaireAnswer()
    {
        return $this->belongsTo(ContactQuestionnaireAnswer::class, 'contact_questionnaire_answer_id');
    }

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id', 'id');
    }

    public function Answer()
    {
        return $this->belongsTo(AssessmentAnswer::class, 'answer_id');
    }

}
