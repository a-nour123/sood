<?php

namespace Database\Seeders;

use App\Models\LMSCourse;
use App\Models\PhishingDomains;
use Illuminate\Database\Seeder;
use Str;
use Faker\Factory as Faker;

class LMSCourseSeeder extends Seeder
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
            LMSCourse::create([
                'title' => $faker->unique()->name(),
                'description' => $faker->text(),
                'image' => asset('images/default.png'),
            ]);
        }
    }
}
