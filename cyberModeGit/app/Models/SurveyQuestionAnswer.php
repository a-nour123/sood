<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyQuestionAnswer extends Model
{
    use HasFactory;
    protected $table = 'survey_question_answers';
    public $timestamps = true;

    protected $fillable = [
        'response_id',
        'question_id',
        'answer_text',
        'selected_option', // A, B, C, D, E for multiple choice
        'is_draft'
    ];

    protected $casts = [
        'is_draft' => 'boolean'
    ];

    public function response()
    {
        return $this->belongsTo(SurveyResponse::class, 'response_id');
    }

    public function question()
    {
        return $this->belongsTo(SurveyQuestion::class, 'question_id');
    }

    public function user()
    {
        return $this->response->user();
    }
}
