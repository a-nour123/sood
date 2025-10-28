<?php

namespace App\Exports;

use App\Models\Family;
use App\Traits\LaravelExportPropertiesTrait;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithProperties;

class DomainsExport implements FromCollection, WithMapping, WithHeadings, WithProperties
{

    use LaravelExportPropertiesTrait; // This trait implement properties function required by (WithProperties)
    private $counter = 1;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Family::with('parentFamily', 'families')->get();
        $domains = Family::with('parentFamily', 'families')->get()->map(function ($domain) {
            return (object)[
                'responsive_id' =>  $domain->id,
                'name' => $domain->name,
                // 'number' => $domain->number,
                'order' => $domain->order,
                'parent' => ($domain->parentFamily) ? ($domain->parentFamily)->name : '',
                'domains' => $domain->familiesOlny()->pluck('name'),
                'Actions' => $domain->id,
            ];
        });
    }

    /**
     * @var Family $domain
     */
    public function map($domain): array
    {
        $domainDomainsNames = $domain->familiesOlny()->pluck('name');
        if (count($domainDomainsNames))
            // $domainDomainsNames =  "(" . implode('), (', $domainDomainsNames->toArray()) . ")";
            $domainDomainsNames =  implode(', ', $domainDomainsNames->toArray());
        else
            $domainDomainsNames = '';
        return [
            $this->counter++,
            $domain->name,
            $domain->order,
            $domain->parentFamily ? $domain->parentFamily->name : '',
            $domainDomainsNames
        ];
    }


    public function headings(): array
    {
        return [
            __('locale.#'),
            __('locale.Name'),
            __('locale.Order'),
            __('locale.Domain'),
            __('locale.sub_domains'),
        ];
    }
}
