<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evidence extends Model
{
    use HasFactory;

    protected $table = 'evidences';
    
    protected $fillable = [
        'control_control_objective_id',
        'creator_id',
        'description',
        'file_name',
        'file_unique_name'
    ];

    public function controlControlObjective()
    {
       return $this->belongsTo(ControlControlObjective::class);
    }

    public function creator()
    {
       return $this->belongsTo(User::class, 'creator_id');
    }
}
