<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiskCatalog extends Model
{
    use HasFactory;
    use Auditable;
    protected $fillable = ['risk_grouping_id', 'risk_function_id', 'number', 'name', 'description', 'order'];
    // public $guarded = [];
    public $timestamps = false;
    public function Risk_grouping()
    {
        return $this->belongsTo(RiskGrouping::class,'risk_grouping_id');
    }
    public function Risk_functions()
    {
        return $this->belongsTo(RiskFunction::class,'risk_function_id');
    }
}
