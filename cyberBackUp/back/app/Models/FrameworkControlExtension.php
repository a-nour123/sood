<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FrameworkControlExtension extends Model
{
    use HasFactory;

    protected $table = 'framework_controls_extension';

    protected $fillable = [
        'control_id',
        'extend_control_id',
    ];

    public function control()
    {
        return $this->belongsTo(FrameworkControl::class, 'control_id');
    }

    public function extendControl()
    {
        return $this->belongsTo(FrameworkControl::class, 'extend_control_id');
    }
}
