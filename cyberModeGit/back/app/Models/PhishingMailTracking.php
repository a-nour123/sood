<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhishingMailTracking extends Model
{
    use HasFactory;
    protected $table = 'phishing_mail_trackings';
    protected $guarded = ['id'];

    public function campaign()
    {
        return $this->belongsTo(PhishingCampaign::class);
    }

    public function email()
    {
        return $this->belongsTo(PhishingTemplate::class);
    }

    /**
     * Relationship with Employee
     */
    public function employee()
    {
        return $this->belongsTo(User::class);
    }
}
