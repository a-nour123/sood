<?php

namespace Database\Seeders;

use App\Models\PhishingDomains;
use App\Models\PhishingWebsitePage;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
class PhishingWebsitePagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $domains = PhishingDomains::take(10)->get();

        foreach ($domains as $domain) {
            $type = ['own', 'managed'][array_rand(['own', 'managed'])];
          
            PhishingWebsitePage::create([
                'name' => $faker->catchPhrase,
                'html_code' => '<html><body><h1>' . $faker->word . ' Login</h1><form><input type="text" name="username" placeholder="' . $faker->userName . '" /><input type="password" name="password" placeholder="Password" /><button type="submit">Login</button></form></body></html>',
                'cover' => asset('images/default.png'), // Use the image path
                'phishing_category_id' => $faker->numberBetween(1, 4),

                'type' => $type,
                'from_address_name' => $type === 'managed' ? $faker->unique()->lastName() : $faker->unique()->safeEmail(),
                'domain_id' => $type === 'managed' ? $domain->id : null,
            ]);
        }
    }
}
