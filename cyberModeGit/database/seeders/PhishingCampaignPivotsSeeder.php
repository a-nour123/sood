<?php

namespace Database\Seeders;

use App\Models\PhishingCampaign;
use App\Models\PhishingTemplate;
use App\Models\User;
use Illuminate\Database\Seeder;

class PhishingCampaignPivotsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // is_delivered
        $mailTemplates = PhishingTemplate::take(10)->get();
        $users = User::take(10)->get();
        PhishingCampaign::each(function ($campaign) use ($users,$mailTemplates) {
            $campaign->emailTemplates()->attach(
                $mailTemplates->random(2)->pluck('id')->toArray(),
                ['is_delivered' => [0, 1][array_rand([0, 1])]]
            );
            $campaign->employees()->attach(
                $users->random(2)->pluck('id')->toArray(),
                ['is_delivered' => [0, 1][array_rand([0, 1])]]
            );
        });
    }
}
