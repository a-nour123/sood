<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NdaResult extends Model
{
    use HasFactory;
    use HasFactory;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
        public function nda()
    {
        return $this->belongsTo(Nda::class, 'nda_id');
    }
}