<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiskScoring extends Model
{
    use HasFactory;
    public $guarded = [];

    public $timestamps = false;

    public function classicImpact()
    {
        return $this->belongsTo(Impact::class, 'CLASSIC_impact');
    }

    public function classicLikelihood()
    {
        return $this->belongsTo(Likelihood::class, 'CLASSIC_likelihood');
    }
}
