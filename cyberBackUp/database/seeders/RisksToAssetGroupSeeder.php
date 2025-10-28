<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RisksToAssetGroup;
class RisksToAssetGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        for($i=11;$i<20;$i++){
            RisksToAssetGroup::create([
                "asset_group_id" => $i,
                "risk_id" =>$i,
             ]);
         }
    }
}
