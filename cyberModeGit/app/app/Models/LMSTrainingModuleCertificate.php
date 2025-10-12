<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LMSTrainingModuleCertificate extends Model
{
    use HasFactory;
    protected $table = 'l_m_s_training_module_certificates';
    protected $guarded = [];

    public function campaign()
    {
        return $this->belongsTo(PhishingCampaign::class, 'campaign_id');
    }

    public function training()
    {
        return $this->belongsTo(LMSTrainingModule::class, 'training_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function template()
    {
        return $this->belongsTo(CertificateTemplate::class, 'template_id');
    }
}
