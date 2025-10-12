<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssetHostRegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $assetIds = range(1, 20);
        $regionIds = range(1, 12);

        $regionCount = count($regionIds);

        foreach ($assetIds as $index => $assetId) {
            $regionId = $regionIds[$index % $regionCount]; // Cycle through region IDs

            DB::table('asset_host_region')->insert([
                'asset_id' => $assetId,
                'host_region_id' => $regionId,
            ]);
        }
    }
}
