<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LMSTrainingModule extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'l_m_s_training_modules';
    protected $guarded = [];

    public function questions()
    {
        return $this->hasMany(LMSQuestion::class,'training_module_id');
    }

    public function statements()
    {
        return $this->hasMany(LMSStatement::class,'training_module_id');
    }

    public function level()
    {
        return $this->belongsTo(LMSLevel::class);
    }

    public function compliances()
    {
        return $this->belongsToMany(FrameworkControl::class,'l_m_s_compliance_training_modules','training_module_id','framework_control_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class,'l_m_s_user_training_modules','training_module_id','user_id')
                    ->withPivot('score', 'passed', 'unlocked', 'completed_at','days_until_due','count_of_entering_exam')
                    ->withTimestamps();
    }

    public function campaigns()
    {
        return $this->belongsToMany(PhishingCampaign::class,'phising_campaign_training_module','training_module_id','campaign_id');
    }
}
