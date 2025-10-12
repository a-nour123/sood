<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LMSAnswer extends Model
{
    use HasFactory;
    protected $table = 'l_m_s_answers';
    protected $guarded = [];
    public function question()
    {
        return $this->belongsTo(LMSQuestion::class);
    }
}
