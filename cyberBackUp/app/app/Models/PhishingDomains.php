<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PhishingDomains extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'phishing_domains';
    protected $guarded = [];

    public function profiles()
    {
        return $this->hasMany(PhishingSenderProfile::class,'website_domain_id');
    }
}
