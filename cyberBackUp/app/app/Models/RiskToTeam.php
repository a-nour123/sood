<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Events\RiskTeamCreated;
class RiskToTeam extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $guarded = [];
    protected $dispatchesEvents=[
        'created'=>RiskTeamCreated::class
];

}
