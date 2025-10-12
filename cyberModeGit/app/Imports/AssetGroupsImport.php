<?php

namespace App\Imports;

use App\Models\AssetGroup;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class AssetGroupsImport implements
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
            $existingJobWithTheSameName = AssetGroup::where('name', $jobName)->first();


            // Check if an control objective with the same name already exists
            if (!$existingJobWithTheSameName) {
                AssetGroup::create([
                    'name' => $row[$this->columnsMapping['name']] ?? null,
                ]);
            }
        }
    }

    public function rules(): array /* WithValidation */
    {
        $name = !empty($this->columnsMapping['name']) ? $this->columnsMapping['name'] : '(name)';
        return [
            $name => ['required', 'max:100', 'unique:asset_groups,name'],
        ];
    }
}
