<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regulator extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function frameworks(){
        return $this->hasMany(Framework::class);
    }
}
