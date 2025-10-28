<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Mitigation;
class MitigationSeeder extends Seeder
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
            Mitigation::create([
                 'id'=>$i,
                 'submission_date' => $this->faker->dateTime($max = 'now', $timezone = null),
                 'last_update' => $this->faker->dateTime($max = 'now', $timezone = null),
                 'planning_strategy' => $this->faker->numberBetween($min = 1, $max = 5),
                 'mitigation_effort' => $this->faker->numberBetween($min = 1, $max = 5),
                 'mitigation_cost' => $this->faker->numberBetween($min = 1, $max = 99),
                 'mitigation_owner' => 1,
                 'current_solution' => $this->faker->word,
                 'security_requirements' => $this->faker->word,
                 'security_recommendations' => $this->faker->word,
                 'planning_date' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
                 'mitigation_percent' => $this->faker->numberBetween($min = 1, $max = 99),
                 'risk_id' => $this->faker->numberBetween($min = 1, $max = 20),
             ]);
        }
    }
}
