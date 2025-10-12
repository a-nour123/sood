<?php

namespace Database\Seeders;

use App\Models\Impact;
use Illuminate\Database\Seeder;

class ImpactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Impact::create([
            "id" => 1,
            "name" => 'Insignificant'
        ]);
        Impact::create([
            "id" => 2,
            "name" => 'Minor'
        ]);
        Impact::create([
            "id" => 3,
            "name" => 'Moderate'
        ]);
        Impact::create([
            "id" => 4,
            "name" => 'Major'
        ]);
        Impact::create([
            "id" => 5,
            "name" => 'Extreme/Catastrophic'
        ]);
    }
}
