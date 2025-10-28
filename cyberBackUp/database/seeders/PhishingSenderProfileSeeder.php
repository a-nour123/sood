<?php

namespace Database\Seeders;

use App\Models\PhishingDomains;
use App\Models\PhishingSenderProfile;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
class PhishingSenderProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $domains = PhishingDomains::take(10)->get();
        $faker = Faker::create();
        foreach ($domains as $domain) {
            $type = ['own', 'managed'][array_rand(['own', 'managed'])];
            PhishingSenderProfile::create([
                'name' =>  $faker->unique()->name(),
                'from_display_name' => $faker->firstName(),
                'type' => $type,
                'from_address_name' => $type === 'managed' ? $faker->unique()->lastName() : $faker->unique()->safeEmail(),
                'website_domain_id' => $type === 'managed' ? $domain->id : null,
            ]);
        }
    }
}

