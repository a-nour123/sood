<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ThirdPartyRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'requested_by',
        'department_id',
        'job_id',
        'business_info',
        'status',
        'reject_reason',
        'third_party_profile_id',
        'third_party_service_id'
    ];

    public function profile(): BelongsTo
    {
        return $this->belongsTo(ThirdPartyProfile::class, 'third_party_profile_id');
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class, 'job_id');
    }
    public function service(): BelongsTo
    {
        return $this->belongsTo(ThirdPartyService::class, 'third_party_service_id');
    }
    public function evaluation(): BelongsToMany
    {
        return $this->belongsToMany(EvaluationRequest::class, 'evaluation_request');
    }
    public function questionnaires(): HasMany
    {
        return $this->hasMany(ThirdPartyQuestionnaire::class);
    }

}
