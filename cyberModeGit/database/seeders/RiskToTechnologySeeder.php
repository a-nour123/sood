<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\RiskToTechnology;
class RiskToTechnologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->faker = Faker::create();
        for($i=1;$i<19;$i++){
            RiskToTechnology::create([
                 'risk_id' => $this->faker->unique()->numberBetween(1, 20),
                 'technology_id' => $this->faker->numberBetween(1, 19),
             ]);
        }
    }
}
