<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AnswerQuestionSurvey ;
class SurveyQuestion extends Model
{
    use HasFactory;
    protected $table = 'survey_questions';
    public $timestamps = true;
    protected $fillable=['question','survey_id','option_A','option_B','option_C','option_D','option_E','answer_type'];   
    // ,'answer'
    
    public function answers()
    {
        return $this->belongsTO(AnswerQuestionSurvey::class , 'id', 'question_id');
    }
}

