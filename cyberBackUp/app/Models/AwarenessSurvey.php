<?php

namespace App\Models;
use App\Models\Privacy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AwarenessSurvey extends Model
{
    use HasFactory;


    protected $table = 'awareness_surveys';
    public $timestamps = true;
    protected $fillable = ['name', 'additional_stakeholder', 'owner_id', 'team', 'last_review_date', 'created_by', 'review_frequency', 'next_review_date', 'description', 'filter_status', 'reviewer', 'approval_date', 'privacy', 'all_questions_mandatory', 'answer_percentage', 'percentage_number', 'specific_mandatory_questions', 'questions'];

    // relation between AwarenessSurvey model and status model to get status column
    public function status()
    {
        return $this->belongsTo('App\Models\DocumentStatus', 'filter_status');
    }
    // relation between AwarenessSurvey model and users model to get owner column
    public function ownerName()
    {
        return $this->belongsTo('App\Models\User', 'owner_id');
    }
    // relation between AwarenessSurvey model and privacy model to get privacy name column
    public function test_priv()
    {
        return $this->belongsTo('App\Models\Privacy', 'privacy');
    }
    public function exam()
    {
        return $this->hasOne(SurveyQuestion::class, 'survey_id')->with('answers')->withCount('questions');
    }

    public function survyQuestions()
    {
        return $this->hasMany(SurveyQuestion::class, 'survey_id');
    }

    public function created_by_user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function teams()
    {
        return $this->belongsToMany(Team::class, 'team');
    }
    // public function teams()
    // {
    //     return $this->belongsToMany(Team::class, 'user_to_teams');
    // }
    // public function users()
    // {
    //     return $this->belongsToMany(User::class, 'user_to_teams');
    // }
    // public function team()
    // {
    // return $this->belongsToMany(Team::class);
    // }
    // public function users()
    // {
    //     return $this->belongsToMany(User::class);
    // }

}
