<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NdaReceiver extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function nda()
    {
        return $this->belongsTo(Nda::class, 'nda_id');
    }
   
    
}