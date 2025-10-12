<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PhishingCampaign extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'phishing_campaigns';
    protected $guarded = [];

    public function emailTemplates()
    {
        return $this->belongsToMany(PhishingTemplate::class, 'phishing_campaign_email_template', 'campaign_id', 'email_template_id');
    }

    public function employees()
    {
        return $this->belongsToMany(User::class, 'phishing_campaign_employee_list', 'campaign_id', 'employee_id');
    }

    public function deliverdEmailTemplates()
    {
        return $this->belongsToMany(PhishingTemplate::class, 'phishing_campaign_email_template', 'campaign_id', 'email_template_id')->wherePivot('is_delivered', 1);
    }

    public function deliverdEmployees()
    {
        return $this->belongsToMany(User::class, 'phishing_campaign_employee_list', 'campaign_id', 'employee_id')->wherePivot('is_delivered', 1);
    }

    public function notDeliverdEmailTemplates()
    {
        return $this->belongsToMany(PhishingTemplate::class, 'phishing_campaign_email_template', 'campaign_id', 'email_template_id')->wherePivot('is_delivered', 0);
    }

    public function notDeliverdEmployees()
    {
        return $this->belongsToMany(User::class, 'phishing_campaign_employee_list', 'campaign_id', 'employee_id')->wherePivot('is_delivered', 0);
    }


    //  Campaign Trackings
    public function emailTrackings()
    {
        return $this->hasMany(PhishingMailTracking::class, 'campaign_id');
    }

    public function openedTrackings()
    {
        return $this->emailTrackings()->whereNotNull('opened_at');
    }

    public function downloadedTrackings()
    {
        return $this->emailTrackings()->whereNotNull('downloaded_at');
    }

    public function clickedTrackings()
    {
        return $this->emailTrackings()->whereNotNull('Page_link_clicked_at');
    }

    public function submittedTrackings()
    {
        return $this->emailTrackings()->whereNotNull('submited_at');
    }


    // LMS
    public function trainingModules()
    {
        return $this->belongsToMany(LMSTrainingModule::class, 'phising_campaign_training_module', 'campaign_id', 'training_module_id');
    }

    public function userTraining()
    {
        return $this->belongsToMany(User::class, 'l_m_s_user_training_modules', 'campaign_id', 'user_id');
    }

    // certificates
    public function certificates(): HasMany
    {
        return $this->hasMany(LMSTrainingModuleCertificate::class);
    }


}
