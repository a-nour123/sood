<?php

namespace Database\Seeders;

use App\Models\PhishingCampaign;
use App\Models\PhishingMailTracking;
use App\Models\PhishingTemplate;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PhishingCampaignTrackingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for ($i=0; $i <50 ; $i++) {
            PhishingMailTracking::updateOrCreate([
                'email_id' => $faker->numberBetween(1,10),
                'employee_id' => $faker->numberBetween(1,10),
            ],[
                'submited_at' => [now(), null][array_rand([now(), null])],
                'downloaded_at' => [now(), null][array_rand([now(), null])],
                'opened_at' => [now(), null][array_rand([now(), null])],
            ]);
        }
    }
}
