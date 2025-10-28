<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ThirdPartyEvaluation extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function requests(): BelongsToMany
    {
        return $this->belongsToMany(EvaluationRequest::class, 'evaluation_request');
    }
}
