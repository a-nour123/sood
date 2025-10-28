<?php

namespace App\Imports;

use App\Models\Department;
use App\Models\DepartmentColor;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class DepartmentsImport implements
    ToCollection,
    WithHeadingRow,
    WithValidation
{
    use Importable;

    /**
     * Mapping of columns from the import file to database columns.
     *
     * @var array
     */
    public $columnsMapping;

    /**
     * Constructor to set the columns mapping.
     *
     * @param array $columnsMapping
     */
    public function __construct($columnsMapping)
    {
        $this->columnsMapping = $columnsMapping;
    }


    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $departmentName = $row[$this->columnsMapping['name']] ?? null;
            $departmentCode = $row[$this->columnsMapping['code']] ?? null;
            $existingDepartmentWithTheSameName = Department::where('name', $departmentName)->first();
            $existingDepartmentWithTheSameCode = Department::where('code', $departmentCode)->first();

            $departmentColor = $row[$this->columnsMapping['color_id']] ?? null;
            $departmentColorId = DepartmentColor::where('name', $departmentColor)->pluck('id')->first();


            $departmentParent = $row[$this->columnsMapping['parent_id']] ?? null;
            $departmentParentId = Department::where('name', $departmentParent)->pluck('id')->first();

            $departmentManager = $row[$this->columnsMapping['manager_id']] ?? null;
            $departmentManagerId = User::where('name', $departmentManager)->pluck('id')->first();
            // Check if a department with the same name already exists
            if (!$existingDepartmentWithTheSameName && !$existingDepartmentWithTheSameCode) {
                Department::create([
                    'name' => $row[$this->columnsMapping['name']] ?? null,
                    'code' => $row[$this->columnsMapping['code']] ?? null,
                    'color_id' => $departmentColorId ?? null,
                    'parent_id' => $departmentParentId,
                    'manager_id' => $departmentManagerId,
                    'required_num_emplyees' => $row[$this->columnsMapping['required_num_emplyees']] ?? null,
                    'vision' => $row[$this->columnsMapping['vision']] ?? null,
                    'message' => $row[$this->columnsMapping['message']] ?? null,
                    'mission' => $row[$this->columnsMapping['mission']] ?? null,
                    'objectives' => $row[$this->columnsMapping['objectives']] ?? null,
                    'responsibilities' => $row[$this->columnsMapping['responsibilities']] ?? null,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }
        }
    }

    public function rules(): array /* WithValidation */
    {
        $name = !empty($this->columnsMapping['name']) ? $this->columnsMapping['name'] : '(name)';
        $color_id = !empty($this->columnsMapping['color_id']) ? $this->columnsMapping['color_id'] : '(color_id)';
        return [
            $name => ['required', 'max:100', 'unique:departments,name'],
            $this->columnsMapping['code'] => ['nullable', 'max:10', 'unique:departments,code'],
            // $color_id => ['required', 'exists:department_colors,name'],
            $this->columnsMapping['manager_id'] => ['nullable', 'exists:users,name'],
            $this->columnsMapping['parent_id'] => ['nullable', 'exists:departments,name'],
            $this->columnsMapping['manager_id'] => ['nullable', 'exists:users,name'],
            $this->columnsMapping['required_num_emplyees'] => ['nullable', 'integer'],
            $this->columnsMapping['vision'] => ['nullable', 'string'],
            $this->columnsMapping['message'] => ['nullable', 'string'],
            $this->columnsMapping['mission'] => ['nullable', 'string'],
            $this->columnsMapping['objectives'] => ['nullable', 'string'],
            $this->columnsMapping['responsibilities'] => ['nullable', 'string'],
        ];
    }
}
