<?php

namespace Database\Seeders;

use App\Models\RiskGrouping;
use Illuminate\Database\Seeder;

class RiskGroupingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RiskGrouping::create([
            "id" => 1,
            "name" => 'Access Control'
        ]);
        RiskGrouping::create([
            "id" => 2,
            "name" => 'Asset Management'
        ]);
        RiskGrouping::create([
            "id" => 3,
            "name" => 'Business Continuity'
        ]);
        RiskGrouping::create([
            "id" => 4,
            "name" => 'Exposure'
        ]);
        RiskGrouping::create([
            "id" => 5,
            "name" => 'Governance'
        ]);
        RiskGrouping::create([
            "id" => 6,
            "name" => 'Situational Awareness'
        ]);
        RiskGrouping::create([
            "id" => 7,
            "name" => 'Incident Response'
        ]);
    }
}
