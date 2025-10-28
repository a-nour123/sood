<?php

namespace Database\Seeders;

use App\Models\PhishingLandingPage;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
class PhishingLandingPageTableSeeder extends Seeder
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
            $type = ['own', 'managed'][array_rand(['own', 'managed'])];
            PhishingLandingPage::create([
                'name' => $faker->unique()->name(),
                'description' => $faker->text(),
                'type' => $type,
                'website_domain_name' => $faker->domainName,
                'website_url' => $faker->url(),
                'website_domain_id' => $faker->numberBetween(1,10),
                'website_page_id' => $faker->numberBetween(1,10),
            ]);
        }

    }
}
