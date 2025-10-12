<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KPIAssessment extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'kpi_assessments';

    public $guarded = [];

    public function kpi()
    {
        return $this->belongsTo(KPI::class, 'kpi_id');
    }

    public function created_by_user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function action_by_user()
    {
        return $this->belongsTo(User::class, 'action_by');
    }
    public function assigned_To()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'assessment_date' => 'datetime',
    ];
}
