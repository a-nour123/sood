<?php

namespace Database\Seeders;

use App\Models\ThreatGrouping;
use Illuminate\Database\Seeder;

class ThreatGroupingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ThreatGrouping::create([
            "id" => 1,
            "name" => 'Natural Threat'
        ]);
        ThreatGrouping::create([
            "id" => 2,
            "name" => 'Man-Made Threat'
        ]);
    }
}
