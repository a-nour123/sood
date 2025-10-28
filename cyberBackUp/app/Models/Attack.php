<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attack extends Model
{
    use HasFactory;
    use Auditable;

    public $guarded = [];

    public $timestamps = false;
}
