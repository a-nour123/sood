<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LMSQuestion extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'l_m_s_questions';
    protected $guarded = [];

    public function trainingModule()
    {
        return $this->belongsTo(LMSTrainingModule::class);
    }

    public function options()
    {
        return $this->hasMany(LMSOption::class,'question_id');
    }
}
