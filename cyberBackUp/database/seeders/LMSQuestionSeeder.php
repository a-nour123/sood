<?php

namespace Database\Seeders;

use App\Models\LMSCourse;
use App\Models\LMSQuestion;
use App\Models\LMSTrainingModule;
use App\Models\PhishingDomains;
use Illuminate\Database\Seeder;
use Str;
use Faker\Factory as Faker;

class LMSQuestionSeeder extends Seeder
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
            $type = ['multi_choise', 'true_or_false'][array_rand(['multi_choise', 'true_or_false'])];
            LMSQuestion::create([
                'question' => $faker->title(),
                'question_type' =>$type,
                'correct_answer' => $faker->title(),
                'training_module_id' => $faker->numberBetween(1, 10),
            ]);
        }
    }
}
