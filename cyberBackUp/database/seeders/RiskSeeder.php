<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Risk;
use App\Models\RiskScoring;

class RiskSeeder extends Seeder
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
            $risk = Risk::create([
                 'id'=>$i,
                 'status' => $this->faker->randomElement(['Closed', 'Opened']),
                 'subject' => $this->faker->word,
                 'close_id' => $i,
                 'source_id' => $this->faker->numberBetween(1, 4),
                 'category_id' => $this->faker->numberBetween(1, 8),
                //  'owner_id' => $this->faker->numberBetween(1, 62),
                //  'manager_id' => $this->faker->numberBetween(1, 62),
                //  'mitigation_id' => $this->faker->randomElement([null, 1,2,3,4,5,6,7,8,9,10]),
                //  'mgmt_review' => $this->faker->randomElement([null, 1,2,3,4,5,6,7,8,9,10]),
             ]);

             submit_risk_scoring($risk->id, 1, 1, 3);
        }

        for ($i=1; $i <= 5; $i++) {
            $risk = Risk::create([
                'subject' => 'Risk ' . $i . ' Subject',
            ]);

            submit_risk_scoring($risk->id, 1, $i, $i);
        }

    }
}
