<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Events\mitigationTeamCreated;
class MitigationToTeam extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'mitigation_id',
        'team_id',

    ];
    protected $dispatchesEvents=[
        'created'=>mitigationTeamCreated::class
    ];
}
