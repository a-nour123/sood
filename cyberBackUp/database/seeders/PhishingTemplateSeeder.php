<?php

namespace Database\Seeders;

use App\Models\PhishingSenderProfile;
use App\Models\PhishingTemplate;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
class PhishingTemplateSeeder extends Seeder
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
            $inputFields = '';
            for ($j = 1; $j <= $i + 1; $j++) {
                $inputType = ['text', 'email', 'password', 'number'][array_rand(['text', 'email', 'password', 'number'])];
                $placeholder = ucfirst($inputType) . ' Input ' . $j;
                $inputFields .= '<input type="' . $inputType . '" name="input' . $j . '" placeholder="' . $placeholder . '" /><br/>';
            }
            $body = '<html><body><h1>' . $faker->word . ' Form</h1><form>' . $inputFields . '<button type="submit">Submit</button></form></body></html>';
            PhishingTemplate::create([
                'name' => $faker->unique()->name(),
                'description' => $faker->text(),
                'payload_type' => ['website', 'data_entry','attachment'][array_rand(['website', 'data_entry','attachment'])],
                'email_difficulty' => ['easy', 'modrate','hard'][array_rand(['easy', 'modrate','hard'])],
                'subject' => $faker->text(50),
                'body' => $body,
                'attachment' => asset('images/default.png'),
                'sender_profile_id' => $faker->numberBetween(1,10),
                'phishing_website_id' => $faker->numberBetween(1,10),
            ]);
        }
    }
}
