<?php

namespace App\Exports;

use App\Models\Job;
use App\Traits\LaravelExportPropertiesTrait;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithProperties;

class JobsExport implements FromCollection, WithMapping, WithHeadings, WithProperties
{

    use LaravelExportPropertiesTrait; // This trait implement properties function required by (WithProperties)
    private $counter = 1;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Job::with('employees')->get();
    }

    /**
     * @var Job $job
     */
    public function map($job): array
    {
        $jobNames = $job->employees()->pluck('name');
        if (count($jobNames))
            // $jobNames =  "(" . implode('), (', $jobNames->toArray()) . ")";
            $jobNames =  implode(', ', $jobNames->toArray());
        else
            $jobNames = '';

        return [
            $this->counter++,
            $job->name,
            $job->code,
            $job->description,
            $jobNames,
            $job->created_at->format('Y-m-d H:i')
        ];
    }


    public function headings(): array
    {
        return [
            __('locale.#'),
            __('locale.Name'),
            __('locale.Code'),
            __('locale.Description'),
            __('locale.Employees'),
            __('locale.CreatedDate')
        ];
    }
}
