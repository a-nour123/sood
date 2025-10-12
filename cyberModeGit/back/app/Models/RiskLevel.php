<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiskLevel extends Model
{
    use HasFactory;
    public $guarded = [];
    public $timestamps = false;

    public function review_level()
    {
        return $this->belongsTo(ReviewLevel::class);
    }
}
