<?php

namespace Database\Seeders;

use App\Models\ContributingRisksLikelihood;
use Illuminate\Database\Seeder;

class ContributingRisksLikelihoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ContributingRisksLikelihood::create([
            "id" => 1,
            "value" => 1,
            "name" => 'Remota'
        ]);
        ContributingRisksLikelihood::create([
            "id" => 2,
            "value" => 2,
            "name" => 'Improbable'
        ]);
        ContributingRisksLikelihood::create([
            "id" => 3,
            "value" => 3,
            "name" => 'Creible'
        ]);
        ContributingRisksLikelihood::create([
            "id" => 4,
            "value" => 4,
            "name" => 'Probable'
        ]);
        ContributingRisksLikelihood::create([
            "id" => 5,
            "value" => 5,
            "name" => 'Casi Certero'
        ]);
    }
}
