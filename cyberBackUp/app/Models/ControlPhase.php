<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\FrameworkControl;
class ControlPhase extends Model
{
    use HasFactory;
    use Auditable;
    public $guarded = [];
    public $timestamps = false;
    protected $fillable = ['id','name'];
    protected $table = 'control_phases';

    
}
