<?php

namespace App\Exports;

use App\Models\CenterPolicy;
use App\Models\KPI;
use App\Traits\LaravelExportPropertiesTrait;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithProperties;

class PolicyClauseExport implements FromCollection, WithMapping, WithHeadings, WithProperties
{

    use LaravelExportPropertiesTrait; // This trait implement properties function required by (WithProperties)
    private $counter = 1;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return CenterPolicy::with([
            'documents'
        ])->get();
    }

    /**
     * @var KPI $KPI
     */
    public function map($policy): array
    {
 
        $documentNames = $policy->documents->pluck('document_name')->implode(', ');
 
        return [
            $this->counter++,
            $policy->policy_name,
            $documentNames

        ];
    }



    public function headings(): array
    {
        return [
            __('locale.#'),
            __('locale.PolicyClause'),
            __('locale.Document'),
        ];
    }
}
