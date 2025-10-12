<?php

namespace Database\Seeders;

use App\Models\AssetValueCategory;
use Illuminate\Database\Seeder;

class AssetValueCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AssetValueCategory::create([
            'name'=>'Confidentiality'
        ]);
        AssetValueCategory::create([
            'name'=>'Integrity'
        ]);
        AssetValueCategory::create([
            'name'=>'Availability',
            'type'=>1
        ]);

    }
}
