<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PhishingTemplate extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'phishing_templates';
    protected $guarded = ['id'];

    public function senderProfile()
    {
        return $this->belongsTo(PhishingSenderProfile::class);
    }

    public function website()
    {
        return $this->belongsTo(PhishingWebsitePage::class,'phishing_website_id');
    }

    public function campaignes()
    {
        return $this->belongsToMany(PhishingCampaign::class,'phishing_campaign_email_template','email_template_id','campaign_id');
    }

    public function employees()
    {
        return $this->belongsToMany(User::class,'phishing_mail_trackings','email_id','employee_id');
    }

    public function mailTracking()
    {
        return $this->hasMany(PhishingMailTracking::class,'email_id');
    }
    public function openedMails()
    {
        return $this->hasMany(PhishingMailTracking::class,'email_id')->whereNotNull('opened_at');
    }

    public function submitedDataInMails()
    {
        return $this->hasMany(PhishingMailTracking::class,'email_id')->whereNotNull('submited_at');
    }

    public function downloadedFileInMails()
    {
        return $this->hasMany(PhishingMailTracking::class,'email_id')->whereNotNull('downloaded_at');
    }

    public function clickedOnLink()
    {
        return $this->hasMany(PhishingMailTracking::class,'email_id')->whereNotNull('Page_link_clicked_at');
    }

}
