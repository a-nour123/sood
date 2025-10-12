<?php

namespace Database\Seeders;

use App\Models\ControlPhase;
use Illuminate\Database\Seeder;

class ControlPhaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ControlPhase::create([
            "id" => 1,
            "name" => 'Physical'
        ]);
        ControlPhase::create([
            "id" => 2,
            "name" => 'Procedural'
        ]);
        ControlPhase::create([
            "id" => 3,
            "name" => 'Technical'
        ]);
        ControlPhase::create([
            "id" => 4,
            "name" => 'Legal and Regulatory or Compliance'
        ]);
    }
}
