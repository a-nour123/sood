<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;
    use Auditable;
    public $guarded = [];
    public $timestamps = false;

    /**
     * The users that belong to the team.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_to_teams');
    }

    /**
     * Get the team's tasks.
     */
    public function tasks()
    {
        return $this->morphMany(Task::class, 'assignable');
    }

    /**
     * Get the vulnerabilities associated with the team.
     */
    public function vulnerabilities()
    {
        return $this->belongsToMany(Vulnerability::class, 'team_vulnerabilities');
    }
}
