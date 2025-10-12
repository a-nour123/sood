<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ControlPriority extends Model
{
    use HasFactory;
    use Auditable;
    public $guarded = [];
    public $timestamps = false;
    protected $table = 'control_priorities';

}
