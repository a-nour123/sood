<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LMSOption extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'l_m_s_options';
    protected $guarded = [];
    public function question()
    {
        return $this->belongsTo(LMSQuestion::class,'question_id');
    }
}
