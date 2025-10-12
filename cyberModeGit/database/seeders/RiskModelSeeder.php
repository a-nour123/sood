<?php

namespace Database\Seeders;

use App\Models\RiskModel;
use Illuminate\Database\Seeder;

class RiskModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RiskModel::create([
            "id" => 1,
            "name" => 'Likelihood x Impact + 2(Impact)'
        ]);
        RiskModel::create([
            "id" => 2,
            "name" => 'Likelihood x Impact + Impact'
        ]);
        RiskModel::create([
            "id" => 3,
            "name" => 'Likelihood x Impact'
        ]);
        RiskModel::create([
            "id" => 4,
            "name" => 'Likelihood x Impact + Likelihood'
        ]);
        RiskModel::create([
            "id" => 5,
            "name" => 'Likelihood x Impact + 2(Likelihood)'
        ]);
        // RiskModel::create([
        //     "id" => 6,
        //     "name" => 'Custom'
        // ]);
        // TODO: Take decision if Custom will deleted at all
    }
}
