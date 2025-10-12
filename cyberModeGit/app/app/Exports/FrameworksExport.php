<?php

namespace App\Exports;

use App\Models\Framework;
use App\Traits\LaravelExportPropertiesTrait;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithProperties;

class FrameworksExport implements FromCollection, WithMapping, WithHeadings, WithProperties
{
    use LaravelExportPropertiesTrait; // This trait implements properties function required by (WithProperties)
    private $counter = 1;
    private $headings = [];
    private $rows = [];

    public function __construct()
    {
        $frameworks = Framework::with(['only_families', 'only_sub_families'])->get();

        foreach ($frameworks as $framework) {
            foreach ($framework->only_families as $family) {
                $domainSubDomains = [];

                foreach ($framework->only_sub_families as $subDomain) {
                    if ($family->id == $subDomain->parent_id) {
                        $domainSubDomains[] = $subDomain->name;
                    }
                }

                $this->rows[] = [
                    'framework' => $framework->name,
                    'description' => $framework->description,
                    'domain' => $family->name,
                    'sub_domains' => implode(', ', $domainSubDomains),
                ];
            }
        }

        $this->headings = [
            __('locale.#'),
            __('locale.FrameworkName'),
            __('locale.Description'),
            __('locale.Domain'),
            __('locale.SubDomains'),
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return collect($this->rows);
    }

    /**
     * @var array $row
     */
    public function map($row): array
    {
        return [
            $this->counter++,
            $row['framework'],
            $row['description'],
            $row['domain'],
            $row['sub_domains'],
        ];
    }

    public function headings(): array
    {
        return $this->headings;
    }
}
