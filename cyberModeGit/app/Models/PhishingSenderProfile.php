<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PhishingSenderProfile extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'phishing_sender_profiles';
    protected $guarded = ['id'];

    public function domain()
    {
        return $this->belongsTo(PhishingDomains::class,'website_domain_id');
    }

    public function mailTemplates()
    {
        return $this->hasMany(PhishingTemplate::class,'sender_profile_id');
    }
}
