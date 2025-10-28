<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiskToTechnology extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $guarded = [];
    public $table = 'risk_to_technologies';
    protected $fillable = [
        'risk_id',
        'technology_id'
    ];
}
