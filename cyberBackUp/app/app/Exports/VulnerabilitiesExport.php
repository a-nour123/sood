<?php

namespace App\Exports;

use App\Models\Vulnerability;
use App\Traits\LaravelExportPropertiesTrait;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithProperties;

class VulnerabilitiesExport implements FromCollection, WithMapping, WithHeadings, WithProperties
{
    use LaravelExportPropertiesTrait; // This trait implements the properties function required by WithProperties

    private $counter = 1;
    private $vulnerabilities;

    /**
     * @param Collection $vulnerabilities
     */
    public function __construct(Collection $vulnerabilities)
    {
        $this->vulnerabilities = $vulnerabilities;
    }

    /**
     * @return Collection
     */
    public function collection(): Collection
    {
        return $this->vulnerabilities;
    }

    /**
     * @var Vulnerability $vulnerability
     */
    public function map($vulnerability): array
    {
        // Map teams and assets
        $teamNames = $vulnerability->teams->pluck('name')->toArray();
        $assetNames = $vulnerability->assets->pluck('name')->toArray();

        $vulnerabilityTeamNames = count($teamNames) ? implode(', ', $teamNames) : '';
        $vulnerabilityAssetNames = count($assetNames) ? implode(', ', $assetNames) : '';

        return [
            $this->counter++,
            $vulnerability->name,
            $vulnerability->cve,
            $vulnerability->plugin_id,
            $vulnerabilityAssetNames,
            $vulnerability->severity,
            $vulnerability->status,
            $vulnerability->tenable_status,
            $vulnerability->port,
            $vulnerability->exploit,
            $vulnerability->first_discovered
        ];
    }

    /**
     * Headings for the Excel export.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            __('locale.#'),
            __('locale.Name'),
            __('locale.CVE'),
            __('locale.PluginId'),
            __('locale.Assets'),
            __('locale.Severity'),
            __('locale.OwnerStatus'),
            __('locale.TenableStatus'),
            __('locale.Port'),
            __('locale.Exploit'),
            __('locale.firstDiscovered')
        ];
    }
}
