<?php

namespace Database\Seeders;

use App\Models\ContributingRisksImpact;
use Illuminate\Database\Seeder;

class ContributingRisksImpactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ContributingRisksImpact::create([
            "id" => 1,
            "contributing_risks_id" => 1,
            "value" => 1,
            "name" => 'Insignificante'
        ]);
        ContributingRisksImpact::create([
            "id" => 2,
            "contributing_risks_id" => 2,
            "value" => 1,
            "name" => 'Insignificante'
        ]);
        ContributingRisksImpact::create([
            "id" => 3,
            "contributing_risks_id" => 3,
            "value" => 1,
            "name" => 'Insignificante'
        ]);
        ContributingRisksImpact::create([
            "id" => 4,
            "contributing_risks_id" => 4,
            "value" => 1,
            "name" => 'Insignificante'
        ]);
        ContributingRisksImpact::create([
            "id" => 5,
            "contributing_risks_id" => 1,
            "value" => 2,
            "name" => 'Menor'
        ]);
        ContributingRisksImpact::create([
            "id" => 6,
            "contributing_risks_id" => 2,
            "value" => 2,
            "name" => 'Menor'
        ]);
        ContributingRisksImpact::create([
            "id" => 7,
            "contributing_risks_id" => 3,
            "value" => 2,
            "name" => 'Menor'
        ]);
        ContributingRisksImpact::create([
            "id" => 8,
            "contributing_risks_id" => 4,
            "value" => 2,
            "name" => 'Menor'
        ]);
        ContributingRisksImpact::create([
            "id" => 9,
            "contributing_risks_id" => 1,
            "value" => 3,
            "name" => 'Moderado'
        ]);
        ContributingRisksImpact::create([
            "id" => 10,
            "contributing_risks_id" => 2,
            "value" => 3,
            "name" => 'Moderado'
        ]);
        ContributingRisksImpact::create([
            "id" => 11,
            "contributing_risks_id" => 3,
            "value" => 3,
            "name" => 'Moderado'
        ]);
        ContributingRisksImpact::create([
            "id" => 12,
            "contributing_risks_id" => 4,
            "value" => 3,
            "name" => 'Moderado'
        ]);
        ContributingRisksImpact::create([
            "id" => 13,
            "contributing_risks_id" => 1,
            "value" => 4,
            "name" => 'Mayor'
        ]);
        ContributingRisksImpact::create([
            "id" => 14,
            "contributing_risks_id" => 2,
            "value" => 4,
            "name" => 'Mayor'
        ]);
        ContributingRisksImpact::create([
            "id" => 15,
            "contributing_risks_id" => 3,
            "value" => 4,
            "name" => 'Mayor'
        ]);
        ContributingRisksImpact::create([
            "id" => 16,
            "contributing_risks_id" => 4,
            "value" => 4,
            "name" => 'Mayor'
        ]);
        ContributingRisksImpact::create([
            "id" => 17,
            "contributing_risks_id" => 1,
            "value" => 5,
            "name" => 'Extremo/Catastrofico'
        ]);
        ContributingRisksImpact::create([
            "id" => 18,
            "contributing_risks_id" => 2,
            "value" => 5,
            "name" => 'Extremo/Catastrofico'
        ]);
        ContributingRisksImpact::create([
            "id" => 19,
            "contributing_risks_id" => 3,
            "value" => 5,
            "name" => 'Extremo/Catastrofico'
        ]);
        ContributingRisksImpact::create([
            "id" => 20,
            "contributing_risks_id" => 4,
            "value" => 5,
            "name" => 'Extremo/Catastrofico'
        ]);
    }
}
