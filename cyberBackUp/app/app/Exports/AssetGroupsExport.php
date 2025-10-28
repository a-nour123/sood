<?php

namespace App\Exports;

use App\Models\AssetGroup;
use App\Traits\LaravelExportPropertiesTrait;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithProperties;

class AssetGroupsExport implements FromCollection, WithMapping, WithHeadings, WithProperties
{
    use LaravelExportPropertiesTrait; // This trait implement properties function required by (WithProperties)

    private $counter = 1;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return AssetGroup::get();
    }

    /**
     * @var AssetGroup $assetGroup
     */
    public function map($assetGroup): array
    {
        $assetGroupAssetsNames = $assetGroup->assets()->pluck('name');
        if (count($assetGroupAssetsNames))
            $assetGroupAssetsNames =  "(" . implode('), (', $assetGroupAssetsNames->toArray()) . ")";

        else
            $assetGroupAssetsNames = '';

        return [
            $this->counter++,
            $assetGroup->name,
            $assetGroupAssetsNames
        ];
    }


    public function headings(): array
    {
        return [
            __('locale.#'),
            __('locale.AssetGroupName'),
            __('locale.Assets')
        ];
    }
}
