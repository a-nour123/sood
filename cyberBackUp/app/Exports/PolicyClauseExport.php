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
        // Handle policy_name as array or JSON
        $policyNameEn = '';
        $policyNameAr = '';
        $policyName = $policy->getRawOriginal('policy_name');
        if (is_array($policyName)) {
            $policyNameEn = $policy->policy_name['en'] ?? '';
            $policyNameAr = $policy->policy_name['ar'] ?? '';
        } elseif (is_string($policyName)) {
            // Try to decode JSON
            $decoded = json_decode($policyName, true);
            if (is_array($decoded)) {
                $policyNameEn = $decoded['en'] ?? '';
                $policyNameAr = $decoded['ar'] ?? '';
            } else {
                $policyNameEn = $policy->policy_name;
            }
        }
        return [
            $this->counter++,
            $policyNameEn,
            $policyNameAr,
            $documentNames
        ];
    }



    public function headings(): array
    {
        return [
            __('locale.#'),
            __('locale.PolicyClauseEn'),
            __('locale.PolicyClauseAr'),
            __('locale.Document'),
        ];
    }
}