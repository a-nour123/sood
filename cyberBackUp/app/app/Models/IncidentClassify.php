<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncidentClassify extends Model
{
    use HasFactory;
    public $guarded = [];
    public $timestamps = false;
}
