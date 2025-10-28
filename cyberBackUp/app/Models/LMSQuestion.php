<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LMSQuestion extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'l_m_s_questions';
    protected $guarded = [];

    protected static function booted()
    {
        static::deleting(function ($question) {
            $question->options()->delete();
            $question->answers()->delete();
        });
    }
    public function trainingModule()
    {
        return $this->belongsTo(LMSTrainingModule::class);
    }

    public function options()
    {
        return $this->hasMany(LMSOption::class, 'question_id');
    }

    public function answers()
    {
        return $this->hasMany(LMSAnswer::class, 'question_id');
    }
}
