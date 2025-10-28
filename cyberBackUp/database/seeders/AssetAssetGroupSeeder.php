<?php

namespace Database\Seeders;

use App\Models\AssetAssetGroup;
use Illuminate\Database\Seeder;

class AssetAssetGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 20; $i++)
            AssetAssetGroup::create([
                'asset_id' => $i,
                'asset_group_id' => $i,
            ]);
    }
}
