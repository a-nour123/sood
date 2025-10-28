<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\RiskToLocation;
class RiskToLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->faker = Faker::create();
        for($i=1;$i<21;$i++){
            RiskToLocation::create([
                 'risk_id'=>$i,
                 'location_id' => $i,
             ]);
        }
    }
}
