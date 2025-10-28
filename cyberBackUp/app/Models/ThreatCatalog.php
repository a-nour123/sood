<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThreatCatalog extends Model
{
    use HasFactory;
    public $guarded = [];

    public $timestamps = false;
    public function Threate_grouping()
    {
        return $this->belongsTo(ThreatGrouping::class,'threat_grouping_id');
    }
}
