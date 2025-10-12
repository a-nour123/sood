<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PolicyAdoptionConfig extends Model
{
    use HasFactory;

    protected $fillable = [
        'policy_adoption_id',
        'reviewer_id',
        'owner_id',
        'authorized_person_id',
    ];

    // Relations
    public function policyAdoption()
    {
        return $this->belongsTo(PolicyAdoption::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function authorizedPerson()
    {
        return $this->belongsTo(User::class, 'authorized_person_id');
    }
}