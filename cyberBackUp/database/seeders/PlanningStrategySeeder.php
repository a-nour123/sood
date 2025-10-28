<?php

namespace Database\Seeders;

use App\Models\PlanningStrategy;
use Illuminate\Database\Seeder;

class PlanningStrategySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PlanningStrategy::create([
            "id" => 1,
            "name" => 'Investigate'
        ]);
        PlanningStrategy::create([
            "id" => 2,
            "name" => 'Accepted'
        ]);
        PlanningStrategy::create([
            "id" => 3,
            "name" => 'Mitigated'
        ]);
        PlanningStrategy::create([
            "id" => 4,
            "name" => 'To see'
        ]);
        PlanningStrategy::create([
            "id" => 5,
            "name" => 'Transfer'
        ]);
    }
}
