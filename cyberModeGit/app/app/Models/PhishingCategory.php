<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PhishingCategory extends Model
{
    use HasFactory,SoftDeletes,Auditable;
    protected $table = 'phishing_categories';
    public $guarded = [];

    public function websites()
    {
        return $this->hasMany(PhishingWebsitePage::class,'phishing_category_id');
    }
}
