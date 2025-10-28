<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];

    public $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public $timestamps = false; // for table for GRC not for laravel base users table
    // public function User()
    // {
    //     return $this->hasMany(User::class,'user_id');
    // }
    public function permissions()
    {

        return DB::table('users')
            ->join('role_responsibilities', 'role_responsibilities.role_id', '=', 'users.role_id')
            ->join('permissions', 'permissions.id', '=', 'role_responsibilities.permission_id')
            ->select('permissions.key')
            ->where('users.id', '=', $this->id)
            ->where('role_responsibilities.role_id', '=', $this->role_id)
            ->get()->toArray();
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function hasPermission($name)
    {
        // $name = 'plan_mitigation.accept';
        $exist = auth()->user()->role->rolePermissions->where('key', $name)->first();
        // dd(auth()->user()->role->rolePermissions->pluck('key')->toArray());
        if ($exist)
            return true;
        return false;
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }


    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function managees()
    {
        return $this->hasMany(User::class, 'manager_id');
    }

    /**
     * Get the FrameworkControlTestComments for the user.
     */
    public function FrameworkControlTestComments()
    {
        return $this->hasMany(FrameworkControlTestComment::class);
    }

    /**
     * Get the created tasks by the user.
     */
    public function createdTasks()
    {
        return $this->hasMany(Task::class, 'created_by');
    }

    /**
     * Get the user's tasks.
     */
    public function tasks()
    {
        return $this->morphMany(Task::class, 'assignable');
    }

    /**
     * The teams that belong to the user.
     */
    public function teams()
    {
        return $this->belongsToMany(Team::class, 'user_to_teams');
    }

    public function questionnaires(): BelongsToMany
    {
        return $this->belongsToMany(Questionnaire::class, 'contact_questionnaires', 'user_id', 'questionnaire_id');
    }

    public function questionnaireAnswers()
    {
        return $this->hasMany(ContactQuestionnaireAnswer::class, 'id', 'contact_id');
    }

    public function campaignes()
    {
        return $this->belongsToMany(PhishingCampaign::class, 'phishing_campaign_employee_list', 'employee_id', 'campaign_id');
    }

    public function groups()
    {
        return $this->belongsToMany(PhishingGroup::class, 'phishing_group_users');
    }

    public function mailTemplates()
    {
        return $this->belongsToMany(PhishingTemplate::class, 'phishing_mail_trackings', 'employee_id', 'email_id');
    }

    public function campaigns()
    {
        return $this->belongsToMany(PhishingCampaign::class, 'phishing_campaign_employee_list', 'employee_id', 'campaign_id');
    }

    // relations

    public function deliverdCampaigns()
    {
        return $this->belongsToMany(PhishingCampaign::class, 'phishing_campaign_employee_list', 'employee_id', 'campaign_id')->wherePivot('is_delivered', 1);
    }

    public function notDeliverdCampaigns()
    {
        return $this->belongsToMany(PhishingCampaign::class, 'phishing_campaign_employee_list', 'employee_id', 'campaign_id')->wherePivot('is_delivered', 0);
    }

    public function mailTracking()
    {
        return $this->hasMany(PhishingMailTracking::class, 'employee_id');
    }
    public function openedMails()
    {
        return $this->mailTracking()->whereNotNull('opened_at');
    }

    public function submitedDataInMails()
    {
        return $this->mailTracking()->whereNotNull('submited_at');
    }

    public function downloadedFileInMails()
    {
        return $this->mailTracking()->whereNotNull('downloaded_at');
    }

    public function clickedLinkInMails()
    {
        return $this->mailTracking()->whereNotNull('Page_link_clicked_at');
    }

    public function trainingModules()
    {
        return $this->belongsToMany(LMSTrainingModule::class, 'l_m_s_user_training_modules', 'user_id', 'training_module_id')
            ->withPivot('score', 'passed', 'unlocked', 'completed_at', 'days_until_due', 'count_of_entering_exam', 'survey_completed')
            ->withTimestamps();
    }

    public function levels()
    {
        return $this->belongsToMany(LMSLevel::class, 'l_m_s_user_levels', 'user_id', 'level_id')
            ->withPivot('completed', 'unlocked', 'completed_at')
            ->withTimestamps();
    }


    // User Physical Courses
    public function instructedCourses()
    {
        return $this->belongsToMany(Course::class, 'course_instructor');
    }

    public function courseRequests()
    {
        return $this->hasMany(CourseRequest::class);
    }

    public function courseAttendances()
    {
        return $this->hasMany(CourseAttendance::class);
    }

    public function courseGrades()
    {
        return $this->hasMany(CourseGrade::class);
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(CourseCertificate::class);
    }

    // lms certificates
    public function trainingCertificates(): HasMany
    {
        return $this->hasMany(LMSTrainingModuleCertificate::class);
    }

    public function courseSurveyResponses()
    {
        return $this->hasMany(SurveyResponse::class, 'user_id')
            ->where('respondent_type', 'course');
    }

    public function trainingSurveyResponses()
    {
        return $this->hasMany(SurveyResponse::class, 'user_id')
            ->where('respondent_type', 'training_module');
    }


}
