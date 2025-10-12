<?php

namespace App\Exports;

use App\Models\Asset;
use App\Traits\LaravelExportPropertiesTrait;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithProperties;

class AssetsExport implements FromCollection, WithMapping, WithHeadings, WithProperties
{
    use LaravelExportPropertiesTrait;

    private $assets;
    private $counter = 1;

    public function __construct(Collection $assets)
    {
        $this->assets = $assets;
    }

    public function collection()
    {
        return $this->assets;
    }

    public function map($asset): array
    {
        // Handle teams names with null check
        $assetTeamNames = '';
        if (method_exists($asset, 'teamsName') && $asset->teamsName()) {
            $teamNames = $asset->teamsName()->toArray();
            $assetTeamNames = !empty($teamNames) ? "(" . implode('), (', $teamNames) . ")" : '';
        }

        // Handle tags with null check
        $assetTagsNames = '';
        if (method_exists($asset, 'tags') && $asset->tags()->exists()) {
            $tags = $asset->tags()->pluck('tag')->toArray();
             $assetTagsNames = !empty($tags) ? "(" . implode('), (', $tags) . ")" : '';
        }

        return [
            $this->counter++,
            $asset->name ?? '',
            $asset->ip ?? '',
            $asset->assetCategory->name ?? '',
            $asset->location->name ?? '',
            $assetTeamNames,
            $assetTagsNames,
            $asset->details ?? '',
            $asset->url ?? '',
            $asset->assetOs->name ?? '',
            $asset->os_version ?? '',
            $asset->project_vlan ?? '',
            $asset->vlan ?? '',
            $asset->model ?? '',
            $asset->firmware ?? '',
            $asset->city ?? '',
            $asset->rack_location ?? '',
            $asset->mac_address ?? '',
            $asset->subnet_mask ?? '',
            $asset->Users->name ?? '',
            $asset->assetEnvironmentCategory->name ?? '',
            $asset->start_date ? Carbon::parse($asset->start_date)->format('Y-m-d') : '',
            $asset->expiration_date ? Carbon::parse($asset->expiration_date)->format('Y-m-d') : '',
            $asset->alert_period ?? '',
            $asset->created ? Carbon::parse($asset->created)->format('Y-m-d') : '',
            $asset->verified ? "verified" : 'Not verified',
        ];
    }

    public function headings(): array
    {
        return [
            __('locale.#'),
            __('locale.AssetName'),
            __('locale.IPAddress'),
            __('locale.Category'),
            __('locale.AssetSiteLocation'),
            __('locale.Teams'),
            __('locale.Tags'),
            __('locale.AssetDetails'),
            __('locale.Url'),
            __('locale.Os'),
            __('locale.Os Version'),
            __('locale.ProjectVlan'),
            __('locale.Vlan'),
            __('locale.Model'),
            __('locale.Firmware'),
            __('locale.City'),
            __('locale.RackLocation'),
            __('locale.MacAddress'),
            __('locale.SubnetMask'),
            __('locale.Users'),
            __('locale.AssetEnvironmentCategory'),
            __('locale.StartDate'),
            __('locale.EndDate'),
            __('locale.alert_period') . "(" . __('locale.days') . ")",
            __('locale.CreatedDate'),
            __('locale.VerifiedAssets'),
        ];
    }
}