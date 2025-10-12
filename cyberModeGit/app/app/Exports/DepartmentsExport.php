<?php

namespace App\Exports;

use App\Models\Department;
use App\Traits\LaravelExportPropertiesTrait;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithProperties;

class DepartmentsExport implements FromCollection, WithMapping, WithHeadings, WithProperties
{

    use LaravelExportPropertiesTrait; // This trait implement properties function required by (WithProperties)
    private $counter = 1;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Department::with('manager', 'parentDepartment', 'departments')->get();
    }

    /**
     * @var Department $department
     */
    public function map($department): array
    {
        $departmentChildren = $department->departments()->pluck('name');
        if (count($departmentChildren))
            // $departmentChildren =  "(" . implode('), (', $departmentChildren->toArray()) . ")";
            $departmentChildren =  implode(', ', $departmentChildren->toArray());
        else
            $departmentChildren = '';

        return [
            $this->counter++,
            $department->name,
            $department->code,
            $department->parentDepartment ? $department->parentDepartment->name : '',
            $departmentChildren,
            $department->required_num_emplyees,
            $department->employees()->count() ? $department->employees()->count() : '',
            $department->manager ? $department->manager->name : '',
            $department->color ? $department->color->name : '',
            $department->created_at->format('Y-m-d H:i')
        ];
    }

    public function headings(): array
    {
        return [
            __('locale.#'),
            __('locale.Name'),
            __('locale.Code'),
            __('locale.ParentDepartment'),
            __('locale.ChildDepartments'),
            __('locale.RequiredNumberOfEmplyees'),
            __('locale.ActualNumberOfEmplyees'),
            __('locale.Manager'),
            __('locale.Color'),
            __('locale.CreatedDate')
        ];
    }
}
