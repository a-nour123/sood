<?php

namespace Database\Seeders;

use App\Models\ContributingRisk;
use Illuminate\Database\Seeder;

class ContributingRiskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ContributingRisk::create([
            "id" => 1,
            "subject" => 'Safety',
            "weight" =>  0.25
        ]);
        ContributingRisk::create([
            "id" => 2,
            "subject" => 'SLA',
            "weight" =>  0.25
        ]);
        ContributingRisk::create([
            "id" => 3,
            "subject" => 'Financial',
            "weight" =>  0.25
        ]);
        ContributingRisk::create([
            "id" => 4,
            "subject" => 'Reputation',
            "weight" =>  0.25
        ]);
    }
}
