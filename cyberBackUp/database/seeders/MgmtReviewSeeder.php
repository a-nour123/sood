<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\MgmtReview;

class MgmtReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->faker = Faker::create();
        for ($i = 1; $i <= 20; $i++) {
            MgmtReview::create([
                "id" => $i,
                "risk_id" => $i,
                "submission_date" => $this->faker->dateTime(null, null),
                "review" =>  $this->faker->randomElement([1, 2]), // from ReviewSeeder
                "reviewer" =>  1,
                "next_step_id" =>  $this->faker->randomElement([1, 3]), // from NextStepSeeder
                "comments" =>  $this->faker->sentence,
                "next_review" =>  $this->faker->dateTime(null, null)
            ]);
        }
    }
}
