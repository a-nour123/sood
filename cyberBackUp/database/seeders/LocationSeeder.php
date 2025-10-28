<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 21; $i++) {
            Location::create([
                "id" => $i,
                "name" => 'Location ' . $i
            ]);
        }

        // Location::create([
        //     "id" => 1,
        //     "name" => 'Todas las Locaciones'
        // ]);
    }
}
