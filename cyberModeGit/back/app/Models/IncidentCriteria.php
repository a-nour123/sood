<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncidentCriteria extends Model
{
    use HasFactory;
    public $guarded = [];
    public $timestamps = false;


    public function IncidentScores()
    {
        return $this->hasMany(IncidentScore::class);
    }
}
