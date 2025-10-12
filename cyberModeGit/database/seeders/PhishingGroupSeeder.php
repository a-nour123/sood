<?php

namespace Database\Seeders;

use App\Models\PhishingGroup;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
class PhishingGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for ($i=0; $i <10 ; $i++) {
            PhishingGroup::create([
                'name' => $faker->name,
            ]);
        }
    }
}
