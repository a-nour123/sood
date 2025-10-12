<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CloseReason;
class Closure extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'risk_id',
        'user_id',
        'closure_date',
        'close_reason',
        'note'
    ];

    

     /**
     * Get the Risk that owns the Closure.
     */
    public function risk()
    {
        return $this->belongsTo(Risk::class);
    }
    // public function closereasons()
    // {
    //     return $this->belongsTo(CloseReason::class, 'close_reason');
    // }

    

}
