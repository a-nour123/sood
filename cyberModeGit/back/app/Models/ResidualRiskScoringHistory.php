<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResidualRiskScoringHistory extends Model
{
    use HasFactory;

    public $guarded = [];

    public $timestamps = false;

    public function risk()
{
    return $this->belongsTo(Risk::class);
}
}
