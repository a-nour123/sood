<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PhishingLandingPage extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'phishing_landing_pages';
    protected $guarded = ['id'];

    public function website()
    {
        return $this->belongsTo(PhishingWebsitePage::class,'website_page_id');
    }
}
