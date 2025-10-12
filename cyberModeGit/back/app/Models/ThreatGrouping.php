<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThreatGrouping extends Model
{
    use HasFactory;
    public $guarded = [];

    public $timestamps = false;
    public function Threate_catalog()
    {
        return $this->hasMany(ThreatCatalog::class, 'risk_catalog_id');
    }

    public function ThreatCatalogs()
    {
        return $this->hasMany(ThreatCatalog::class);
    }
}
