<?php

namespace Database\Seeders;

use App\Models\PhishingDomains;
use Illuminate\Database\Seeder;
use Str;
use Faker\Factory as Faker;

class PhishingDomainsSeeder extends Seeder
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
            PhishingDomains::create([
                'name' => '@'.$faker->domainName(),
            ]);
        }
    }
}
