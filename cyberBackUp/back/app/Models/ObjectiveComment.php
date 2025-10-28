<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObjectiveComment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'control_control_objective_id', 'comment', 'file_display_name', 'file_unique_name'];

    public function controlControlObjective()
    {
        return $this->belongsTo(ControlControlObjective::class);
    }

    /**
     * Get creator of comment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
