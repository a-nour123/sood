<?php

namespace Database\Seeders;

use App\Models\AssetGroup;
use Illuminate\Database\Seeder;

class AssetGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 20; $i++)
            AssetGroup::create([
                'id'=>$i,
                'name' => 'Asset Group ' . $i
            ]);
    }
}
