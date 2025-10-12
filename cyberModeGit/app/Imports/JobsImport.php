<?php

namespace App\Imports;

use App\Models\Job;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class JobsImport implements
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
            $jobName = $row[$this->columnsMapping['name']] ?? null;
            $jobCode = $row[$this->columnsMapping['code']] ?? null;
            $existingJobWithTheSameName = Job::where('name', $jobName)->first();
            $existingJobWithTheSameCode = Job::where('code', $jobCode)->first();

            // Check if an control objective with the same name already exists
            if (!$existingJobWithTheSameName && !$existingJobWithTheSameCode) {
                Job::create([
                    'name' => $row[$this->columnsMapping['name']] ?? null,
                    'code' => $row[$this->columnsMapping['code']] ?? null,
                    'description' => $row[$this->columnsMapping['description']] ?? null,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }
        }
    }

    public function rules(): array /* WithValidation */
    {
        $name = !empty($this->columnsMapping['name']) ? $this->columnsMapping['name'] : '(name)';
        $description = !empty($this->columnsMapping['description']) ? $this->columnsMapping['description'] : '(description)';
        return [
            $name => ['required', 'max:100', 'unique:jobs,name'],
            $this->columnsMapping['code'] => ['nullable', 'max:10', 'unique:jobs,code'],
            $description => ['required', 'max:500']
        ];
    }
}
