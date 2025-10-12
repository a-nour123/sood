<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionnaireRisk extends Model
{
    use HasFactory;

    protected $table = 'questionnaire_risks';

    protected $guarded = [];


    public function questionnaire()
    {
        return $this->belongsTo(Questionnaire::class, 'questionnaire_id');
    }

    public function answer()
    {
        return $this->belongsTo(AssessmentAnswer::class, 'answer_id');
    }


}
