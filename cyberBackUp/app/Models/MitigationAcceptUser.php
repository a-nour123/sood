<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MitigationAcceptUser extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $guarded = [];

    public function risk()
    {
        return $this->belongsTo(Risk::class, 'risk_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
