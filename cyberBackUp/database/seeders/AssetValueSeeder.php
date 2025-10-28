<?php

namespace Database\Seeders;

use App\Models\AssetValue;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class AssetValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AssetValue::create([
            "id" => 1,
            "min_value" => 0,
            "max_value" => 100000,
            "valuation_level_name" =>  ''
        ]);
        AssetValue::create([
            "id" => 2,
            "min_value" => 100001,
            "max_value" => 200000,
            "valuation_level_name" =>  ''
        ]);
        AssetValue::create([
            "id" => 3,
            "min_value" => 200001,
            "max_value" => 300000,
            "valuation_level_name" =>  ''
        ]);
        AssetValue::create([
            "id" => 4,
            "min_value" => 300001,
            "max_value" => 400000,
            "valuation_level_name" =>  ''
        ]);
        AssetValue::create([
            "id" => 5,
            "min_value" => 400001,
            "max_value" => 500000,
            "valuation_level_name" =>  ''
        ]);
        AssetValue::create([
            "id" => 6,
            "min_value" => 500001,
            "max_value" => 600000,
            "valuation_level_name" =>  ''
        ]);
        AssetValue::create([
            "id" => 7,
            "min_value" => 600001,
            "max_value" => 700000,
            "valuation_level_name" =>  ''
        ]);
        AssetValue::create([
            "id" => 8,
            "min_value" => 700001,
            "max_value" => 800000,
            "valuation_level_name" =>  ''
        ]);
        AssetValue::create([
            "id" => 9,
            "min_value" => 800001,
            "max_value" => 900000,
            "valuation_level_name" =>  ''
        ]);
        AssetValue::create([
            "id" => 10,
            "min_value" => 900001,
            "max_value" => 1000000,
            "valuation_level_name" =>  ''
        ]);
    }
}
