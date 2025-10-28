<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyResponse extends Model
{
    use HasFactory;
    protected $table = 'survey_responses';
    public $timestamps = true;

    protected $fillable = [
        'survey_id',
        'user_id',
        'respondent_type', // 'course' or 'training_module'
        'respondent_id',   // course_id or training_module_id
        'completed_at',
        'is_completed',
        'ip_address',
        'user_agent'
    ];

    protected $casts = [
        'completed_at' => 'datetime',
        'is_completed' => 'boolean'
    ];

    public function survey()
    {
        return $this->belongsTo(AwarenessSurvey::class, 'survey_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'respondent_id')
            ->where('respondent_type', 'course');
    }

    public function trainingModule()
    {
        return $this->belongsTo(LMSTrainingModule::class, 'respondent_id')
            ->where('respondent_type', 'training_module');
    }

    public function questionAnswers()
    {
        return $this->hasMany(SurveyQuestionAnswer::class, 'response_id');
    }

    public function getRespondentAttribute()
    {
        if ($this->respondent_type === 'course') {
            return $this->course;
        } elseif ($this->respondent_type === 'training_module') {
            return $this->trainingModule;
        }
        return null;
    }

    public function markAsCompleted()
    {
        $this->update([
            'is_completed' => true,
            'completed_at' => now()
        ]);
    }

    public function getCompletionPercentage()
    {
        $totalQuestions = $this->survey->questions()->count();
        $answeredQuestions = $this->questionAnswers()->count();

        if ($totalQuestions == 0)
            return 0;

        return round(($answeredQuestions / $totalQuestions) * 100, 2);
    }
}
