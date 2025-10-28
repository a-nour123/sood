<?php

namespace Database\Seeders;

use App\Models\LMSCourse;
use App\Models\LMSLevel;
use App\Models\PhishingDomains;
use Illuminate\Database\Seeder;
use Str;
use Faker\Factory as Faker;

class LMSLevelSeeder extends Seeder
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
            LMSLevel::create([
                'title' => $faker->unique()->name(),
                'order' => $i,
                'course_id' => $faker->numberBetween(1,5),
            ]);
        }
    }
}
