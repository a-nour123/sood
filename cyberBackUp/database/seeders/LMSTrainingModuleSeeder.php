<?php

namespace Database\Seeders;

use App\Models\LMSCourse;
use App\Models\LMSTrainingModule;
use App\Models\PhishingDomains;
use Illuminate\Database\Seeder;
use Str;
use Faker\Factory as Faker;

class LMSTrainingModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for ($i = 1; $i <= 10; $i++) {
            LMSTrainingModule::create([
                'name' => $faker->name,
                'passing_score' =>$faker->numberBetween(70,75),
                'completion_time' => $faker->numberBetween(10, 15),
                'cover_image' => asset('images/default.png'),
                'cover_image_url' => asset('images/default.png'),
                'level_id' => $faker->numberBetween(1, 10),

            ]);
        }
    }
}
