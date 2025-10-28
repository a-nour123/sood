<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiskGrouping extends Model
{
    use HasFactory;
    use Auditable;
    public $guarded = [];
    public $timestamps = false;

    public function Risk_catalog()
    {
        return $this->hasMany(RiskCatalog::class,'risk_catalog_id');
    }

    public function RiskCatalogs()
    {
        return $this->hasMany(RiskCatalog::class);
    }
}
