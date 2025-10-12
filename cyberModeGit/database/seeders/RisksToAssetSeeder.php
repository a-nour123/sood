<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RisksToAsset;

class RisksToAssetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 20; $i++) {
            RisksToAsset::create([
                'risk_id' => $i,
                'asset_id' => $i,
            ]);
        }
    }
}
