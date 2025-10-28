<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LMSCourse extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'l_m_s_courses';
    protected $guarded = [];

    public function levels()
    {
        return $this->hasMany(LMSLevel::class,'course_id');
    }

    public function training_modules()
    {
        return $this->hasManyThrough(LMSTrainingModule::class,LMSLevel::class,'course_id','level_id');
    }

    public function questions()
    {
        return $this->hasManyThrough(LMSQuestion::class,LMSTrainingModule::class,'level_id','training_module_id');
    }

    public function statements()
    {
        return $this->hasManyThrough(LMSStatement::class,LMSTrainingModule::class,'level_id','training_module_id');
    }


}
