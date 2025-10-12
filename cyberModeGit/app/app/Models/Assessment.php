<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Assessment extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'assessments';
    protected $guarded = [];

    /**
     * @return HasMany
     */
    public function questions(): BelongsToMany
    {
        return $this->belongsToMany(Question::class, AssessmentQuestion::class, 'assessment_id', 'question_id');
    }
}
