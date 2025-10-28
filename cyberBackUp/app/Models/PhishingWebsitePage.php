<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PhishingWebsitePage extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'phishing_website_pages';
    protected $guarded = ['id'];

    public function category()
    {
        return $this->belongsTo(PhishingCategory::class,'phishing_category_id');
    }
    public function landingpages()
    {
        return $this->hasMany(PhishingLandingPage::class);
    }
    public function domain()
    {
        return $this->belongsTo(PhishingDomains::class,'domain_id');
    }

    public function mailTemplates()
    {
        return $this->hasMany(PhishingTemplate::class,'phishing_website_id');
    }
}
