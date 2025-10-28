<?php

namespace Database\Seeders;

use App\Models\RiskFunction;
use Illuminate\Database\Seeder;

class RiskFunctionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RiskFunction::create([
            "id" => 1,
            "name" => 'Identify'
        ]);
        RiskFunction::create([
            "id" => 2,
            "name" => 'Protect'
        ]);
        RiskFunction::create([
            "id" => 3,
            "name" => 'Detect'
        ]);
        RiskFunction::create([
            "id" => 4,
            "name" => 'Respond'
        ]);
        RiskFunction::create([
            "id" => 5,
            "name" => 'Recover'
        ]);
    }
}
