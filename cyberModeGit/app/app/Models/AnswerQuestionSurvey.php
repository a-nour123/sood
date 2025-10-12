<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;



class AnswerQuestionSurvey extends Model
{
    use HasFactory;
    
    protected $table = 'answer_question_surveys';
    public $timestamps = true;
    protected $fillable=['question_id','answer','user_id','draft','user_idOut','survey_id'];
 

    public function answers()
    {
        return $this->belongsTO(AnswerQuestionSurvey::class , 'id', 'question_id');
    }
    public function users()
    {
        return $this->belongsTO(User::class , 'user_id');
    }

  
}
