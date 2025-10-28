<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LMSLevel extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'l_m_s_levels';
    protected $guarded = [];


    public function training_modules()
    {
        return $this->hasMany(LMSTrainingModule::class,'level_id');
    }

    public function course()
    {
        return $this->belongsTo(LMSCourse::class);
    }

    public function questions()
    {
        return $this->hasManyThrough(LMSQuestion::class,LMSTrainingModule::class,'level_id','training_module_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class,'l_m_s_user_levels','level_id','user_id')
                    ->withPivot( 'completed', 'unlocked', 'completed_at')
                    ->withTimestamps();
    }

}
