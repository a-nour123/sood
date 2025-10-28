<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ControlOwner;
use Faker\Factory as Faker;
class ControlOwnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->faker = Faker::create();
        for ($i = 1; $i <= 21; $i++) {
            ControlOwner::create([
                "name" => $this->faker->unique()->word,
            ]);
        }
    }
}
