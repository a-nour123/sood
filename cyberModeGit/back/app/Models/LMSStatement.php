<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LMSStatement extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'l_m_s_statements';
    protected $guarded = [];

    public function trainingModule()
    {
        return $this->belongsTo(LMSTrainingModule::class);
    }
}
