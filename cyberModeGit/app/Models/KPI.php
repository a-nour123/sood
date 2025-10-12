<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KPI extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'kpis';

    public $guarded = [];

    public function created_by_user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function assessments()
    {
        return $this->hasMany(KPIAssessment::class, 'kpi_id')->with('created_by_user:id,username', 'action_by_user:id,username');
    }

    public function hasRelations()
    {
        $relations = [
            'Assessments' => $this->assessments()->count(),
        ];

        // Filter out empty relations
        return array_filter($relations, fn($count) => $count > 0);
    }
}
