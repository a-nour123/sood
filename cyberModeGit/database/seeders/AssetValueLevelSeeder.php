<?php

namespace Database\Seeders;

use App\Models\AssetValueLevel;
use Illuminate\Database\Seeder;

class AssetValueLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AssetValueLevel::create([
            'level'=>1,
            'name'=>'Very Low'
        ]);
        AssetValueLevel::create([
            'level'=>2,
            'name'=>'Low'
        ]);
        AssetValueLevel::create([
            'level'=>3,
            'name'=>'Medium'
        ]);
        AssetValueLevel::create([
            'level'=>4,
            'name'=>'High'
        ]);
        AssetValueLevel::create([
            'level'=>5,
            'name'=>'Very High'
        ]);
    }
}
