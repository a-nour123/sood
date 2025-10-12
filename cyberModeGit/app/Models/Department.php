<?php

namespace App\Models;

use App\Events\DepartmentCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    public $guarded = [];
    public $fillable = [
        'name',
        'code',
        'manager_id',
        'parent_id',
        'required_num_emplyees',
        'color_id',
        'vision',
        'message',
        'mission',
        'objectives',
        'responsibilities',
    ];
    // protected $dispatchesEvents = [
    //     'created' => DepartmentCreated::class,
    // ];
    public function manager()
    {
        return $this->hasOne(User::class, 'id', 'manager_id');
    }
    
    public function parentDepartment()
    {
        return $this->belongsTo(Department::class, 'parent_id');
    }

    public function departments()
    {
        return $this->hasMany(Department::class, 'parent_id')->with('departments');
    }

    public function departmentsWithoutChilddren()
    {
        return $this->hasMany(Department::class, 'parent_id');
    }

    public function employees()
    {
        return $this->hasMany(User::class, 'department_id');
    }

    public function color()
    {
        return $this->hasOne(DepartmentColor::class, 'id', 'color_id');
    }

    public function KPIs()
    {
        return $this->hasMany(KPI::class, 'department_id');
    }

    public function hasRelations()
    {
        $relations = [
            'Manager' => $this->manager()->exists(),
            'Parent Department' => $this->parentDepartment()->exists(),
            'Sub-Departments' => $this->departments()->count(),
            'Employees' => $this->employees()->count(),
            'KPIs' => $this->KPIs()->count(),
        ];

        // Filter out empty relations
        return array_filter($relations, fn($count) => $count > 0);
    }
    
}
