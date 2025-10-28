<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncidentUser extends Model
{
    use HasFactory;

    public $guarded = [];

    public $timestamps = false;
}
