<?php

namespace App\Exports;

use App\Models\Vulnerability;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class VulnerabilitiesExport implements FromCollection, WithMapping, WithHeadings
{
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
        try {
            // Teams
            $teamNames = $vulnerability->teams->pluck('name')->toArray();

            // Assets
            $assetNames = $vulnerability->assets->pluck('name')->toArray();
            $assetIps   = $vulnerability->assets->pluck('ip')->toArray();

            // Asset Groups (categories)
            $assetGroups = $vulnerability->assets->flatMap(function ($asset) {
                return $asset->assetGroups->pluck('name');
            })->unique()->toArray();

            // Host Regions
            $regions = $vulnerability->assets->flatMap(function ($asset) {
                return $asset->hostRegions->pluck('name');
            })->unique()->toArray();

            return [
                $this->counter++,
                $vulnerability->id,
                $vulnerability->name,
                $vulnerability->cve,
                $vulnerability->plugin_id,
                implode(', ', $assetNames),
                implode(', ', $teamNames),
                implode(', ', $assetGroups), // Asset categories
                implode(', ', $regions),     // Regions
                implode(', ', $assetIps),    // Asset IPs
                $vulnerability->severity,
                $vulnerability->status,
                $vulnerability->tenable_status,
                $vulnerability->port,
                $vulnerability->exploit,
                $vulnerability->first_discovered,
                $vulnerability->last_observed,
                $vulnerability->description ?? '',
                optional($vulnerability->assets->first())->owner_email ?? '',
            ];
        } catch (\Throwable $e) {
            // Log the error with context
            Log::error('VulnerabilitiesExport map() failed', [
                'vulnerability_id' => $vulnerability->id ?? null,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                $this->counter++,
                $vulnerability->id ?? 'N/A',
                'Error: ' . $e->getMessage(),
                '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '',
            ];
        }
    }

    /**
     * Headings for the export.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            '#',
            'ID',
            'Name',
            'CVE',
            'PluginId',
            'Assets',
            'Teams',
            'Asset Categories',
            'Regions',
            'Asset IPs',
            'Severity',
            'OwnerStatus',
            'TenableStatus',
            'Port',
            'Exploit',
            'FirstDiscovered',
            'LastObserved',
            'Description',
            'Owner Email',
        ];
    }
}