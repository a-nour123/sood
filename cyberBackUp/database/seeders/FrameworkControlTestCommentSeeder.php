<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\FrameworkControlTestComment;
class FrameworkControlTestCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->faker = Faker::create();
        for($i=1;$i<100;$i++){
            FrameworkControlTestComment::create([
                 'test_audit_id' => $this->faker->numberBetween(1, 20),
                 'date' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
                 'user' => 1,
                 'comment' => $this->faker->sentence
             ]);
        }
    }
}
