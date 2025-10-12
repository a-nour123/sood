<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ThirdPartyProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'third_party_name',
        'owner',
        'date_of_incorporation',
        'place_of_incorporation',
        'head_office_location',
        'contract_term',
        'third_party_classification_id',
        'agreement',
        'domain',
    ];

    public function requests(): HasMany
    {
        return $this->hasMany(ThirdPartyRequest::class);
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(ThirdPartyProfileContact::class);
    }

    public function entities(): HasMany
    {
        return $this->hasMany(ThirdPartyProfileEntity::class);
    }

    public function subsidiaries(): HasMany
    {
        return $this->hasMany(ThirdPartyProfileSubsidiary::class);
    }

    public function classification(): BelongsTo
    {
        return $this->belongsTo(ThirdPartyClassification::class, 'third_party_classification_id');
    }
}
