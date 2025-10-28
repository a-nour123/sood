<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FrameworkControlTestResultsToRisk extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'test_results_id',
        'risk_id'
    ];

    public function frameworkControlTestAudits()
    {
        return $this->belongsTo(FrameworkControlTestAudit::class,  'test_results_id');
    }

}
