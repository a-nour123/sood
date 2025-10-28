<?php

namespace Database\Seeders;

use App\Models\LMSCourse;
use App\Models\LMSQuestion;
use App\Models\LMSStatement;
use App\Models\LMSTrainingModule;
use App\Models\PhishingDomains;
use Illuminate\Database\Seeder;
use Str;
use Faker\Factory as Faker;

class LMSStatementSeeder extends Seeder
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
            $type = ['no', 'video','image','spot','navbar'][array_rand(['no', 'video','image','spot','navbar'])];
            LMSStatement::create([
                'title' => $faker->title(),
                'content' =>$faker->text,
                'additional_content' => $type,
                'training_module_id' => $faker->numberBetween(1, 10),
            ]);
        }
    }
}
