<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiskFunction extends Model
{
    use HasFactory;
    use Auditable;
    public $guarded = [];
    public $timestamps = false;
    public function Risk_function()
    {
        return $this->hasMany(RiskCatalog::class,'risk_catalog_id');
    }
}
