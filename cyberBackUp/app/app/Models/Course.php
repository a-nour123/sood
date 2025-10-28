<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'grade',
        'max_seats',
        'cover_picture',
        'open_registration',
        'course_complete',
        'passing_grade',
        'certificate_template_id',
        'auto_send_certificate',
        'survey_id',
    ];

    public function schedules(): HasMany
    {
        return $this->hasMany(CourseSchedule::class);
    }

    public function materials(): HasMany
    {
        return $this->hasMany(CourseMaterial::class);
    }

    public function instructors(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'course_instructor');
    }

    public function requests(): HasMany
    {
        return $this->hasMany(CourseRequest::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(CourseAttendance::class);
    }

    public function grades(): HasMany
    {
        return $this->hasMany(CourseGrade::class);
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(CourseCertificate::class);
    }

    public function certificateTemplate()
    {
        return $this->belongsTo(CertificateTemplate::class, 'certificate_template_id');
    }

    public function surveyResponses(): HasMany
    {
        return $this->hasMany(SurveyResponse::class, 'respondent_id')
            ->where('respondent_type', 'course');
    }

    public function survey()
    {
        return $this->belongsTo(AwarenessSurvey::class, 'survey_id');
    }
}

