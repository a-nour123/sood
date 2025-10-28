<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncidentFile extends Model
{
    use HasFactory;

    public $guarded = [];

    public $timestamps = false;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
    ];
    

    public function incident()
    {
        return $this->belongsTo(Incident::class);
    }
}
