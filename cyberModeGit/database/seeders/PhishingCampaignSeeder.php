<?php

namespace Database\Seeders;

use App\Models\PhishingCampaign;
use App\Models\PhishingSenderProfile;
use App\Models\PhishingTemplate;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
class PhishingCampaignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $timeZones = [
            'UTC',
            'America/New_York',
            'Europe/London',
            'Asia/Riyadh',
            'Australia/Sydney',
        ];

        for ($i=0; $i <10 ; $i++) {
            PhishingCampaign::create([
                'campaign_name' => $faker->unique()->name(),
                'campaign_type' => ['simulated_phishing', 'security_awareness','simulated_phishing_and_security_awareness'][array_rand(['simulated_phishing', 'security_awareness','simulated_phishing_and_security_awareness'])],
                'training_frequency' => ['daily', 'weekly','monthly','quarterly','annually'][array_rand(['daily', 'weekly','monthly','quarterly','annually'])],
                'expire_after' => now()->addDays(rand(1,10)),
                'sssignment_schedule' => ['immediatly', 'setup_schedule'][array_rand(['immediatly', 'setup_schedule'])],
                'sssignment_date' => now()->addDays(rand(1,10)),
                'sssignment_time' => now()->addDays(rand(1,10)),
                'delivery_type' => ['immediatly', 'setup','later'][array_rand(['immediatly', 'setup','later'])],
                'schedule_date_from' => now()->addDays(rand(1,10)),
                'schedule_date_to' => now()->addDays(rand(1,10)),
                'schedule_time_from' => now()->addHours(rand(1,10)),
                'schedule_time_to' => now()->addHours(rand(1,10)),
                'campaign_frequency' => ['oneOf','weekly', 'monthly','quarterly'][array_rand(['oneOf','weekly', 'monthly','quarterly'])],
                'days_until_due' => rand(1,50),
                'assignments' => ['all', 'one'][array_rand(['all', 'one'])],
                'approve' => [0, 1][array_rand([0, 1])],
                'delivery_status' => [0, 1][array_rand([0, 1])],
                'time_zone' => $timeZones[array_rand($timeZones)],
            ]);
        }
    }
}
