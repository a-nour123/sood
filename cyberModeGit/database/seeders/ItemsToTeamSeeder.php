<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\ItemsToTeam;

class ItemsToTeamSeeder extends Seeder
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
            ItemsToTeam::create([
                'type' => 'test',
                'item_id' =>  $i,
                'team_id' =>  $this->faker->numberBetween($min = 1, $max = 10),
            ]);
        }
    }
}
